<?php
namespace App\Http\Controllers;

use Auth;
use Gate;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Xpressengine\Editor\EditorHandler;
use Xpressengine\Http\Request;
use Xpressengine\Media\Models\Image;
use Xpressengine\Media\Models\Media;
use Xpressengine\Permission\Instance;
use Xpressengine\Permission\PermissionSupport;
use Xpressengine\Presenter\RendererInterface;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\Support\Exceptions\InvalidArgumentException;
use XeConfig;
use XeEditor;
use XeMenu;
use XeMedia;
use XePresenter;
use XeUser;
use XeStorage;
use XeTag;

class EditorController extends Controller
{
    use PermissionSupport;
    
    public function setting(Request $request, $instanceId)
    {
        $editorId = $request->get('editorId');
        if (empty($editorId)) {
            $editorId = null;
        }

        XeEditor::setInstance($instanceId, $editorId);

        if (!$url = XeMenu::getInstanceSettingURIByItemId($instanceId)) {
            return redirect()->back();
        } else {
            return redirect($url);
        }
    }

    public function getDetailSetting($instanceId)
    {
        $config = XeConfig::getOrNew(XeEditor::getConfigKey($instanceId));

        $tools = XeEditor::getToolAll();

        $toolIds = $config->get('tools', []);
        $activated = array_intersect_key($tools, array_flip($toolIds));
        $activated = array_merge(array_flip($toolIds), $activated);
        $deactivated = array_diff_key($tools, array_flip($toolIds));

        $items = [];
        foreach ($activated as $key => $item) {
            $items[$key] = ['class' => $item, 'activated' => true];
        }
        foreach ($deactivated as $key => $item) {
            $items[$key] = ['class' => $item, 'activated' => false];
        }

        return XePresenter::make('editor.detail', [
            'instanceId' => $instanceId,
            'config' => $config,
            'permArgs' => $this->getPermArguments(
                XeEditor::getPermKey($instanceId),
                ['html', 'tool', 'upload', 'download']
            ),
            'items' => $items,
        ]);
    }

    public function postDetailSetting(Request $request, $instanceId)
    {
        $this->validate($request, [
            'height' => 'required|numeric',
            'fontSize' => 'required',
            'fileMaxSize' => 'numeric',
            'attachMaxSize' => 'numeric',
        ]);
        XeConfig::set(XeEditor::getConfigKey($instanceId), [
            'height' => $request->get('height'),
            'fontSize' => $request->get('fontSize'),
            'fontFamily' => empty($request->get('fontFamily')) ? null : $request->get('fontFamily'),
            'uploadActive' => !!$request->get('uploadActive', false),
            'fileMaxSize' => $request->get('fileMaxSize', 0),
            'attachMaxSize' => $request->get('attachMaxSize', 0),
            'extensions' => empty($request->get('extensions')) ? null : strtolower($request->get('extensions')),
            'tools' => $request->get('tools', [])
        ]);

        $this->permissionRegister($request, XeEditor::getPermKey($instanceId), ['html', 'tool', 'upload', 'download']);

        return redirect()->route('settings.editor.setting.detail', $instanceId);
    }

    /**
     * file upload
     *
     * @param Request       $request      request
     * @param string        $instanceId   instance id
     * @return RendererInterface
     */
    public function fileUpload(Request $request, $instanceId)
    {
        $uploadedFile = null;
        if ($request->file('file') !== null) {
            $uploadedFile = $request->file('file');
        } elseif ($request->file('image') !== null) {
            $uploadedFile = $request->file('image');
        }

        if ($uploadedFile === null) {
            throw new InvalidArgumentException;
        }

        $config = XeEditor::get($instanceId)->getConfig();

        if (!$config->get('uploadActive') || Gate::denies('upload', new Instance(XeEditor::getPermKey($instanceId)))) {
            throw new AccessDeniedHttpException;
        }

        if ($config->get('fileMaxSize') * 1024 * 1024 < $uploadedFile->getSize()) {
            throw new HttpException(
                Response::HTTP_REQUEST_ENTITY_TOO_LARGE,
                xe_trans('xe::msgMaxFileSize', [
                    'fileMaxSize' => $config->get('fileMaxSize'),
                    'uploadFileName' => $uploadedFile->getClientOriginalName()
                ])
            );
        }
        $extensions = array_map(function ($v) {
            return trim($v);
        }, explode(',', $config->get('extensions', '')));
        if (array_search('*', $extensions) === false
            && !in_array(strtolower($uploadedFile->getClientOriginalExtension()), $extensions)) {
            throw new HttpException(
                Response::HTTP_NOT_ACCEPTABLE,
                xe_trans('xe::msgAvailableUploadingFiles', [
                    'extensions' => $config->get('extensions'),
                    'uploadFileName' => $uploadedFile->getClientOriginalName()
                ])
            );
        }

        $file = XeStorage::upload($uploadedFile, EditorHandler::FILE_UPLOAD_PATH);

        $media = null;
        $thumbnails = null;
        if (XeMedia::is($file) === true) {
            $media = XeMedia::make($file);
            $thumbnails = XeMedia::createThumbnails($media, EditorHandler::THUMBNAIL_TYPE);

            $media = $media->toArray();

            if (!empty($thumbnails)) {
                $info['thumbnails'] = $thumbnails;
            }
        }

        return XePresenter::makeApi([
            'file' => $file->toArray(),
            'media' => $media,
            'thumbnails' => $thumbnails,
        ]);
    }

    /**
     * get file source
     *
     * @param string        $instanceId instance id
     * @param string        $id         document id
     * @return void
     * @throws InvalidArgumentException
     */
    public function fileSource($instanceId, $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException;
        }

        $file = XeStorage::find($id);

        if (XeMedia::is($file) === true) {
            $dimension = 'L';
            if (\Agent::isMobile() === true) {
                $dimension = 'M';
            }
            $media = XeMedia::images()->getThumbnail(
                XeMedia::make($file),
                EditorHandler::THUMBNAIL_TYPE,
                $dimension
            );

            header('Content-type: ' . $media->mime);
            echo $media->getContent();
        }
    }

    /**
     * file download
     *
     * @param string        $instanceId instance id
     * @param string        $id
     * @return void
     */
    public function fileDownload($instanceId, $id)
    {
        if (empty($id) || !$file = XeStorage::find($id)) {
            throw new InvalidArgumentException;
        }

        if (Gate::denies('download', new Instance(XeEditor::getPermKey($instanceId)))) {
            throw new AccessDeniedHttpException;
        }

        XeStorage::download($file);
    }

    /**
     * file destory
     *
     * @param string  $instanceId
     * @param string  $id
     * @return RendererInterface
     */
    public function fileDestroy($instanceId, $id)
    {
        if (empty($id) || !$file = XeStorage::find($id)) {
            throw new InvalidArgumentException;
        }

        if ($file->userId !== Auth::id()) {
            throw new AccessDeniedHttpException;
        }

        try {
            $result = XeStorage::delete($file);
        } catch (\Exception $e) {
            $result = false;
        }

        return XePresenter::makeApi([
            'deleted' => $result,
        ]);
    }

    /**
     * 해시태그 suggestion 리스트
     *
     * @param Request $request
     * @return mixed
     */
    public function hashTag(Request $request)
    {
        $tags = XeTag::similar($request->get('string'));

        $suggestions = [];
        foreach ($tags as $tag) {
            $suggestions[] = [
                'id' => $tag->id,
                'word' => $tag->word,
            ];
        }

        return XePresenter::makeApi($suggestions);
    }

    /**
     * 멘션 suggestion 리스트
     *
     * @param Request $request
     * @return mixed
     */
    public function mention(Request $request)
    {
        $suggestions = [];

        $string = $request->get('string');
        $users = XeUser::where('displayName', 'like', $string . '%')->where('id', '<>', Auth::user()->getId())->get();
        foreach ($users as $user) {
            $suggestions[] = [
                'id' => $user->getId(),
                'displayName' => $user->getDisplayName(),
                'profileImage' => $user->profileImage,
            ];
        }

        return XePresenter::makeApi($suggestions);
    }
}

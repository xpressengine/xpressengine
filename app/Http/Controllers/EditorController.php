<?php
namespace App\Http\Controllers;

use App\Http\Sections\SkinSection;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Editor\EditorHandler;
use Xpressengine\Http\Request;
use XeMenu;
use XePresenter;
use Xpressengine\Media\MediaManager;
use Xpressengine\Media\Models\Image;
use Xpressengine\Permission\Instance;
use Xpressengine\Permission\PermissionSupport;
use Xpressengine\Presenter\RendererInterface;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\Support\Exceptions\InvalidArgumentException;
use Xpressengine\Tag\TagHandler;
use Auth;
use Gate;

class EditorController extends Controller
{
    use PermissionSupport;
    
    public function setting(EditorHandler $handler, Request $request, $instanceId)
    {
        $editorId = $request->get('editorId');
        if (empty($editorId)) {
            $editorId = null;
        }

        $handler->setInstance($instanceId, $editorId);

        if (!$url = XeMenu::getInstanceSettingURIByItemId($instanceId)) {
            return redirect()->back();
        } else {
            return redirect($url);
        }
    }

    public function getDetailSetting(EditorHandler $handler, ConfigManager $configs, $instanceId)
    {
        $config = $configs->getOrNew($handler->getConfigKey($instanceId));

        $tools = $handler->getToolAll();

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

        $skinSection = new SkinSection(EditorHandler::NAME, $instanceId);
        
        return XePresenter::make('editor.detail', [
            'instanceId' => $instanceId,
            'config' => $config,
            'permArgs' => $this->getPermArguments($handler->getPermKey($instanceId), ['html', 'tool', 'upload']),
            'items' => $items,
            'skinSection' => $skinSection,
        ]);
    }

    public function postDetailSetting(Request $request, EditorHandler $handler, ConfigManager $configs, $instanceId)
    {
        $this->validate($request, [
            'height' => 'required|numeric',
            'fontSize' => 'required'
        ]);
        $configs->set($handler->getConfigKey($instanceId), [
            'height' => $request->get('height'),
            'fontSize' => $request->get('fontSize'),
            'fontFamily' => empty($request->get('fontFamily')) ? null : $request->get('fontFamily'),
            'uploadActive' => !!$request->get('uploadActive', false),
            'fileMaxSize' => $request->get('fileMaxSize', 0),
            'attachMaxSize' => $request->get('attachMaxSize', 0),
            'extensions' => empty($request->get('extensions')) ? null : $request->get('extensions'),
            'tools' => $request->get('tools', [])
        ]);

        $this->permissionRegister($request, $handler->getPermKey($instanceId), ['html', 'tool', 'upload']);

        return redirect()->route('settings.editor.setting.detail', $instanceId);
    }

    /**
     * file upload
     *
     * @param Request       $request      request
     * @param EditorHandler $handler      editor handler
     * @param Storage       $storage      storage
     * @param MediaManager  $mediaManager media manager
     * @param string        $instanceId   instance id
     * @return RendererInterface
     */
    public function fileUpload(
        Request $request,
        EditorHandler $handler,
        Storage $storage,
        MediaManager $mediaManager,
        $instanceId
    ) {
        $uploadedFile = null;
        if ($request->file('file') !== null) {
            $uploadedFile = $request->file('file');
        } elseif ($request->file('image') !== null) {
            $uploadedFile = $request->file('image');
        }

        if ($uploadedFile === null) {
            throw new InvalidArgumentException;
        }

        if (Gate::denies('upload', new Instance($handler->getPermKey($instanceId)))) {
            throw new AccessDeniedHttpException;
        }

        $file = $storage->upload($uploadedFile, EditorHandler::FILE_UPLOAD_PATH);

        $media = null;
        $thumbnails = null;
        if ($mediaManager->is($file) === true) {
            $media = $mediaManager->make($file);
            $thumbnails = $mediaManager->createThumbnails($media, EditorHandler::THUMBNAIL_TYPE);

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
     * @param EditorHandler $handler    editor handler
     * @param string        $instanceId instance id
     * @param string        $id         document id
     * @return void
     * @throws InvalidArgumentException
     */
    public function fileSource(EditorHandler $handler, $instanceId, $id)
    {
        if (empty($id)) {
            throw new InvalidArgumentException;
        }

        $file = File::find($id);

        /** @var \Xpressengine\Media\MediaManager $mediaManager */
        $mediaManager = app('xe.media');
        if ($mediaManager->is($file) === true) {
            $dimension = 'L';
            if (\Agent::isMobile() === true) {
                $dimension = 'M';
            }
            $media = Image::getThumbnail(
                $mediaManager->make($file),
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
     * @param EditorHandler $handler    editor handler
     * @param Storage       $storage    storage
     * @param string        $instanceId instance id
     * @param string        $id
     * @return void
     */
    public function fileDownload(EditorHandler $handler, Storage $storage, $instanceId, $id)
    {
        if (empty($id) || !$file = File::find($id)) {
            throw new InvalidArgumentException;
        }

//        if (Gate::denies('download', new Instance($handler->getPermKey($instanceId)))) {
//            throw new AccessDeniedHttpException;
//        }

        $storage->download($file);
    }

    public function fileDestroy(Storage $storage, $instanceId, $id)
    {
        if (empty($id) || !$file = File::find($id)) {
            throw new InvalidArgumentException;
        }

        if ($file->userId !== Auth::id()) {
            throw new AccessDeniedHttpException;
        }

        try {
            $result = $storage->remove($file);
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
     * @param TagHandler $tag
     * @param string|null $id
     * @return mixed
     */
    public function hashTag(Request $request, TagHandler $tag, $id = null)
    {
        $tags = $tag->similar($request->get('string'));

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
     * @param string|null $id
     * @return mixed
     */
    public function mention(Request $request, $id = null)
    {
        $suggestions = [];

        $string = $request->get('string');
        $users = User::where('displayName', 'like', $string . '%')->where('id', '<>', Auth::user()->getId())->get();
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

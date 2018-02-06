<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\Http\Request;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Settings\AdminLog\LogHandler;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Theme\ThemeHandler;
use Xpressengine\User\Rating;
use Xpressengine\User\UserHandler;

class SettingsController extends Controller
{

    public function editSetting()
    {
        $config = app('xe.site')->getSiteConfig();

        return \XePresenter::make(
            'settings.setting',
            compact(
                'config'
            )
        );
    }

    public function updateSetting(SiteHandler $siteHandler, Request $request)
    {
        $inputs = $request->only(['site_title', 'favicon']);
        $oldConfig = $siteHandler->getSiteConfig();

        /* resolve site_title */
        $oldConfig['site_title'] = $inputs['site_title'];

        /* resolve favicon */
        $uploaded = array_get($inputs, 'favicon');

        if ($uploaded !== null) {
            $favicon = $this->saveFile($oldConfig, 'favicon', $uploaded, 'public/favicon/default');
            $oldConfig['favicon'] = $favicon;
        }

        $siteHandler->putSiteConfig($oldConfig);

        return \Redirect::back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    /**
     * setting 과정에서 upload되는 파일을 저장한다.
     *
     * @param              $oldSetting
     * @param string       $key  config field key
     * @param UploadedFile $file file
     * @param string       $path
     * @param string       $disk
     *
     * @return array
     * @internal param string $configId config id
     */
    protected function saveFile($oldSetting, $key, UploadedFile $file, $path, $disk = 'local')
    {
        $oldFileId = $oldSetting->get("$key.id");

        // remove old file
        if ($oldFileId !== null) {
            $oldFile = app('xe.storage')->find($oldFileId);
            if ($oldFile && file_exists($oldFile->getPathname())) {
                app('xe.storage')->remove($oldFile);
            }
        }

        // save new file
        $file = app('xe.storage')->upload(
            $file,
            $path,
            $disk
        );
        $saved = [
            'id' => $file->id,
            'filename' => $file->clientname
        ];

        $mediaFile = null;
        if (app('xe.media')->is($file)) {
            $mediaFile = app('xe.media')->make($file);
            $saved['path'] = $mediaFile->url();
        }

        return $saved;
    }

    public function editTheme(ThemeHandler $themeHandler)
    {
        $selectedTheme = $themeHandler->getSiteThemeId();

        return \XePresenter::make(
            'settings.theme',
            compact(
                'selectedTheme'
            )
        );
    }

    public function updateTheme(ThemeHandler $themeHandler, Request $request)
    {
        // resolve theme
        $theme = $request->only(['theme_desktop', 'theme_mobile']);
        $theme = ['desktop' => $theme['theme_desktop'], 'mobile' => $theme['theme_mobile']];
        $themeHandler->setSiteTheme($theme);

        return \Redirect::back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    public function editPermissions(PermissionHandler $permissionHandler)
    {
        /** @var SettingsHandler $settingsHandler */
        $settingsHandler = app('xe.settings');
        $permissionGroups = $settingsHandler->getPermissionList();

        foreach ($permissionGroups as $tab => &$group) {
            foreach ($group as $key => &$item) {
                $permission = $permissionHandler->get('settings.'.$item['id']);
                if ($permission === null) {
                    $permission = $permissionHandler->register('settings.'.$item['id'], new Grant());
                }
                $item['id'] = 'settings.'.$item['id'];
                $item['permission'] = $permission;
            }
        }

        return \XePresenter::make('settings.permissions', compact('permissionGroups'));
    }

    public function updatePermission(PermissionHandler $permissionHandler, Request $request, $permissionId)
    {
        $permissionHandler->register(
            $permissionId,
            $this->createAccessGrant(
                $request->only(
                    [
                        'accessRating',
                        'accessGroup',
                        'accessUser',
                        'accessExcept'
                    ]
                )
            )
        );

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    /**
     * createAccessGrant
     *
     * @param array $inputs to create grant params array
     *
     * @return Grant
     *
     */
    protected function createAccessGrant(array $inputs)
    {
        $grant = new Grant;

        $rating = array_get($inputs, 'accessRating', Rating::SUPER);
        $group = $this->innerParamParsing($inputs['accessGroup']);
        $user = $this->innerParamParsing($inputs['accessUser']);
        $except = $this->innerParamParsing($inputs['accessExcept']);

        $grant->add('access', 'rating', $rating);
        $grant->add('access', 'group', $group);
        $grant->add('access', 'user', $user);
        $grant->add('access', 'except', $except);

        return $grant;
    }

    protected function innerParamParsing($param)
    {
        if (empty($param)) {
            return [];
        }

        $ret = explode(',', $param);
        return array_filter($ret);
    }

    public function searchLog(Request $request, LogHandler $handler)
    {
        $query = $handler->query()->with('user')->orderBy('created_at', 'desc');

        $startDate = trim($request->get('startDate', date('Y-m-d', strtotime('-7 day', time())))) . ' 00:00:00';
        $endDate = trim($request->get('endDate', date('Y-m-d'))) . ' 23:59:59';

        $query->whereBetween('created_at', [$startDate, $endDate]);

        $startDate = str_before($startDate, ' ');
        $endDate = str_before($endDate, ' ');

        $type = $request->get('type');
        if ($type) {
            $query->where('type', $type);
        }

        $userId = $request->get('user_id');
        if ($userId) {
            $query->where('user_id', $userId);
        }

        // resolve search keyword
        // keyfield가 지정되지 않을 경우 url, summary를 대상으로 검색함
        $field = $request->get('keyfield', 'url,summary');
        $field = ($field === '') ? 'url,summary' : $field;

        if ($keyword = trim($request->get('keyword'))) {
            $query->where(
                function (Builder $q) use ($field, $keyword) {
                    foreach (explode(',', $field) as $f) {
                        $q->orWhere($f, 'like', '%'.$keyword.'%');
                    };
                }
            );
        }

        return ['query'=>$query, 'startDate'=>$startDate, 'endDate'=>$endDate];
    }

    public function indexLog(Request $request, LogHandler $handler, UserHandler $userHandler)
    {
        $loggers = $handler->getLoggers();
        $searchLog = self::searchLog($request, $handler);

        $query = $searchLog['query'];
        $startDate = $searchLog['startDate'];
        $endDate = $searchLog['endDate'];

        $logs = $query->paginate(20)->appends(request()->query());

        $admins = $userHandler->whereIn('rating', [Rating::MANAGER, Rating::SUPER])->get();
        return \XePresenter::make('settings.logs.index', compact('loggers', 'logs', 'admins', 'startDate', 'endDate'));
    }

    public function saveLog(Request $request, LogHandler $handler, UserHandler $userHandler)
    {
        $loggers = $handler->getLoggers();
        $searchLog = self::searchLog($request, $handler);

        $query = $searchLog['query'];

        $headers = array(
            "Content-type" => "text/csv; charset=UTF-8;",
            "Content-Disposition" => 'attachment; filename=' . date('Y-m-d H:i:s') . '.csv',
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $logs = $query->get();

        $callback = function () use ($logs, $loggers, $handler) {
            $file = fopen('php://output', 'w');

            fwrite($file, "일시\t타입\t관리자\t요약\tIP주소\t자세히\n");

            foreach ($logs as $log) {
                fwrite($file, $log->created_at->format('y-m-d H:i:s') . "\t");
                if ($logger = array_get($loggers, $log->type)) {
                    fwrite($file, $logger::TITLE . "\t");
                } else {
                    fwrite($file, $log->type . "\t");
                }
                fwrite($file, $log->user->getDisplayName() . "\t");
                fwrite($file, $log->summary . "\t");
                fwrite($file, $log->ipaddress . "\t");

                $detail = $handler->find($log->id);
                fwrite($file, $detail->method . ',');
                fwrite($file, $detail->url . ',');

                foreach($detail->parameters as $key => $value) {
                    fwrite($file, $key . ":");

                    if (is_array($value)) {
                        fwrite($file, json_encode($value) . ',');
                    } else {
                        fwrite($file, $value . ',');
                    }
                }

                fwrite($file, "\n");
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function showLog(LogHandler $handler, $id)
    {
        $log = $handler->find($id);
        return api_render('settings.logs.show', compact('log'));
    }
}

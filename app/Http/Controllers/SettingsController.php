<?php
/**
 * SettingsController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use XeMedia;
use XeSEO;
use XeStorage;
use XeSite;
use Xpressengine\Captcha\Exceptions\ConfigurationNotExistsException;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Http\Request;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Log\LogHandler;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Theme\ThemeHandler;
use Xpressengine\User\Models\UnknownUser;
use Xpressengine\User\Rating;
use Xpressengine\User\UserHandler;

/**
 * Class SettingsController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SettingsController extends Controller
{
    /**
     * Show the form for setting.
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function editSetting()
    {
        $siteConfig = app('xe.site')->getSiteConfig();
        $seoSetting = XeSEO::getSetting();
        $userConfig = app('xe.config')->get('user.common');
        $registerConfig = app('xe.config')->get('user.register');
        $pluginConfig = app('xe.config')->get('plugin');
        $currentSite = \XeSite::getCurrentSite();
        $captchaManager = app('xe.captcha');

        expose_trans('xe::browserTitle');
        expose_trans('xe::browserSubTitle');
        expose_trans('xe::siteSettingSEOInputDescription');

        $langs['mainTitle'] = xe_trans($seoSetting->get('mainTitle', ''));
        $langs['subTitle'] = xe_trans($seoSetting->get('subTitle', ''));
        $langs['description'] = xe_trans($seoSetting->get('description', ''));

        return \XePresenter::make('settings.setting', compact(
            'siteConfig',
            'seoSetting',
            'userConfig',
            'registerConfig',
            'pluginConfig',
            'currentSite',
            'langs',
            'captchaManager'
        ));
    }

    /**
     * Update setting.
     *
     * @param Request $request request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSetting(Request $request)
    {
        $this->validate($request, $this->getUpdateSettingRules());

        $defaultSettingInputs = $request->only(['site_title', 'favicon']);
        $this->updateDefaultSetting($defaultSettingInputs);

        $siteInputs = $request->only(['site_address']);
        $this->updateSite($siteInputs);

        $seoSettingInputs = $request->only(['mainTitle', 'subTitle', 'description', 'keywords', 'siteImage']);
        $this->updateSEOSetting($seoSettingInputs);

        $webmasterInputs = $request->only(['webmasterName', 'webmasterEmail']);
        $this->updateWebmasterSetting($webmasterInputs);

        $pluginInstallInputs = $request->only(['site_token', 'composer_home']);
        $this->updatePluginInstallSetting($pluginInstallInputs);

        $loginCaptchaInputs = $request->only(['useCaptcha']);
        $this->updateLoginCaptcha($loginCaptchaInputs);

        return \Redirect::back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * Default Setting Update
     *
     * @param array $inputs default setting inputs
     *
     * @return void
     */
    protected function updateDefaultSetting($inputs)
    {
        /** @var SiteHandler $siteHandler */
        $siteHandler = app('xe.site');

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
    }

    /**
     * Site Setting Update
     *
     * @param array $inputs site setting input
     *
     * @return void
     */
    protected function updateSite($inputs)
    {
        $site = XeSite::getCurrentSite();

        if (isset($inputs['site_address']) == true) {
            $site['host'] = $inputs['site_address'];
            $site->save();
        }

        XeSite::setCurrentSite($site);
    }

    /**
     * SEO Setting Update
     *
     * @param array $inputs SEO setting inputs
     *
     * @return void
     */
    protected function updateSEOSetting($inputs)
    {
        $setting = XeSEO::getSetting();
        $setting->set($inputs);

        if (array_key_exists('siteImage', $inputs) === true &&  $inputs['siteImage'] !== null) {
            $file = XeStorage::upload($inputs['siteImage'], 'public/seo');
            $image = XeMedia::make($file);
            $setting->setSiteImage($image);
        }
    }

    /**
     * Webmaster Setting Update
     *
     * @param array $inputs Webmaster setting inputs
     *
     * @return void
     */
    protected function updateWebmasterSetting($inputs)
    {
        $userConfig = app('xe.config')->get('user.common');
        foreach ($inputs as $key => $value) {
            if (isset($userConfig[$key]) === true) {
                $userConfig[$key] = $value;
            }
        }

        app('xe.config')->modify($userConfig);
    }

    /**
     * Plugin Install Setting Update
     *
     * @param array $inputs plugin install inputs
     *
     * @return void
     */
    protected function updatePluginInstallSetting($inputs)
    {
        foreach ($inputs as $idx => $value) {
            if ($value == null) {
                $inputs[$idx] = '';
            }
        }

        $config = app('xe.config')->get('plugin');

        $siteToken = $inputs['site_token'];
        $config->set('site_token', $siteToken);

        if (isset($inputs['composer_home']) == true) {
            $config->set('composer_home', $inputs['composer_home']);
        }
        app('xe.config')->modify($config);
    }

    protected function updateLoginCaptcha($inputs)
    {
        $captchaManager = app('xe.captcha');

        if (isset($inputs['useCaptcha']) == false) {
            return;
        }

        if ($inputs['useCaptcha'] === 'true' && !$captchaManager->available()) {
            throw new ConfigurationNotExistsException();
        }

        $registerConfig = app('xe.config')->get('user.register');
        $registerConfig->set('useCaptcha', $inputs['useCaptcha']);

        app('xe.config')->modify($registerConfig);
    }

    /**
     * Returns validation rules.
     *
     * @return array
     */
    private function getUpdateSettingRules()
    {
        return [
            'site_address' => 'required',
        ];
    }

    /**
     * Save uploaded file.
     *
     * @param ConfigEntity $oldSetting config for old
     * @param string       $key        config field key
     * @param UploadedFile $file       file
     * @param string       $path       path
     * @param string       $disk       disk name
     * @return array
     */
    protected function saveFile($oldSetting, $key, UploadedFile $file, $path, $disk = 'local')
    {
        $oldFileId = $oldSetting->get("$key.id");

        // remove old file
        if ($oldFileId !== null) {
            $oldFile = app('xe.storage')->find($oldFileId);

            if ($oldFile && file_exists(app()->storagePath() . '/app/' . $oldFile->getPathname())) {
                app('xe.storage')->delete($oldFile);
            }
        }

        // save new file
        $file = app('xe.storage')->upload(
            $file,
            $path,
            null,
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

    /**
     * Show the edit form for the site theme.
     *
     * @param ThemeHandler $themeHandler ThemeHandler instance
     * @return \Xpressengine\Presenter\Presentable
     *
     * @deprecated since 3.0.4 instead use ThemeSettingsController@editSetting
     */
    public function editTheme(ThemeHandler $themeHandler)
    {
        $selectedTheme = $themeHandler->getSiteThemeId();

        return \XePresenter::make('settings.theme', compact('selectedTheme'));
    }

    /**
     * Update setting of the site theme.
     *
     * @param ThemeHandler $themeHandler ThemeHandler instance
     * @param Request      $request      request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @deprecated since 3.0.4 instead use THemeSettingsController@updateSetting
     */
    public function updateTheme(ThemeHandler $themeHandler, Request $request)
    {
        // resolve theme
        $theme = $request->only(['theme_desktop', 'theme_mobile']);
        $theme = ['desktop' => $theme['theme_desktop'], 'mobile' => $theme['theme_mobile']];
        $themeHandler->setSiteTheme($theme);

        return \Redirect::back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * Show the edit form for the site permission.
     *
     * @param PermissionHandler $permissionHandler PermissionHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
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

    /**
     * Update setting of the site permission.
     *
     * @param PermissionHandler $permissionHandler PermissionHandler instance
     * @param Request           $request           request
     * @param string            $permissionId      identifier
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePermission(PermissionHandler $permissionHandler, Request $request, $permissionId)
    {
        $permissionHandler->register($permissionId, $this->createAccessGrant(
            $request->only(['accessRating', 'accessGroup', 'accessUser', 'accessExcept'])
        ));

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }

    /**
     * Create the grant of access
     *
     * @param array $inputs to create grant params array
     * @return Grant
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

    /**
     * Parse the given parameter.
     *
     * @param string $param parameter
     * @return array
     */
    protected function innerParamParsing($param)
    {
        if (empty($param)) {
            return [];
        }

        $ret = explode(',', $param);
        return array_filter($ret);
    }

    /**
     * Build query for log.
     *
     * @param Request    $request request
     * @param LogHandler $handler LogHandler instance
     * @return \Illuminate\Database\Query\Builder
     */
    protected function searchLog(Request $request, LogHandler $handler)
    {
        $query = $handler->query()->with('user')->orderBy('created_at', 'desc');

        $request->query->set('startDate', $request->get('startDate', date('Y-m-d', strtotime('-7 day', time()))));
        $request->query->set('endDate', $request->get('endDate', date('Y-m-d')));

        $query->whereBetween('created_at', [
            $request->get('startDate')  . ' 00:00:00', $request->get('endDate') . ' 23:59:59'
        ]);

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

        return $query;
    }

    /**
     * Show the list of logs.
     *
     * @param Request     $request request
     * @param LogHandler  $handler LogHandler instance
     * @param UserHandler $userHandler UserHandler instance
     * @return \Xpressengine\Presenter\Presentable
     */
    public function indexLog(Request $request, LogHandler $handler, UserHandler $userHandler)
    {
        $loggers = $handler->getLoggers();
        $query = self::searchLog($request, $handler);

        $logs = $query->paginate(20)->appends(request()->query());

        $admins = $userHandler->whereIn('rating', [Rating::MANAGER, Rating::SUPER])->get();
        return \XePresenter::make('settings.logs.index', compact('loggers', 'logs', 'admins'));
    }

    /**
     * Download logs to the client.
     *
     * @param Request    $request request
     * @param LogHandler $handler LogHandler instance
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function saveLog(Request $request, LogHandler $handler)
    {
        $loggers = $handler->getLoggers();
        $query = self::searchLog($request, $handler);

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

            fputs($file, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));

            fwrite($file, "일시\t타입\t관리자\t요약\t대상ID\tIP주소\t자세히\n");

            foreach ($logs as $log) {
                fwrite($file, $log->created_at->format('y-m-d H:i:s') . "\t");
                if ($logger = array_get($loggers, $log->type)) {
                    fwrite($file, $logger::TITLE . "\t");
                } else {
                    fwrite($file, $log->type . "\t");
                }

                if ($log->getUser() instanceof UnknownUser) {
                    fwrite($file, sprintf('%s', $log->getUser()->getDisplayName()) . "\t");
                } else {
                    fwrite($file, sprintf('%s(%s)', $log->getUser()->getDisplayName(), $log->getUser()->email) . "\t");
                }
                
                fwrite($file, $log->summary . "\t");
                fwrite($file, $log->target_id . "\t");
                fwrite($file, $log->ipaddress . "\t");

                $detail = $handler->find($log->id);
                fwrite($file, $detail->method . ', ');
                fwrite($file, $detail->url);

                foreach ($detail->parameters as $key => $value) {
                    fwrite($file, ', ');

                    fwrite($file, $key . ":");

                    $str = $value;

                    if (is_array($str)) {
                        $str = json_encode($str);
                    }

                    $str = str_replace("\n", " ", $str);
                    $str = str_replace("\r", " ", $str);
                    $str = str_replace("\t", " ", $str);

                    fwrite($file, $str);
                }

                fwrite($file, "\n");
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Show log information by given id.
     *
     * @param LogHandler $handler LogHandler instance
     * @param string     $id      identifier
     * @return mixed
     */
    public function showLog(LogHandler $handler, $id)
    {
        $log = $handler->find($id);

        return api_render('settings.logs.show', compact('log'));
    }

    /**
     * Cache clear.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cacheClear()
    {
        Artisan::call('cache:clear');

        return redirect()->route('settings.setting.edit')
            ->with('alert', ['type' => 'success', 'message' => xe_trans('xe::wasRecreateCache')]);
    }

    /**
     * Get authenticate view for administrator
     *
     * @param Request      $request      request
     * @param UrlGenerator $urlGenerator UrlGenerator instance
     *
     * @return \Xpressengine\Presenter\Presentable
     */
    public function getAdminAuth(Request $request, UrlGenerator $urlGenerator)
    {
        $redirectUrl = $request->get('redirectUrl', $urlGenerator->previous());

        return \XePresenter::make('settings.admin', compact('redirectUrl'));
    }

    /**
     * Attempt authenticate for administrator
     *
     * @param Request $request request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postAdminAuth(Request $request)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);

        $credentials = $request->only('password');

        if (app('auth')->attemptAdminAuth($credentials)) {
            $redirectUrl = $request->get('redirectUrl');
            return redirect()->intended($redirectUrl);
        }

        return redirect()->back()->with('alert', ['type' => 'failed', 'message' => xe_trans('xe::msgInvalidPassword')]);
    }
}

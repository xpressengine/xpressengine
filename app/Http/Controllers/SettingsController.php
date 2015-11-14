<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Storage;
use Xpressengine\Http\Request;
use Xpressengine\Menu\MenuRetrieveHandler;
use Xpressengine\Permission\Action;
use Xpressengine\Permission\Grant;
use Xpressengine\Settings\SettingsHandler;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Theme\ThemeHandler;

class SettingsController extends Controller
{

    public function editSetting(MenuRetrieveHandler $menuHandler, SiteHandler $siteHandler, ThemeHandler $themeHandler)
    {
        $config = app('xe.site')->getSiteConfig();

        $siteKey = $siteHandler->getCurrentSiteKey();
        $indexInstance = $siteHandler->getHomeInstanceId();
        $menus = $menuHandler->getAllMenu($siteKey);
        $selectedTheme = $themeHandler->getSiteThemeId();

        return \Presenter::make(
            'settings.setting',
            compact(
                'config',
                'selectedTheme',
                'menus',
                'indexInstance'
            )
        );
    }

    public function updateSetting(Request $request)
    {
        $themeHandler = app('xe.theme');
        $siteHandler = app('xe.site');

        $newConfig = $request->only(['site_title', 'favicon']);
        $config = app('xe.site')->getSiteConfig();

        // resolve site_title
        $config['site_title'] = $newConfig['site_title'];

        // resolve favicon
        $uploadedFavicon = array_get($newConfig, 'favicon');
        if ($uploadedFavicon !== null) {
            // remove old favicon file
            if (isset($config['favicon'])) {
                $oldLogoFileId = $config['favicon'];
                $oldLogoFile = Storage::get($oldLogoFileId);
                Storage::remove($oldLogoFile);
            }
            $favicon = Storage::upload($uploadedFavicon, 'filebox');
            $config['favicon'] = $favicon->id;
        }
        $siteHandler->putSiteConfig($config);

        // resolve index instance
        $indexInstance = $request->get('indexInstance');
        $siteHandler->setHomeInstanceId($indexInstance);

        // resolve theme
        $theme = $request->only(['theme_desktop', 'theme_mobile']);
        $theme = ['desktop' => $theme['theme_desktop'], 'mobile' => $theme['theme_mobile']];
        $themeHandler->setSiteTheme($theme);


        return \Redirect::back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    public function editPermissions()
    {
        /** @var SettingsHandler $manageHandler */
        $manageHandler = app('xe.settings');
        $permissionGroups = $manageHandler->getPermissionList();

        return \Presenter::make('settings.permissions', compact('permissionGroups'));
    }

    public function updatePermission(Request $request, $permissionId)
    {
        \Permission::register('settings', $permissionId, $this->createAccessGrant($request->only([
            'accessRating', 'accessGroup', 'accessUser', 'accessExcept'
        ])));
        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    /**
     * createAccessGrant
     *
     * @param array $inputs to create grant params array
     * @param Grant $grant  if need to add already exist grant this param is not null
     *
     * @return Grant
     *
     */
    protected function createAccessGrant(array $inputs)
    {
        $grant = new Grant;

        $rating = $inputs['accessRating'];
        $group = $this->innerParamParsing($inputs['accessGroup']);
        $user = $this->innerParamParsing($inputs['accessUser']);
        $except = $this->innerParamParsing($inputs['accessExcept']);

        $grant->add(Action::ACCESS, 'rating', $rating);
        $grant->add(Action::ACCESS, 'group', $group);
        $grant->add(Action::ACCESS, 'user', $user);
        $grant->add(Action::ACCESS, 'except', $except);

        return $grant;
    }

    protected function innerParamParsing($param)
    {
        if (empty($param)) {
            return [];
        }

        $ret = explode(',', $param);
        return array_except($ret, [""]);
    }

}

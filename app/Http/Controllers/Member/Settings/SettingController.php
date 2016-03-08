<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Http\Controllers\Member\Settings;

use App\Http\Controllers\Controller;
use App\Sections\DynamicFieldSection;
use App\Sections\ToggleMenuSection;
use Config;
use Input;
use Presenter;
use Xpressengine\Captcha\Exceptions\ConfigurationNotExistsException;
use Xpressengine\Http\Request;

/**
 * @category
 * @package     App\Http\Controllers\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SettingController extends Controller
{

    protected $users;

    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->users = app('xe.users');
    }

    /**
     * get Common setting
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function editCommon()
    {
        $config = app('xe.config')->get('member.common');

        return Presenter::make(
            'member.settings.setting.common',
            array_merge(
                compact('config')
            )
        );
    }

    /**
     * edit Skin setting
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function editSkin()
    {
        $authSkinSection = (new \App\Sections\SkinSection())->setting('member/auth', null);

        $settingsSkinSection = (new \App\Sections\SkinSection())->setting('member/settings', null);

        $profileSkinSection = (new \App\Sections\SkinSection())->setting('member/profile', null);

        return Presenter::make(
            'member.settings.setting.skin',
            array_merge(
                compact('authSkinSection', 'settingsSkinSection', 'profileSkinSection')
            )
        );
    }

    /**
     * update Common setting
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCommon(Request $request)
    {
        $inputs = $request->only(['useCaptcha', 'webmasterName', 'webmasterEmail']);

        if ($inputs['useCaptcha'] === 'true') {
            if (config('captcha.apis.google.siteKey') === null) {
                throw new ConfigurationNotExistsException();
            }
        }

        app('xe.config')->put('user.common', $inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    /**
     * edit Join setting
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function editJoin()
    {
        $config = app('xe.config')->get('user.join');

        return Presenter::make(
            'member.settings.setting.join',
            array_merge(
                compact('config')
            )
        );
    }

    /**
     * update Join setting
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateJoin()
    {
        $inputs = Input::except('_token');
        //$inputs['fields'] = json_decode($inputs['fields'], true);

        app('xe.config')->put('user.join', $inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    /**
     * edit Field setting
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function editField()
    {
        $dynamicFieldSection = new DynamicFieldSection('member');
        $connection = $this->users->getConnection();
        $dynamicFieldSection = $dynamicFieldSection->setting($connection, false);

        return Presenter::make(
            'member.settings.setting.field',
            array_merge(
                compact('dynamicFieldSection')
            )
        );
    }

    /**
     * edit ToggleMenu setting
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function editToggleMenu()
    {
        $toggleMenuSection = (new ToggleMenuSection())->setting('member');

        return Presenter::make(
            'member.settings.setting.usermenu',
            array_merge(
                compact('toggleMenuSection')
            )
        );
    }
}

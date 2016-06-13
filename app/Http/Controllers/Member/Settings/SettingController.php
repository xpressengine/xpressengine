<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers\Member\Settings;

use App\Http\Controllers\Controller;
use App\Http\Sections\DynamicFieldSection;
use App\Http\Sections\ToggleMenuSection;
use Config;
use Input;
use XePresenter;
use Xpressengine\Captcha\Exceptions\ConfigurationNotExistsException;
use Xpressengine\Http\Request;
use App\Http\Sections\SkinSection;

/**
 * @category
 * @package     App\Http\Controllers\Member
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
        $config = app('xe.config')->get('user.common');

        return XePresenter::make(
            'member.settings.setting.common',
            array_merge(
                compact('config')
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
        $inputs = $request->only(['useCaptcha', 'webmasterName', 'webmasterEmail', 'agreement', 'privacy']);

        if ($inputs['useCaptcha'] === 'true') {
            $driver = config('captcha.driver');
            $captcha = config("captcha.apis.$driver.siteKey");
            if (!$captcha) {
                throw new ConfigurationNotExistsException();
            }
        }

        app('xe.config')->put('user.common', $inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    /**
     * edit Skin setting
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function editSkin()
    {
        $authSkinSection = new SkinSection('member/auth');

        $settingsSkinSection = new SkinSection('member/settings');

        $profileSkinSection = new SkinSection('member/profile');

        return XePresenter::make(
            'member.settings.setting.skin',
            array_merge(
                compact('authSkinSection', 'settingsSkinSection', 'profileSkinSection')
            )
        );
    }

    /**
     * edit Join setting
     *
     * @return \Xpressengine\Presenter\RendererInterface
     */
    public function editJoin()
    {
        $config = app('xe.config')->get('user.join');

        return XePresenter::make(
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
        $connection = $this->users->getConnection();
        $dynamicFieldSection = new DynamicFieldSection('user', $connection, false);

        return XePresenter::make(
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
        $toggleMenuSection = new ToggleMenuSection('user');

        return XePresenter::make(
            'member.settings.setting.usermenu',
            array_merge(
                compact('toggleMenuSection')
            )
        );
    }
}

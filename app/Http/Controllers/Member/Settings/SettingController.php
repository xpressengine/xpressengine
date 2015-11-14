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
use Cfg;
use Config;
use Input;
use Presenter;

/**
 * @category
 * @package     App\Http\Controllers\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SettingController extends Controller
{

    protected $members;

    public function __construct()
    {
        $this->members = app('xe.members');
    }

    public function getCommonSetting()
    {
        $secureLevels = app('config')->get('xe.member.password');
        $config = Cfg::get('member.common');

        return Presenter::make(
            'member.settings.setting.common',
            array_merge(
                compact('config')
            )
        );
    }

    public function getSkinSetting()
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

    public function postCommonSetting()
    {
        $inputs = Input::except('_token');

        app('xe.config')->put('member.common', $inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    public function getJoinSetting()
    {

        $config = app('xe.config')->get('member.join');

        return Presenter::make(
            'member.settings.setting.join',
            array_merge(
                compact('config')
            )
        );
    }

    public function postJoinSetting()
    {
        $inputs = Input::except('_token');
        //$inputs['fields'] = json_decode($inputs['fields'], true);

        app('xe.config')->put('member.join', $inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    public function getFieldSetting()
    {

        $config = app('xe.config')->get('member.join');

        $dynamicFieldSection = new DynamicFieldSection('member');
        $connection = $this->members->getConnection();
        $dynamicFieldSection = $dynamicFieldSection->setting($connection, false);

        return Presenter::make(
            'member.settings.setting.field',
            array_merge(
                compact('dynamicFieldSection')
            )
        );
    }

    public function getToggleMenuSetting()
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

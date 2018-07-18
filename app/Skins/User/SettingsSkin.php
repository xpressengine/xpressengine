<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Skins\User;

use Xpressengine\Skin\GenericSkin;

/**
 * @category    User
 * @package     Xpressengine\User
 */
class SettingsSkin extends GenericSkin
{

    protected static $id = 'user/settings/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 마이페이지 스킨',
        'description' => 'Xpressengine의 기본 마이페이지 스킨입니다'
    ];

    protected static $path = 'user.skins.default.settings';

    protected static $info = [];

    protected static $viewDir = '';

    /**
     * 만약 view 이름과 동일한 메소드명이 존재하면 그 메소드를 호출한다.
     * 동일한 이름의 메소드명이 존재하지 않으면, 동일한 이름의 blade 파일을 render한다.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        app('xe.frontend')->css(
            [
                'assets/core/xe-ui-component/xe-ui-component.css',
                'assets/core/user/setting.css'
            ]
        )->load();
        app('xe.frontend')->js(
            [
                'assets/core/user/snb.js',
                'assets/core/user/settings.js'
            ]
        )->load();
        return parent::render();
    }

    public function edit($view)
    {
        $useEmailConfirm = app('xe.config')->getVal('user.join.guard_forced') === true;

        app('xe.frontend')->html('user.settings.loadScript')->content(
            "<script>
            $(function () {
                $('.__xe_setting.__xe_settingDisplayName').xeDisplayNameSetting({
                    checkUrl: '".route('user.settings.name.check')."',
                    saveUrl: '".route('user.settings.name.update')."'
                });
                $('.__xe_setting.__xe_settingPassword').xePasswordSetting({
                    checkUrl: '".route('user.settings.password.check')."',
                    saveUrl: '".route('user.settings.password.update')."'
                });
                $('.__xe_setting.__xe_settingEmail').xeEmailSetting({
                    addUrl: '".route('user.settings.mail.add')."',
                    saveUrl: '".route('user.settings.mail.update')."',
                    deleteUrl: '".route('user.settings.mail.delete')."',
                    confirmUrl: '".route('user.settings.mail.confirm')."',
                    deletePendingUrl: '".route('user.settings.pending_mail.delete')."',
                    resendPendingUrl: '".route('user.settings.pending_mail.resend')."',
                    useEmailConfirm: ".($useEmailConfirm ? 'true' : 'false')."
                });
                $('.__xe_setting.__xe_settingLeave').xeLeaveSetting({
                    saveUrl: '".route('user.settings.leave')."'
                });
            });
            </script>"
        )->appendTo('body')->load();

        return $this->renderBlade($view);
    }


}

<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Skins\Member;

use Xpressengine\Skin\BladeSkin;

/**
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SettingsSkin extends BladeSkin
{

    protected static $id = 'member/settings/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 마이페이지 스킨',
        'description' => 'Xpressengine의 기본 마이페이지 스킨입니다'
    ];

    protected $path = 'member.skins.default.settings';

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
                'assets/core/member/setting.css'
            ]
        )->load();
        app('xe.frontend')->js(
            [
                'assets/core/member/snb.js',
                'assets/core/member/settings.js'
            ]
        )->load();
        return parent::render();
    }

    public function edit($view)
    {
        $useEmailConfirm = app('xe.user')->usingEmailConfirm();

        app('xe.frontend')->html('member.settings.loadScript')->content(
            "<script>
            $(function () {
                $('.__xe_setting.__xe_settingDisplayName').xeDisplayNameSetting({
                    checkUrl: '".route('member.settings.name.check')."',
                    saveUrl: '".route('member.settings.name.update')."'
                });
                $('.__xe_setting.__xe_settingPassword').xePasswordSetting({
                    checkUrl: '".route('member.settings.password.check')."',
                    saveUrl: '".route('member.settings.password.update')."'
                });
                $('.__xe_setting.__xe_settingEmail').xeEmailSetting({
                    addUrl: '".route('member.settings.mail.add')."',
                    saveUrl: '".route('member.settings.mail.update')."',
                    deleteUrl: '".route('member.settings.mail.delete')."',
                    confirmUrl: '".route('member.settings.mail.confirm')."',
                    deletePendingUrl: '".route('member.settings.pending_mail.delete')."',
                    resendPendingUrl: '".route('member.settings.pending_mail.resend')."',
                    useEmailConfirm: ".($useEmailConfirm ? 'true' : 'false')."
                });
                $('.__xe_setting.__xe_settingLeave').xeLeaveSetting({
                    saveUrl: '".route('member.settings.leave')."'
                });
            });
            </script>"
        )->appendTo('body')->load();

        return $this->renderBlade($view);
    }


}

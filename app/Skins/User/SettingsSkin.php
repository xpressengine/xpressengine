<?php
/**
 * SettingsSkin.php
 *
 * PHP version 7
 *
 * @category    Skins
 * @package     App\Skins\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Skins\User;

use Xpressengine\Skin\GenericSkin;

/**
 * Class SettingsSkin
 *
 * @category    Skins
 * @package     App\Skins\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SettingsSkin extends GenericSkin
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'user/settings/skin/xpressengine@default';

    /**
     * The information for the component
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => '기본 마이페이지 스킨',
        'description' => 'Xpressengine의 기본 마이페이지 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'user.skins.default.settings';

    /**
     * @var array
     */
    protected static $info = [];

    /**
     * @var string
     */
    protected static $viewDir = '';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
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

    /**
     * Show the view for setting.
     *
     * @param string $view view name
     * @return \Illuminate\View\View
     */
    public function edit($view)
    {
        $useEmailConfirm = app('xe.config')->getVal('user.common.guard_forced') === true;

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

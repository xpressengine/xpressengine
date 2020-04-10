<?php
/**
 * ResetPassword.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Notifications;

use Xpressengine\Support\CustomizableMailNotification;

/**
 * Class ResetPassword
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ResetPassword extends CustomizableMailNotification
{
    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param string $token password reset token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get data for message
     *
     * @param mixed $notifiable notifiable
     * @return array
     */
    protected function getData($notifiable)
    {
        return ['token' => $this->token, 'user' => $notifiable];
    }

    /**
     * Get the default view name.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'emails.password';
    }

    /**
     * Get the default subject for message.
     *
     * @param mixed $notifiable notifiable
     * @return string
     */
    public function getDefaultSubject($notifiable)
    {
        return xe_trans(app('xe.site')->getSiteConfig()->get('site_title')).' '.xe_trans('xe::linkForPasswordReset');
    }
}

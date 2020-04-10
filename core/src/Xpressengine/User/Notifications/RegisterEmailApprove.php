<?php
/**
 * RegisterApprove.php
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
use Xpressengine\User\EmailInterface;

/**
 * Class RegisterApprove
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RegisterEmailApprove extends CustomizableMailNotification
{
    /**
     * The mail information for user.
     *
     * @var string
     */
    public $mail;

    public $token;

    /**
     * Create a notification instance.
     *
     * @param EmailInterface $mail
     * @param                $token
     */
    public function __construct(EmailInterface $mail, $token)
    {
        $this->mail = $mail;
        $this->token = $token;
    }

    /**
     * Get data for message
     *
     * @param mixed $notifiable notifiable
     *
     * @return array
     */
    protected function getData($notifiable)
    {
        return ['mail' => $this->mail, 'token' => $this->token];
    }

    /**
     * Get the default view name.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'emails.register_email_approve';
    }

    /**
     * Get the default subject for message.
     *
     * @param mixed $notifiable notifiable
     *
     * @return string
     */
    public function getDefaultSubject($notifiable)
    {
        return sprintf(
            '[%s] %s',
            xe_trans(app('xe.site')->getSiteConfig()->get('site_title')),
            xe_trans('xe::emailConfirm')
        );
    }
}

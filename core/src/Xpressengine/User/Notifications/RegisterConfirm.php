<?php
/**
 * RegisterConfirm.php
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
 * Class RegisterConfirm
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RegisterConfirm extends CustomizableMailNotification
{
    /**
     * The mail information for user.
     *
     * @var string
     */
    public $mail;

    /**
     * The confirm token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a notification instance.
     *
     * @param EmailInterface $mail  mail instance
     * @param mixed          $token confirm token
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
        return 'emails.register';
    }

    /**
     * Get the default subject for message.
     *
     * @param mixed $notifiable notifiable
     * @return string
     */
    public function getDefaultSubject($notifiable)
    {
        return xe_trans(app('xe.site')->getSiteConfig()->get('site_title')).' '.xe_trans('xe::emailConfirm');
    }
}

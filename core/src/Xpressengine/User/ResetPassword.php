<?php
/**
 * ResetPassword.php
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User;

use Illuminate\Auth\Notifications\ResetPassword as Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Class ResetPassword
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ResetPassword extends Notification
{
    /**
     * The message resolver
     *
     * @var callable
     */
    protected static $messageResolver;

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return $this->resolveMessage($notifiable);
    }

    /**
     * Set the message resolver
     *
     * @param callable $resolver message resolver
     * @return void
     */
    public static function setMessageResolver(callable $resolver)
    {
        static::$messageResolver = $resolver;
    }

    /**
     * Get the message resolver
     *
     * @return callable|null
     */
    public static function getMessageResolver()
    {
        return static::$messageResolver;
    }

    /**
     * Resolve a message for password reset
     *
     * @param mixed $notifiable notifiable
     * @return MailMessage
     */
    protected function resolveMessage($notifiable)
    {
        if ($resolver = static::getMessageResolver()) {
            return call_user_func($resolver, $this->token, $notifiable);
        }

        return (new MailMessage)->view('emails.password', [
            'token' => $this->token,
            'user' => $notifiable,
        ])->subject($this->subject());
    }

    /**
     * Get mail subject
     *
     * @return string
     */
    protected function subject()
    {
        return xe_trans(app('xe.site')->getSiteConfig()->get('site_title')).' '.xe_trans('xe::linkForPasswordReset');
    }
}

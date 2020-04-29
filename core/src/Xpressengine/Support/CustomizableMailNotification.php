<?php
/**
 * CustomizableNotification.php
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * Abstract class CustomizableNotification
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class CustomizableMailNotification extends Notification
{
    /**
     * The message resolver
     *
     * @var callable
     */
    protected static $messageResolver;

    /**
     * The subject resolver for message
     *
     * @var callable
     */
    protected static $subjectResolver;

    /**
     * The view name for message
     *
     * @var array
     */
    protected static $views = [];

    /**
     * @var array
     */
    protected static $channels = [];

    /**
     * @var array
     */
    protected static $defaultChannel = ['mail'];

    /**
     * Get the notification's channels.
     *
     * @param mixed $notifiable notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return static::getChannel();
    }

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
     * Resolve a message of the notification
     *
     * @param mixed $notifiable notifiable
     * @return MailMessage
     */
    protected function resolveMessage($notifiable)
    {
        $data = $this->getData($notifiable);
        $message = $this->createMessage();

        if ($resolver = static::getMessageResolver()) {
            return call_user_func_array($resolver, ['message' => $message] + $data);
        }

        return $message
            ->view(static::getView() ?: $this->getDefaultView(), $data)
            ->subject($this->subject($notifiable));
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
     * Get data for message
     *
     * @param mixed $notifiable notifiable
     * @return array
     */
    abstract protected function getData($notifiable);

    /**
     * Set the view name for message
     *
     * @param string $view view
     * @return void
     */
    public static function setView($view)
    {
        static::$views[get_called_class()] = $view;
    }

    /**
     * Get the view name for message
     *
     * @return string
     */
    public static function getView()
    {
        return static::$views[get_called_class()] ?? null;
    }

    /**
     * Get the default view name.
     *
     * @return string
     */
    abstract public function getDefaultView();

    /**
     * Set the subject resolver for message
     *
     * @param callable $resolver subject resolver
     * @return void
     */
    public static function setSubjectResolver(callable $resolver)
    {
        static::$subjectResolver = $resolver;
    }

    /**
     * Get the subject resolver for message
     *
     * @return callable
     */
    public static function getSubjectResolver()
    {
        return static::$subjectResolver;
    }

    /**
     * Get a subject for message
     *
     * @param mixed $notifiable notifiable
     * @return string
     */
    protected function subject($notifiable)
    {
        if (static::$subjectResolver) {
            return call_user_func(static::$subjectResolver, $notifiable, $this);
        }

        return $this->getDefaultSubject($notifiable);
    }

    /**
     * Get the default subject for message.
     *
     * @param mixed $notifiable notifiable
     * @return string
     */
    abstract public function getDefaultSubject($notifiable);

    /**
     * Create a new instance of the message.
     *
     * @return MailMessage
     */
    protected function createMessage()
    {
        return new MailMessage;
    }

    /**
     * Get channels for the notification
     *
     * @return array
     */
    public static function getChannel()
    {
        return static::$channels[get_called_class()] ?? static::getDefaultChannel();
    }

    /**
     * Set the array of notification channels
     *
     * @param string|array $channels channels
     * @return void
     */
    public static function setChannel($channels)
    {
        $channels = is_array($channels) ? $channels : [$channels];

        static::$channels[get_called_class()] = $channels;
    }

    /**
     * Add channels to the notification.
     *
     * @param string|array $channels channels
     * @return void
     */
    public static function addChannel($channels)
    {
        $channels = is_array($channels) ? $channels : [$channels];

        static::$channels[get_called_class()] = array_unique(static::$channels[get_called_class()] + $channels);
    }

    /**
     * Get default channels for the notification
     *
     * @return array
     */
    public static function getDefaultChannel()
    {
        return static::$defaultChannel;
    }

    /**
     * Set the array of notification default channels
     *
     * @param string|array $channels channels
     * @return void
     */
    public static function setDefaultChannel($channels)
    {
        static::$defaultChannel = is_array($channels) ? $channels : [$channels];
    }
}

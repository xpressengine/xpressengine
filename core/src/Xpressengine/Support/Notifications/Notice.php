<?php
/**
 * Notice.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Notifications;

use Xpressengine\Support\CustomizableMailNotification;

/**
 * Class Notice
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Notice extends CustomizableMailNotification
{
    /**
     * Receive email
     *
     * @var string
     */
    protected $email;

    /**
     * title for email contents
     *
     * @var string
     */
    protected $title;

    /**
     * email content
     *
     * @var string
     */
    protected $contents;

    /**
     * Create a notification instance.
     *
     * @param string $email    email
     * @param string $title    title
     * @param string $contents content
     */
    public function __construct($email, $title, $contents)
    {
        $this->email = $email;
        $this->title = $title;
        $this->contents = $contents;
    }

    /**
     * Get data for message
     *
     * @param mixed $notifiable notifiable
     * @return array
     */
    protected function getData($notifiable)
    {
        return ['mail' => $this->email, 'title' => $this->title, 'contents' => $this->contents];
    }

    /**
     * Get the default view name.
     *
     * @return string
     */
    public function getDefaultView()
    {
        return 'emails.notice';
    }

    /**
     * Get the default subject for message.
     *
     * @param mixed $notifiable notifiable
     * @return string
     */
    public function getDefaultSubject($notifiable)
    {
        return xe_trans(app('xe.site')->getSiteConfig()->get('site_title')).' '.xe_trans('xe::notification');
    }

    /**
     * Set subject resolver to null
     *
     * @return void
     */
    public static function setSubjectResolverToNull()
    {
        static::$subjectResolver = null;
    }
}

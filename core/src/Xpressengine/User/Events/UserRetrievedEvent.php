<?php
/**
 * UserRetrievedEvent.php
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

namespace Xpressengine\User\Events;

use Xpressengine\User\Models\User;

/**
 * UserRetrievedEvent
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserRetrievedEvent
{
    public $user;

    public $credentials;

    /**
     * UserRetrievedEvent constructor.
     * @param User|null $user        user
     * @param array     $credentials credentials
     */
    public function __construct(&$user, $credentials)
    {
        $this->user = &$user;
        $this->credentials = $credentials;
    }
}

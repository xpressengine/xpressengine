<?php
/**
 * UserRetrievedEvent.php
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

namespace Xpressengine\User\Events;

use Xpressengine\User\Models\User;

/**
 * UserRetrievedEvent
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

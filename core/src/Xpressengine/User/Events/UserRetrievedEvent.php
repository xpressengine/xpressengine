<?php
/**
 * Created by PhpStorm.
 * User: sirwoongke
 * Date: 2018. 7. 3.
 * Time: 11:18
 */

namespace Xpressengine\User\Events;

use Xpressengine\User\Models\User;

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

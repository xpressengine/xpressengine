<?php
/**
 * UserGroup
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\GroupInterface;
use Xpressengine\User\UserInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 */
class UserGroup extends DynamicModel implements GroupInterface
{
    protected $table = 'user_group';

    public $incrementing = false;

    public $fillable = [
        'name',
        'description',
        'count',
        'order'
    ];

    /**
     * @var bool use dynamic query
     */
    protected $dynamic = false;

    /**
     * set relationship with user groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_group_user', 'groupId', 'userId');
    }

    /**
     * add User to this group
     *
     * @param UserInterface $user user
     *
     * @return static
     */
    public function addUser(UserInterface $user)
    {
        $this->users()->save($user);
        $this->increment('count');
        return $this;
    }

    /**
     * except User
     *
     * @param UserInterface $user user
     *
     * @return static
     */
    public function exceptUser(UserInterface $user)
    {
        $this->users()->detach($user->getId());
        $this->decrement('count');
        return $this;
    }
}

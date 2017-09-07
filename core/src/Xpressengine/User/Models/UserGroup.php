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
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\GroupInterface;
use Xpressengine\User\UserInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class UserGroup extends DynamicModel implements GroupInterface
{
    protected $table = 'user_group';

    protected $connection = 'user';

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
        return $this->belongsToMany(User::class, 'user_group_user', 'group_id', 'user_id');
    }

    /**
     * set relationship for user count
     *
     * @return mixed
     */
    public function userCountRelation()
    {
        return $this->belongsToMany(User::class, 'user_group_user', 'group_id', 'user_id')->selectRaw(
            'group_id, count(*) as count'
        )->groupBy('group_id');
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
        return $this;
    }

    /**
     * get user count
     *
     * @return int
     *
     * @deprecated use getUserCountAttribute instead
     */
    public function getCountAttribute()
    {
        $userCount = $this->userCountRelation->first();
        return $userCount ? $userCount->count : 0;
    }

    /**
     * get user count
     *
     * @return int
     */
    public function getUserCountAttribute()
    {
        return $this->count;
    }
}

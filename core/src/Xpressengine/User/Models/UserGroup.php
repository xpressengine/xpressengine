<?php
/**
 * UserGroup
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

namespace Xpressengine\User\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\GroupInterface;
use Xpressengine\User\UserInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
            '`group_id`, count(*) as `count`'
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

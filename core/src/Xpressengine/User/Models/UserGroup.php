<?php
/**
 * UserGroup
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Member\Entities\GroupEntityInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserGroup extends DynamicModel implements GroupEntityInterface
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
     * @param User $user
     *
     * @return static
     */
    public function addUser(User $user)
    {
        $this->users()->save($user);
        $this->increment('count');
        return $this;
    }

    /**
     * except User
     *
     * @param User $user
     *
     * @return static
     */
    public function exceptUser(User $user)
    {
        $this->users()->detach($user->getId());
        $this->decrement('count');
        return $this;
    }

}

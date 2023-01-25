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
    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'user_group';

    /**
     * @var string[]
     */
    protected $fillable = [
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
     * @var string
     */
    protected $keyType = 'string';

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
        return $this->belongsToMany(User::class, 'user_group_user', 'group_id', 'user_id')
            ->selectRaw('`group_id`, count(*) as `count`')
            ->groupBy((array)'group_id');
    }

    /**
     * add User to this group
     *
     * @param  UserInterface  $user  user
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
     * @param  UserInterface  $user  user
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
        return $userCount->count ?? 0;
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

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        $currentSiteKeyResolver = static function ($model) {
            if (isset($model->site_key) === false) {
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        };

        static::creating($currentSiteKeyResolver);
        static::updating($currentSiteKeyResolver);
        static::saving($currentSiteKeyResolver);
    }
}

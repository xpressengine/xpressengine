<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Log\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\Models\UnknownUser;
use Xpressengine\User\Models\User;

/**
 * Class Log
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Log extends DynamicModel
{
    /**
     * @var \Closure
     */
    protected static $detailResolver;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'admin_log';

    /**
     * @var bool
     */
    protected $dynamic = false;

    /**
     * @var bool
     */
    public $timestamps = true;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $casts = [
        'parameters' => 'array',
        'data' => 'array'
    ];

    /**
     * @var array
     */
    protected $appends = [];

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'user_id',
        'method',
        'url',
        'parameters',
        'summary',
        'data',
        'target_id',
        'ipaddress',
        'created_at',
        'site_key'
    ];

    /**
     * set log detail info resolver
     *
     * @param  \Closure  $resolver  resolver
     *
     * @return void
     */
    public static function setDetailResolver(\Closure $resolver)
    {
        static::$detailResolver = $resolver;
    }

    /**
     * user relation
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * user 확인해서 삭제된 user 인 경우엔 UnknownUser 반환
     *
     * @return User|UnknownUser
     */
    public function getUser()
    {
        return $this->user ?? new UnknownUser();
    }

    /**
     * define detail accessor
     *
     * @return mixed
     */
    public function getDetailAttribute()
    {
        $resolver = static::$detailResolver;
        return $resolver($this);
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

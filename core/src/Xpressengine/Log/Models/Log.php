<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Team (khongchi) <khongchi@xpressengine.com>
 * @copyright   2000-2014 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Log\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\Models\UnknownUser;
use Xpressengine\User\Models\User;

/**
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Team (khongchi) <khongchi@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Log extends DynamicModel
{
    protected static $detailResolver;

    protected $table = 'admin_log';

    public $incrementing = false;

    protected $dynamic = false;

    public $timestamps = true;

    protected $casts = [
        'parameters' => 'array',
        'data' => 'array'
    ];

    protected $appends = [];

    protected $fillable = [
        'type', 'user_id', 'method', 'url', 'parameters', 'summary', 'data', 'ipaddress', 'created_at'
    ];

    /**
     * set log detail info resolver
     *
     * @param \Closure $resolver resolver
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

    public function getUser()
    {
        $user = $this->user;

        if ($user == null) {
            $user = new UnknownUser();
        }

        return $user;
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
}

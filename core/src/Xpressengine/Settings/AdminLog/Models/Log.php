<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
 * @author      XE Team (khongchi) <khongchi@xpressengine.com>
 * @copyright   2000-2014 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Settings\AdminLog\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\Models\User;

/**
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
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
        'type', 'userId', 'method', 'url', 'parameters', 'summary', 'data', 'ipaddress', 'createdAt'
    ];

    public static function setDetailResolver(\Closure $resolver)
    {
        static::$detailResolver = $resolver;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function getDetailAttribute()
    {
        $resolver = static::$detailResolver;
        return $resolver($this);
    }
}

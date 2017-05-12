<?php
/**
 * Instance Route
 *
 * PHP version 5
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Routing;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Site\Site;

/**
 * Instance Route
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 *
 * @property string $url        url
 * @property string $module     module id
 * @property string $instanceId instance Id
 * @property string $menuId     menu id
 * @property string $siteKey    site key
 */
class InstanceRoute extends DynamicModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'instance_route';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function site()
    {
        return $this->belongsTo(Site::class, 'siteKey', 'siteKey');
    }
}

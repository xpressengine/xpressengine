<?php
/**
 * Site
 *
 * PHP version 7
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Site;

use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * Site
 *
 * PHP version 7
 *
 * @category    Site
 * @package     Xpressengine\Site
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 *
 * @property string $host           지정된 도메인
 * @property string $site_key       고유한 식별자
 */

class Site extends DynamicModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'site';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'site_key';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['site_key', 'host'];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}

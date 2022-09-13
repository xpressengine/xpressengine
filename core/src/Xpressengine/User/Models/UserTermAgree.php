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

use Illuminate\Database\Eloquent\SoftDeletes;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserTermAgree extends DynamicModel
{
    use SoftDeletes;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'user_term_agrees';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'term_id',
        'site_key'
    ];

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

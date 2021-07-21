<?php
/**
 * Term.php
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

/**
 * Class Term
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Term extends DynamicModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_terms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['key', 'locale', 'title', 'content', 'description', 'order', 'is_enabled', 'is_require', 'site_key'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['is_enabled' => 'bool', 'is_require' => 'bool'];

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

    /**
     * get is term require
     *
     * @return bool
     */
    public function isRequire()
    {
        return $this->getAttribute('is_require') === true;
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            if(!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        });

        self::updating(function($model){
            if(!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        });

        self::saving(function($model){
            if(!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        });

    }
}

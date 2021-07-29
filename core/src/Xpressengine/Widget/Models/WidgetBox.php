<?php
/**
 * WidgetBox Model
 *
 * PHP version 7
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget\Models;

use Illuminate\Support\Arr;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetBox extends DynamicModel
{
    use WidgetBoxDataTrait;

    /**
     * @var string table name
     */
    protected $table = 'widgetbox';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'content',
        'options',
        'site_key'
    ];

    protected $casts = [
        'content' => 'array',
        'options' => 'array'
    ];

    /**
     * Get presenter class
     *
     * @return string
     */
    public function getPresenter()
    {
        return Arr::get($this->getAttributeValue('options'), 'presenter');
    }

    public function getOptions()
    {
        return $this->getAttributeValue('options');
    }

    public function getContent()
    {
        return $this->getAttributeValue('content');
    }

    public static function boot()
    {
        parent::boot();

        static::observe(WidgetBoxHistoryObserver::class);

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

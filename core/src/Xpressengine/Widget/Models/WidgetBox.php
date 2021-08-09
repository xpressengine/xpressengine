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
     * get Support Container
     *
     * @return boolean
     */
    public function isSupportContainer()
    {
        return Arr::get($this->getOptions(), 'supportContainer', false);
    }

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
        $content = $this->getAttributeValue('content');

        foreach ($content as &$container) {
            if (!array_key_exists('rows', $container)) {
                $container = [
                    'rows' => $container,
                    'options' => [],
                ];
            }

            $rows = &$container['rows'];
            foreach ($rows as &$row) {
                if (!array_key_exists('cols', $row)) {
                    $row = [
                        'cols' => $row,
                        'options' => [],
                    ];
                }
            }
        }

        return $content;
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function($model){
            if(!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        });

        self::updating(function(WidgetBox $model){
            $original = $model->getOriginal();
            $originalPresenter = json_decode($original['options'], JSON_OBJECT_AS_ARRAY)['presenter'];

            if (! empty($model->getContent())) {
                $content = $model->getContent();

                if ($originalPresenter::SUPPORT_CONTAINER !== $model->getPresenter()::SUPPORT_CONTAINER) {
                    $supportContainer = $model->getPresenter()::SUPPORT_CONTAINER;
                    $content = $supportContainer ? array($content) : array_merge(...array_values($content));
                }

                $model->setAttribute('content', $content);
            }

            if(!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        });

        self::saving(function($model){
            if(!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        });

        static::observe(WidgetBoxHistoryObserver::class);
    }
}

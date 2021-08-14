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
    public function isSupportContainer(): bool
    {
        return Arr::get($this->getOptions(), 'supportContainer', $this->getPresenter()::SUPPORT_CONTAINER);
    }

    /**
     * Get presenter class
     *
     * @return string
     */
    public function getPresenter(): string
    {
        return Arr::get($this->getAttributeValue('options'), 'presenter');
    }

    public function getOptions(): array
    {
        return $this->getAttributeValue('options');
    }

    public function getContent(): array
    {
        $content = $this->getAttributeValue('content');

        return $this->getPresenter()::SUPPORT_CONTAINER
            ? $this->getContainersContent($content)
            : $this->getRowsContent($content);
    }

    /**
     * get containers content
     *
     * @param array $containers
     * @return array
     */
    private function getContainersContent(array $containers): array
    {
        foreach ($containers as &$container) {
            $hasNotStringKeys = count(array_filter(array_keys($container), 'is_string')) === 0;

            if ($hasNotStringKeys && !array_key_exists('rows', $container)) {
                $container = $this->getContainerData($container);
            }


            if (array_key_exists('rows', $container)) {
                $container['rows'] = $this->getRowsContent($container['rows']);
            }
        }

        return $containers;
    }

    /**
     * make rows content
     *
     * @param array $rows
     * @return array
     */
    private function getRowsContent(array $rows): array
    {
        $rows = $this->getContainersToRaws($rows);

        foreach ($rows as &$row) {
            $hasNotStringKeys = count(array_filter(array_keys($row), 'is_string')) === 0;

            if ($hasNotStringKeys && !array_key_exists('cols', $row)) {
                $row = $this->getRowData($row);
            }
        }

        return $rows;
    }

    /**
     * get container data
     *
     * @param $data
     * @return array
     */
    private function getContainerData($data): array
    {
        return [
            'rows' => $data,
            'options' => [],
        ];
    }

    /**
     * get row data
     *
     * @param $data
     * @return array
     */
    private function getRowData($data): array
    {
        return [
            'cols' => $data,
            'options' => [],
        ];
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
            $originSupportContainer = json_decode($original['options'], JSON_OBJECT_AS_ARRAY)['presenter']::SUPPORT_CONTAINER;
            $supportContainer = $model->getPresenter()::SUPPORT_CONTAINER;

            if ($supportContainer !== $originSupportContainer && $model->getAttributeValue('content')) {
                if ($supportContainer) {
                    $model->setAttribute('content', array($model->getAttributeValue('content')));
                }
            }

            if (!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }

            $model->setAttribute('options', array_merge($model->getOptions(), [
                'supportContainer' => $supportContainer
            ]));

            $content = $model->getContent();
            $model->setAttribute('content', $content);
        });

        self::saving(function($model){
            if(!isset($model->site_key)){
                $model->site_key = \XeSite::getCurrentSiteKey();
            }
        });

        static::observe(WidgetBoxHistoryObserver::class);
    }

    private function getContainersToRaws(array $content): array
    {
        $rows = [];

        foreach ($content as $container) {
            if (array_key_exists('rows', $container) && count($container) > 0) {
                array_push($rows, ...$container['rows']);
            }
        }

        return count($rows) > 0 ? $rows : $content;
    }
}

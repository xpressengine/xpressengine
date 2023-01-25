<?php

namespace Xpressengine\Widget\Models;

use Illuminate\Support\Arr;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * @method static whereWidgetbox(WidgetBox $widgetBox)
 */
class WidgetBoxHistory extends DynamicModel
{
    use WidgetBoxDataTrait;

    /**
     * Table
     */
    public const TABLE = 'widgetbox_history';

    /**
     * Columns
     */
    public const ID = 'id';
    public const WIDGETBOX_ID = 'widgetbox_id';
    public const SITE_KEY = 'site_key';
    public const CONTENT = 'content';
    public const OPTIONS = 'options';
    public const UPDATED_AT = null;

    /**
     * @var bool
     */
    public $incrementing = true;

    /**
     * @var string[]
     */
    public $timestamps = [
        'created_at'
    ];

    /**
     * @var string
     */
    protected $table = self::TABLE;

    /** @var string */
    protected $primaryKey = self::ID;

    /**
     * @var array
     */
    protected $fillable = [
        self::WIDGETBOX_ID,
        self::SITE_KEY,
        self::CONTENT,
        self::OPTIONS
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        self::CONTENT => 'array',
        self::OPTIONS => 'array'
    ];

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function getPresenter()
    {
        return Arr::get($this->getAttributeValue('options'), 'presenter');
    }

    /**
     * @return array|\ArrayAccess|mixed
     */
    public function isSupportContainer()
    {
        return Arr::get($this->getOptions(), 'supportContainer', false);
    }

    /**
     * @return mixed
     */
    public function getWidgetBoxId()
    {
        return $this->getAttribute(self::WIDGETBOX_ID);
    }

    /**
     * @return mixed
     */
    public function getOptions()
    {
        return $this->getAttributeValue(self::OPTIONS);
    }

    /**
     * @param $query
     * @param  \Xpressengine\Widget\Models\WidgetBox  $widgetBox
     * @return mixed
     */
    public function scopeWhereWidgetbox($query, WidgetBox $widgetBox)
    {
        return $query->where([
            [self::WIDGETBOX_ID, '=', $widgetBox->getAttribute('id')],
            [self::SITE_KEY, '=', $widgetBox->getAttribute('site_key')],
        ]);
    }
}

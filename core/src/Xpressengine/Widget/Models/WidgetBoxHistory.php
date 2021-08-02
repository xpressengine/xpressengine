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
    const TABLE = 'widgetbox_history';

    /**
     * Columns
     */
    const ID = 'id';
    const WIDGETBOX_ID = 'widgetbox_id';
    const SITE_KEY = 'site_key';
    const CONTENT = 'content';
    const OPTIONS = 'options';
    const UPDATED_AT = null;

    /** @var bool */
    public $incrementing = true;

    /** @var bool */
    public $timestamps = ["created_at"];

    /** @var string */
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

    /** @var string[] */
    protected $casts = [
        self::CONTENT => 'array',
        self::OPTIONS => 'array'
    ];

    public function getPresenter()
    {
        return Arr::get($this->getAttributeValue('options'), 'presenter');
    }

    public function isSupportContainer()
    {
        return Arr::get($this->getOptions(), 'supportContainer', false);
    }

    public function getWidgetBoxId()
    {
        return $this->getAttribute(self::WIDGETBOX_ID);
    }

    public function getOptions()
    {
        return $this->getAttributeValue(self::OPTIONS);
    }

    public function scopeWhereWidgetbox($query, WidgetBox $widgetBox)
    {
        return $query->where([
            [self::WIDGETBOX_ID, '=', $widgetBox->getAttribute('id')],
            [self::SITE_KEY, '=', $widgetBox->getAttribute('site_key')],
        ]);
    }
}

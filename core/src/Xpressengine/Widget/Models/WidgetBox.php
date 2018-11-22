<?php
/**
 * WidgetBox Model
 *
 * PHP version 7
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget\Models;

use Illuminate\Support\Arr;
use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetBox extends DynamicModel
{
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
        'options'
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
}

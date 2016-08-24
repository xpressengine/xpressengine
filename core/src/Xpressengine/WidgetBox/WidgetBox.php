<?php
/**
 * Widgetbox Model
 *
 * PHP version 5
 *
 * @category    Widgetbox
 * @package     Xpressengine\Widgetbox
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Models;

use Xpressengine\Database\Eloquent\DynamicModel;

/**
 * @category    Widgetbox
 * @package     Xpressengine\Widgetbox
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class WidgetBox extends DynamicModel
{

    protected $table = 'widgetbox';

    public $incrementing = false;

}

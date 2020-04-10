<?php
/**
 * Presentable
 *
 * PHP version 7
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Presenter;

use Illuminate\Contracts\Support\Renderable;

/**
 * Presentable
 *
 * Presenter 에서 사용 될 Renderer들을 위한 interface
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface Presentable extends Renderable
{
    /**
     * format
     *
     * @see \Illuminate\Http\Request::initializeFormats()
     * @return string
     */
    public static function format();
}

<?php
/**
 * Presentable
 *
 * PHP version 5
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

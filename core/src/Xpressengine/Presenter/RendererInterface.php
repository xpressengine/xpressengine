<?php
/**
 * RendererInterface
 *
 * PHP version 5
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Presenter;

use Illuminate\Contracts\Support\Renderable;

/**
 * RendererInterface
 * * Presenter 에서 사용 될 Renderer들을 위한 interface
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
interface RendererInterface extends Renderable
{
    /**
     * Illuminate\Http\Request::initializeFormats() 에서 정의된 formats 에서 하나의 format
     *
     * @return string
     */
    public static function format();
}

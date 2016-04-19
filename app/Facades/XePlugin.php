<?php
/**
 * XePlugin
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * facade 로 사용하기 위한 연결
 *
 * @category Plugin
 * @package  Xpressengine\Plugin
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 * @see      Xpressengine\Plugin\PluginHandler
 */
class XePlugin extends Facade
{
    const STATUS_ACTIVATED = 'activated';
    const STATUS_DEACTIVATED = 'deactivated';
    const STATUS_INSTALLED = 'installed';

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.plugin';
    }
}

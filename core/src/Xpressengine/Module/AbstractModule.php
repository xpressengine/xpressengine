<?php
/**
 * Abstract Module class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Module
 * @package     Xpressengine\Module
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Module;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Menu\MenuType\MenuTypeInterface;

/**
 * Xpressengine plugin 의 Module base class 정의
 *
 * @category    Module
 * @package     Xpressengine\Module
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 *
 * @deprecated Use Xpressengine\Menu\AbstractModule instead.
 */
abstract class AbstractModule implements ComponentInterface, MenuTypeInterface
{
    use ComponentTrait;

    /**
     * getTitle
     *
     * @return mixed
     */
    public static function getTitle()
    {
        return static::getComponentInfo('name');
    }

    /**
     * getDescription
     *
     * @return mixed
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

    /**
     * getScreenshot
     *
     * @return mixed
     */
    public static function getScreenshot()
    {
        return static::getComponentInfo('screenshot');
    }

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        return;
    }

    /**
     * Return this module is route able or unable
     * isRouteAble
     *
     * @return boolean
     */
    public static function isRouteAble()
    {
        return true;
    }
}

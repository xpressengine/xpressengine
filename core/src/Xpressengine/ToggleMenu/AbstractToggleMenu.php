<?php
/**
 * Abstarct ToggleMenu class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\ToggleMenu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\ToggleMenu;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * Xpressengine plugin 의 toggle menu base class 정의
 *
 * @category    Support
 * @package     Xpressengine\ToggleMenu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractToggleMenu implements ComponentInterface, ItemInterface
{
    use ComponentTrait;

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        return;
    }
}

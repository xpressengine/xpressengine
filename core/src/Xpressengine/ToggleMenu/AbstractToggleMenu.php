<?php
/**
 * Abstarct ToggleMenu class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\ToggleMenu;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * Xpressengine plugin 의 toggle menu base class 정의
 *
 * @category    Support
 * @package     Xpressengine\ToggleMenu
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

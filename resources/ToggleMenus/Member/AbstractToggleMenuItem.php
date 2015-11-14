<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\ToggleMenus\Member;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\ToggleMenu\ItemInterface;

/**
 * @category    
 * @package     Xpressengine\ToggleMenus\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractToggleMenuItem implements ItemInterface, ComponentInterface
{
    use ComponentTrait;

    public static function getId()
    {
        return static::$id;
    }

    public static function boot()
    {
    }

    public static function getSettingsURI()
    {
    }

    public static function getName()
    {
        return static::getComponentInfo('name');
    }

    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

}

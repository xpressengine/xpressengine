<?php
/**
 * Abstract Module class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Menu;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * Xpressengine plugin 의 Module base class 정의
 *
 * @category    Menu
 * @package     Xpressengine\Menu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractModule implements ComponentInterface
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

    /**
     * Return URL about module's detail setting
     * getInstanceSettingURI
     *
     * @param string $instanceId instance id
     *
     * @return mixed
     */
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }

    /**
     * Return Create Form View
     * @return mixed
     */
    abstract public function createMenuForm();

    /**
     * Process to Store
     *
     * @param string $instanceId     to store instance id
     * @param array  $menuTypeParams for menu type store param array
     * @param array  $itemParams     except menu type param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    abstract public function storeMenu($instanceId, $menuTypeParams, $itemParams);

    /**
     * Return Edit Form View
     *
     * @param string $instanceId to edit instance id
     *
     * @return mixed
     */
    abstract public function editMenuForm($instanceId);

    /**
     * Process to Update
     *
     * @param string $instanceId     to update instance id
     * @param array  $menuTypeParams for menu type update param array
     * @param array  $itemParams     except menu type param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    abstract public function updateMenu($instanceId, $menuTypeParams, $itemParams);

    /**
     * displayed message when menu is deleted.
     *
     * @param string $instanceId to summary before deletion instance id
     *
     * @return string
     */
    abstract public function summary($instanceId);

    /**
     * Process to delete
     *
     * @param string $instanceId to delete instance id
     *
     * @return mixed
     */
    abstract public function deleteMenu($instanceId);

    /**
     * Get menu type's item object
     *
     * @param string $id item id of menu type
     * @return mixed
     */
    abstract public function getTypeItem($id);
}

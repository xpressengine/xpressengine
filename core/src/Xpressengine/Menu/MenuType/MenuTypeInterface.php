<?php
/**
 * Interface Module
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Menu\MenuType;

/**
 * Module
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
interface MenuTypeInterface
{
    /**
     * Return this module is route able or unable
     * isRouteAble
     *
     * @return mixed
     */
    public static function isRouteAble();

    /**
     * Return URL about module's detail setting
     * getInstanceSettingURI
     *
     * @param string $instanceId instance id
     *
     * @return mixed
     */
    public static function getInstanceSettingURI($instanceId);

    /**
     * Return Create Form View
     * @return mixed
     */
    public function createMenuForm();

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
    public function storeMenu($instanceId, $menuTypeParams, $itemParams);

    /**
     * Return Edit Form View
     *
     * @param string $instanceId to edit instance id
     *
     * @return mixed
     */
    public function editMenuForm($instanceId);

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
    public function updateMenu($instanceId, $menuTypeParams, $itemParams);

    /**
     * displayed message when menu is deleted.
     *
     * @param string $instanceId to summary before deletion instance id
     *
     * @return string
     */
    public function summary($instanceId);

    /**
     * Process to delete
     *
     * @param string $instanceId to delete instance id
     *
     * @return mixed
     */
    public function deleteMenu($instanceId);

    /**
     * Get menu type's item object
     *
     * @param string $id item id of menu type
     * @return mixed
     */
    public function getTypeItem($id);
}

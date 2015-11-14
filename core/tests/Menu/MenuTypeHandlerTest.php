<?php
/**
 * ModuleHandlerTest
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\tests\Menu;

use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Menu\MenuType\MenuTypeInterface;
use Xpressengine\Module\ModuleHandler;
use Xpressengine\Plugin\ComponentTrait;


/**
 * Class FakeMenuTypeClass
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */

class FakeMenuTypeClass implements MenuTypeInterface
{
    use ComponentTrait;

    /**
     * getId
     *
     * @return string
     */
    public static function getId()
    {
        return 'fakeId';
    }


    /**
     * Return this module is route able or unable
     * isRouteAble
     *
     * @return mixed
     */
    public static function isRouteAble()
    {
        // TODO: Implement isRouteAble() method.
    }

    /**
     * Return Create Form View
     *
     * @return mixed
     */
    public function createMenuForm()
    {
        // TODO: Implement createMenuForm() method.
    }

    /**
     * Process to Store
     *
     * @param string $instanceId     instance id
     * @param array  $menuTypeParams menu type param array
     * @param array  $itemParams     item param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    public function storeMenu($instanceId, $menuTypeParams, $itemParams)
    {
        // TODO: Implement storeMenu() method.
    }

    /**
     * Return Edit Form View
     *
     * @param string $instanceId instance id
     *
     * @return mixed
     */
    public function editMenuForm($instanceId)
    {
        // TODO: Implement editMenuForm() method.
    }

    /**
     * Process to Update
     *
     * @param string $instanceId     instance id
     * @param array  $menuTypeParams menu type param array
     * @param array  $itemParams     item param array
     *
     * @return mixed
     * @internal param $inputs
     *
     */
    public function updateMenu($instanceId, $menuTypeParams, $itemParams)
    {
        // TODO: Implement updateMenu() method.
    }

    /**
     * Process to delete
     *
     * @param string $instanceId instance id
     *
     * @return mixed
     */
    public function deleteMenu($instanceId)
    {
        // TODO: Implement deleteMenu() method.
    }

    /**
     * summary
     *
     * @param string $instanceId instance id
     *
     * @return string
     */
    public function summary($instanceId)
    {
        // TODO: Implement summary() method.
    }

    /**
     * Return URL about module's detail setting
     * getInstanceSettingURI
     *
     * @param staring $instanceId instance id
     *
     * @return mixed
     */
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}

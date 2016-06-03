<?php
/**
 * DirectLinkTest
 *
 * @category  Test
 * @package   Xpressengine\Tests\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Tests\Menu;

use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Menu\MenuType\DirectLink;

/**
 * Class DirectLinkTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class DirectLinkTest extends PHPUnit_Framework_TestCase
{
    /**
     * testDirectLink
     *
     * @return void
     */
    public function testDirectLink()
    {
        $directLink = new DirectLink();

        $directLink::boot();
        $manageUri = $directLink::getSettingsURI();

        $instanceId = 'test';

        $createMenuForm = $directLink->createMenuForm();
        $directLink->storeMenu($instanceId, [], []);

        $editMenuForm = $directLink->editMenuForm($instanceId);
        $directLink->updateMenu($instanceId, [], []);

        $summaryView = $directLink->summary($instanceId);

        $directLink->deleteMenu($instanceId);

        $routeAble = $directLink::isRouteAble();

        $detailSettingUrl = $directLink::getInstanceSettingURI('testInstance');

        $this->assertEquals(null, $manageUri);
        $this->assertEquals('', $createMenuForm);
        $this->assertEquals('', $editMenuForm);
        $this->assertEquals('이 메뉴는 특별하게 사용하는 테이블과 document 가 없습니다.', $summaryView);
        $this->assertEquals(false, $routeAble);
        $this->assertEquals(null, $detailSettingUrl);
    }
}

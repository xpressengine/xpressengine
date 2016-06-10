<?php
/**
 * DirectLinkTest
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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

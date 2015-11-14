<?php
/**
 * MenuPermissionTest
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

namespace Xpressengine\Tests\Menu;

use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Menu\Permission\MenuPermission;
use Xpressengine\UIObjects\Menu\Menu;

/**
 * Class MenuPermissionTest
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuPermissionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    protected $registered;
    /**
     * @var MockInterface
     */
    protected $member;

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * testDirectLink
     *
     * @return void
     */
    public function testMenuPermission()
    {
        $member = $this->member;
        $registered = $this->registered;

        $menuPermission = new MenuPermission($member, $registered);
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {

        $memberMock = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');
        $registeredMock = m::mock('Xpressengine\Permission\Registered');

        $this->member = $memberMock;
        $this->registered = $registeredMock;
    }
}

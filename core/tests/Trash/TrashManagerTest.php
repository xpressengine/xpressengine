<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Trash;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Xpressengine\Trash\RecycleBinInterface;
use Xpressengine\Trash\TrashManager;

/**
 * Class TrashManagerTest
 * @package Xpressengine\Tests\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TrashManagerTest extends TestCase
{
    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * test trash manager
     *
     * @return void
     */
    public function testTrashManager()
    {
        $container = m::mock('Xpressengine\Register\Container');
        $container->shouldReceive('add');
        $container->shouldReceive('push');
        $container->shouldReceive('set');
        $container->shouldReceive('get')->andReturn([
            Bin::class
        ]);

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');

        $trash = new TrashManager($container, $conn);

        $trash->register(Bin::class);

        $this->assertEquals(1, count($trash->gets()));

        $bin = $trash->get('test');
        $this->assertEquals('test', $bin::name());

        $bins = $trash->bins();
        $this->assertEquals(Bin::class, $bins['test']);

        $trash->clean();

        $trash->clean([Bin::class]);
    }

}

/**
 * Class Waste
 * @package Xpressengine\Tests\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Bin implements RecycleBinInterface
{

    /**
     * 휴지통 이름 반환
     *
     *
     * @return string
     */
    public static function name()
    {
        // TODO: Implement name() method.
        return 'test';
    }

    /**
     * 휴지통 비우기 처리할 때 수행해야 할 코드 입력
     * TrashManager 에서 휴지통 비우기(clean()) 가 처리될 때 사용
     *
     * @return void
     */
    public static function clean()
    {
        // TODO: Implement clean() method.
    }

    /**
     * 휴지통 패키지에서 각 휴지통의 상태를 알 수 있도록 정보를 반환
     * 휴지통을 비우기 전에 각 휴지통에 얼마만큼의 정보가 있는지 알려주기 위한 인터페이스
     *
     * @return string
     */
    public static function summary()
    {
        // TODO: Implement summary() method.
    }
}

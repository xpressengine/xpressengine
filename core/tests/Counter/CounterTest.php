<?php
/**
 * CounterTest
 *
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Counter;

use Mockery as M;
use PHPUnit\Framework\TestCase;
use Xpressengine\Counter\Counter;
use Xpressengine\Counter\Factory;

/**
 * CounterTest
 * @package Xpressengine\Tests\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CounterTest extends TestCase
{
    private $request;

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
     * set up
     *
     * @reutrn void
     */
    public function setUp()
    {
        $request = m::mock('\Xpressengine\Http\Request');

        $request->shouldReceive('ip')->andReturn('127.0.0.1');

        $this->request = $request;
    }

    /**
     * get counter instance
     *
     * @param string $name    counter name
     * @param array  $options counter options
     * @return Counter
     */
    private function getCounter($name, array $options = [])
    {
        $counter = m::mock('Xpressengine\Counter\Counter', [$this->request, $name, $options])
        ->shouldAllowMockingProtectedMethods()
        ->makePartial();

        return $counter ;
    }

    /**
     * get User instance
     *
     * @return M\MockInterface
     */
    private function getUser()
    {
        $user = m::mock(
            'Xpressengine\User\Models\User',
            'Xpressengine\User\UserInterface'
        );
        return $user;
    }

    /**
     * get Guest instance
     *
     * @return M\MockInterface
     */
    private function getGuest()
    {
        $guest = m::mock(
            'Xpressengine\User\Models\Guest',
            'Xpressengine\User\UserInterface'
        );
        return $guest;
    }

    /**
     * get CounterLog instance
     *
     * @return M\Mock
     */
    private function getCounterLogModel(array $attributes = [])
    {
        return m::mock('Xpressengine\Counter\Models\CounterLog')
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();
    }

    /**
     * test Factory make
     *
     * @return void
     */
    public function testMakeCounter()
    {
        $interception = m::mock('Xpressengine\Interception\InterceptionHandler');
        $interception->shouldReceive('proxy')->andReturn(new Counter($this->request, 'test'));

        $factory = new Factory($interception);
        $counter = $factory->make($this->request, 'test');

        $this->assertInstanceOf('Xpressengine\Counter\Counter', $counter);
        $this->assertEquals('test', $counter->getName());
        $this->assertEquals(0, count($counter->getOptions()));
    }

    /**
     * test Counter add
     *
     * @return void
     */
    public function testAdd()
    {
        $counter = $this->getCounter('test');

        $counterLogModel = $this->getCounterLogModel();
        $counterLogModel->shouldReceive('save');
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $targetId = 'targetId';
        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn('userId');

        $counter->add($targetId, $user);

        $counter->setGuest(true);
        $guest = $this->getGuest();
        $guest->shouldReceive('getId')->andReturn('');
        $counter->add($targetId, $guest);
    }

    /**
     * counter 가 guest 에 대한 처리를 지원하지 않을 때
     *
     * @expectedException \Xpressengine\Counter\Exceptions\GuestNotSupportException
     */
    public function testAddFailGuestNotAllowed()
    {
        $counter = $this->getCounter('test');

        $counterLogModel = $this->getCounterLogModel();
        $counterLogModel->shouldReceive('save');
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $targetId = 'targetId';
        $guest = $this->getGuest();
        $guest->shouldReceive('getId')->andReturn('');
        $counter->add($targetId, $guest);
    }

    /**
     * counter 가 지원하지 않는 option 을 사하여 등록할 때
     *
     * @expectedException \Xpressengine\Counter\Exceptions\InvalidOptionException
     */
    public function testCheckOptionWithNotSupportedOption()
    {
        $counter = $this->getCounter('test');

        $targetId = 'targetId';
        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn('userId');

        $counter->add($targetId, $user, 'option');
    }

    /**
     * counter options 를 잡고 있고, 지원하지 않는 option 을 사하여 등록할 때
     *
     * @expectedException \Xpressengine\Counter\Exceptions\InvalidOptionException
     */
    public function testCheckOptionWithNotSupportedOption2()
    {
        $counter = $this->getCounter('test', ['options1', 'option2']);

        $targetId = 'targetId';
        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn('userId');

        $counter->add($targetId, $user, 'option');
    }

    /**
     * test get
     *
     * @return void
     */
    public function testGet()
    {
        $counter = $this->getCounter('test');
        $targetId = 'targetId';
        $userId = 'userId';

        $counterLogModel = $this->getCounterLogModel();
        $counterLogModel->shouldReceive('first')->andReturn($counterLogModel);
        $counterLogModel->shouldReceive('where')->andReturn($counterLogModel);
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn($userId);

        $result = $counter->get($targetId, $user);
        $this->assertInstanceOf('Xpressengine\Counter\Models\CounterLog', $result);

        $counter->setGuest(true);
        $guest = $this->getGuest();
        $guest->shouldReceive('getId')->andReturn('');

        $result = $counter->get($targetId, $guest);
        $this->assertInstanceOf('Xpressengine\Counter\Models\CounterLog', $result);

        $result = $counter->get($targetId);
        $this->assertInstanceOf('Xpressengine\Counter\Models\CounterLog', $result);
    }

    /**
     * test get by name
     *
     * @return void
     */
    public function testGetByName()
    {
        $counter = $this->getCounter('test');
        $targetId = 'targetId';
        $userId = 'userId';

        $counterLogModel = $this->getCounterLogModel();
        $counterLogModel->shouldReceive('first')->andReturn($counterLogModel);
        $counterLogModel->shouldReceive('where')->andReturnSelf();
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn($userId);

        $result = $counter->getByName($targetId, $user);
        $this->assertInstanceOf('Xpressengine\Counter\Models\CounterLog', $result);

        $counter->setGuest(true);
        $guest = $this->getGuest();
        $guest->shouldReceive('getId')->andReturn('');

        $result = $counter->getByName($targetId, $guest);
        $this->assertInstanceOf('Xpressengine\Counter\Models\CounterLog', $result);

        $result = $counter->getByName($targetId);
        $this->assertInstanceOf('Xpressengine\Counter\Models\CounterLog', $result);
    }

    /**
     * test has log
     *
     * @return void
     */
    public function testHas()
    {
        $counter = $this->getCounter('test');
        $targetId = 'targetId';
        $userId = 'userId';

        $counterLogModel = $this->getCounterLogModel();
        $counterLogModel->shouldReceive('first')->andReturn($counterLogModel);
        $counterLogModel->shouldReceive('where')->andReturnSelf();
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn($userId);

        $result = $counter->has($targetId, $user);
        $this->assertTrue($result);

        $result = $counter->hasByName($targetId, $user);
        $this->assertTrue($result);
    }

    /**
     * test remove
     *
     * @return void
     */
    public function testRemove()
    {
        $counterName = 'test';
        $counter = $this->getCounter($counterName);
        $targetId = 'targetId';
        $userId = 'userId';

        $counterLogModel = $this->getCounterLogModel();
        $counterLogModel->shouldReceive('delete')->andReturn();
        $counterLogModel->shouldReceive('where')->andReturnSelf();
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn($userId);

        $counter->remove($targetId, $user);

        $counter->setGuest(true);
        $guest = $this->getGuest();
        $guest->shouldReceive('getId')->andReturn('');

        $counter->remove($targetId, $guest);

        $counter->remove($targetId);
    }

    /**
     * test get point sum
     *
     * @return void
     */
    public function testGetPoint()
    {
        $counterName = 'test';
        $counter = $this->getCounter($counterName);
        $targetId = 'targetId';
        $userId = 'userId';
        $point = 10;

        $counterLogModel = $this->getCounterLogModel();
        $counterLogModel->shouldReceive('sum')->andReturn($point);
        $counterLogModel->shouldReceive('where')->andReturnSelf();
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $result = $counter->getPoint($targetId);
        $this->assertEquals($point, $result);
    }

    /**
     * test get users
     *
     * @return void
     */
    public function testGetUsers()
    {
        $counterName = 'test';
        $counter = $this->getCounter($counterName);
        $targetId = 'targetId';
        $userId = 'userId';
        $user = 'user';

        $counterLogModel = $this->getCounterLogModel();
        $returnLogModel = m::mock('stdClass');
        $returnLogModel->user = $user;

        $counterLogModel->shouldReceive('get')->andReturn([$returnLogModel]);
        $counterLogModel->shouldReceive('where')->once()->with('target_id', $targetId)->andReturnSelf();
        $counterLogModel->shouldReceive('where')->once()->with('counter_name', $counterName)->andReturnSelf();
        $counterLogModel->shouldReceive('where')->once()->with('counter_option', '')->andReturnSelf();
        $counter->shouldReceive('newModel')->andReturn($counterLogModel);

        $result = $counter->getUsers($targetId);

        $this->assertEquals($user, $result[0]);
    }
}

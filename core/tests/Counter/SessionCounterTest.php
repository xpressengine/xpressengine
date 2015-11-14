<?php
/**
 *
 */
namespace Xpressengine\Tests\Counter;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Counter\SessionCounter;

/**
 * Class CounterTest
 * @package Xpressengine\Tests\Counter
 */
class SessionCounterTest extends PHPUnit_Framework_TestCase
{
    protected $session;

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
     * @return void
     */
    public function setUp()
    {
        $session = m::mock('Illuminate\Session\SessionInterface');
        $session->shouldReceive('get')->once()->andReturn(null);
        $session->shouldReceive('set')->once();

        $this->session = $session;
    }

    /**
     * test session counter
     *
     * @return void
     */
    public function testInit()
    {
        $session = $this->session;
        $counter = new SessionCounter($session);
        $counter->init('id-session', 'default');
    }

    /**
     * test add, 등록되어 있는지 않은 target_id 를 등록
     *
     * @return void
     */
    public function testAddNotExistsSession()
    {
        $session = $this->session;
        $counter = new SessionCounter($session);
        $counter->init('id-session', 'default');

        // add to not exists session
        $session->shouldReceive('get')->andReturn(['id-session' => []]);
        $session->shouldReceive('set');

        $counter->add('targetId');
    }

    /**
     * test add, 등록된 target_id 를 등록
     *
     * @return void
     */
    public function testAddExistsSession()
    {
        $session = $this->session;
        $counter = new SessionCounter($session);
        $counter->init('id-session', 'default');

        // add to not exists session
        $session->shouldReceive('get')->andReturn(['id-session' => ['targetId']]);
        $session->shouldReceive('set');

        $counter->add('targetId');
    }

    /**
     * test remove, 등록되어 있는지 않은 target_id 를 삭제
     *
     * @return void
     */
    public function testRemoveNotExistsSession()
    {
        $session = $this->session;
        $counter = new SessionCounter($session);
        $counter->init('id-session', 'default');

        // add to not exists session
        $session->shouldReceive('get')->andReturn(['id-session' => []]);
        $session->shouldReceive('set');

        $counter->remove('targetId');
    }

    /**
     * test add, 등록된 target_id 를 삭제
     *
     * @return void
     */
    public function testRemoveExistsSession()
    {
        $session = $this->session;
        $counter = new SessionCounter($session);
        $counter->init('id-session', 'default');

        // add to not exists session
        $session->shouldReceive('get')->andReturn(['id-session' => ['targetId']]);
        $session->shouldReceive('set');

        $counter->remove('targetId');
    }

    /**
     * test invoked
     *
     * @return void
     */
    public function testInvoked()
    {
        $session = $this->session;
        $counter = new SessionCounter($session);
        $counter->init('id-session', 'default');

        $session->shouldReceive('get')->andReturn(['id-session' => ['targetId']]);
        $result = $counter->invoked('targetId');
        $this->assertTrue($result);
    }

    /**
     * test not invoked
     *
     * @return void
     */
    public function testNotInvoked()
    {
        $session = $this->session;
        $counter = new SessionCounter($session);
        $counter->init('id-session', 'default');

        $session->shouldReceive('get')->andReturn(['id-session' => []]);
        $result = $counter->invoked('targetId');
        $this->assertFalse($result);
    }
}

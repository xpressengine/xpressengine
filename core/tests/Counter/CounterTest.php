<?php
/**
 *
 */
namespace Xpressengine\Tests\Counter;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Counter\Counter;

/**
 * Class CounterTest
 * @package Xpressengine\Tests\Counter
 */
class CounterTest extends PHPUnit_Framework_TestCase
{

    private $repo;
    private $session;
    private $configHandler;
    private $member;
    private $auth;
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
     * @return void
     */
    public function setUp()
    {
        $repo = m::mock('Xpressengine\Counter\Repository');
        $session = m::mock('Xpressengine\Counter\SessionCounter');
        $configHandler = m::mock('Xpressengine\Counter\ConfigHandler');
        $member = m::mock('\Xpressengine\Member\Repositories\MemberRepositoryInterface');
        $auth = m::mock('\Xpressengine\Member\GuardInterface');
        $request = m::mock('\Illuminate\Http\Request');

        $request->shouldReceive('ip')->andReturn('127.0.0.1');

        $this->repo = $repo;
        $this->session = $session;
        $this->configHandler = $configHandler;
        $this->member = $member;
        $this->auth = $auth;
        $this->request = $request;
    }

    /**
     * invoked method
     *
     * @param mixed  $object     object
     * @param string $methodName method name
     * @param array  $parameters parameters
     * @return mixed
     */
    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * get Guest instance
     *
     * @return M\MockInterface
     */
    private function getGuest()
    {
        $guest = m::mock(
            'Xpressengine\Member\Entities\Guest',
            'Xpressengine\Member\Entities\MemberEntityInterface'
        );
        return $guest;
    }

    /**
     * get User instance
     *
     * @return M\MockInterface
     */
    private function getUser()
    {
        $user = m::mock(
            'Xpressengine\Member\Entities\Database\MemberEntity',
            'Xpressengine\Member\Entities\MemberEntityInterface'
        );
        return $user;
    }

    /**
     * set id type counter
     *
     * @param Counter $counter     counter instance
     * @param string  $counterName counter name
     * @return void
     */
    private function setIdType(Counter $counter, $counterName = 'id-counter')
    {
        $this->configHandler->shouldReceive('getType')->with($counterName)->andReturn($counter::TYPE_ID);
    }

    /**
     * set session type counter
     *
     * @param Counter $counter     counter instance
     * @param string  $counterName counter name
     * @return void
     */
    private function setSessionType(Counter $counter, $counterName = 'session-counter')
    {
        $this->configHandler->shouldReceive('getType')->with($counterName)->andReturn($counter::TYPE_SESSION);
    }

    /**
     * init id type counter
     *
     * @param Counter $counter counter instance
     * @return void
     */
    private function setIdTypeInit(Counter $counter)
    {
        $this->setIdType($counter);
        $counter->init('id-counter');
    }

    /**
     * init session type counter
     *
     * @param Counter $counter counter instance
     * @return void
     */
    private function setSessionTypeInit(Counter $counter)
    {
        $this->setSessionType($counter);
        $this->session->shouldReceive('init')->once();
        $counter->init('session-counter');
    }

    /**
     * test get config handler
     *
     * @return void
     */
    public function testGetConfigHandler()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = new Counter($repo, $session, $configHandler, $member, $auth, $request);

        $configHandler = $counter->getConfigHandler();

        $this->assertInstanceOf('Xpressengine\Counter\ConfigHandler', $configHandler);
    }

    /**
     * test get config handler
     *
     * @return void
     */
    public function testInit()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        // test id type counter init
        $this->setIdType($counter);
        $counter->init('id-counter');

        // test session type counter init
        $this->setSessionType($counter);
        $session->shouldReceive('init')->once();
        $counter->init('session-counter');
    }

    /**
     * init 하지 않고 add 할 때 오류
     *
     * @expectedException \Xpressengine\Counter\Exceptions\NameNotExistsException
     * @return void
     */
    public function testNotInitialized()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $guest = $this->getGuest();
        $auth->shouldReceive('user')->andReturn($guest);
        $guest->shouldReceive('getId')->andReturn('');

        $counter->add('targetId', $guest);
    }

    /**
     * Guest 가 session type 카운터를 통해 등록
     *
     * @return void
     */
    public function testAddByGuestToSessionTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setSessionTypeInit($counter);

        $guest = $this->getGuest();
        $auth->shouldReceive('user')->andReturn($guest);
        $guest->shouldReceive('getId')->andReturn('');

        $counter->shouldReceive('invoked')->andReturn(false);
        $session->shouldReceive('add');
        $repo->shouldReceive('insert');

        $counter->add('targetId', $guest);
    }

    /**
     * Guest 가 session type 카운터를 통해 이미 참여한 카운터에 등록할 때
     *
     * @expectedException \Xpressengine\Counter\Exceptions\InvokedException
     * @return void
     */
    public function testAddByGuestToSessionTypeCounterInvoked()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setSessionTypeInit($counter);

        $guest = $this->getGuest();
        $auth->shouldReceive('user')->andReturn($guest);
        $guest->shouldReceive('getId')->andReturn('');

        $counter->shouldReceive('invoked')->andReturn(true);
        $session->shouldReceive('add');
        $repo->shouldReceive('insert');

        $counter->add('targetId', $guest);
    }

    /**
     * Guest 가 id type 카운터를 통해 등록할 때 login 오류
     *
     * @expectedException \Xpressengine\Counter\Exceptions\LoginRequiredException
     * @return void
     */
    public function testAddByGuestToIdTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setIdTypeInit($counter);

        $guest = $this->getGuest();
        $auth->shouldReceive('user')->andReturn($guest);
        $guest->shouldReceive('getId')->andReturn('');

        $counter->shouldReceive('invoked')->andReturn(false);
        $session->shouldReceive('add');

        $counter->add('targetId', $guest);
    }

    /**
     * User 가 id type 카운터를 통해 등록
     *
     * @return void
     */
    public function testAddByUserToIdTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setIdTypeInit($counter);

        $user = $this->getUser();
        $auth->shouldReceive('user')->andReturn($user);
        $user->shouldReceive('getId')->andReturn('user');

        $counter->shouldReceive('invoked')->andReturn(false);
        $request->shouldReceive('ip')->andReturn('127.0.0.1');
        $repo->shouldReceive('insert');

        $counter->add('targetId', $user);
    }

    /**
     * User 가 id type 카운터를 통해 등록
     *
     * @expectedException \Xpressengine\Counter\Exceptions\InvokedException
     * @return void
     */
    public function testAddByUserToIdTypeCounterInvoked()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setIdTypeInit($counter);

        $user = $this->getUser();
        $auth->shouldReceive('user')->andReturn($user);
        $user->shouldReceive('getId')->andReturn('user');

        $counter->shouldReceive('invoked')->andReturn(true);

        $counter->add('targetId', $user);
    }

    /**
     * User 가 id type 카운터를 통해 등록
     *
     * @return void
     */
    public function testAddByUserToSessionTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setSessionTypeInit($counter);

        $user = $this->getUser();
        $auth->shouldReceive('user')->andReturn($user);
        $user->shouldReceive('getId')->andReturn('user');

        $counter->shouldReceive('invoked')->andReturn(false);
        $request->shouldReceive('ip')->andReturn('127.0.0.1');
        $repo->shouldReceive('insert');
        $session->shouldReceive('add');

        $counter->add('targetId', $user);
    }

    /**
     * Guest 가 session type 카운터를 통해 로그 삭제
     *
     * @return void
     */
    public function testRemoveByGuestToSessionTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setSessionTypeInit($counter);

        $guest = $this->getGuest();
        $auth->shouldReceive('user')->andReturn($guest);
        $guest->shouldReceive('getId')->andReturn('');

        $session->shouldReceive('remove');

        $counter->remove('targetId');
    }

    /**
     * Guest 가 id type 카운터를 통해 로그 삭제
     *
     * @expectedException \Xpressengine\Counter\Exceptions\LoginRequiredException
     * @return void
     */
    public function testRemoveByGuestToIdTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setIdTypeInit($counter);

        $guest = $this->getGuest();
        $auth->shouldReceive('user')->andReturn($guest);
        $guest->shouldReceive('getId')->andReturn('');

        $counter->remove('targetId');
    }

    /**
     * User 가 session type 카운터를 통해 로그 삭제
     *
     * @return void
     */
    public function testRemoveByUserToSessionTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setSessionTypeInit($counter);

        $user = $this->getUser();
        $auth->shouldReceive('user')->andReturn($user);
        $user->shouldReceive('getId')->andReturn('user');

        $session->shouldReceive('remove');
        $repo->shouldReceive('delete');

        $counter->remove('targetId');
    }

    /**
     * User 가 id type 카운터를 통해 로그 삭제
     *
     * @return void
     */
    public function testRemoveByUserToIdTypeCounter()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        // test session type counter ini
        $this->setIdTypeInit($counter);

        $user = $this->getUser();
        $auth->shouldReceive('user')->andReturn($user);
        $user->shouldReceive('getId')->andReturn('user');

        $repo->shouldReceive('delete');

        $counter->remove('targetId');
    }

    /**
     * Guest 참여 여부
     *
     * @expectedException \Xpressengine\Counter\Exceptions\InvalidTypeException
     * @return void
     */
    public function testGuestInvoked()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setSessionTypeInit($counter);

        $guest = $this->getGuest();
        $auth->shouldReceive('user')->andReturn($guest);
        $guest->shouldReceive('getId')->andReturn('');

        $session->shouldReceive('invoked')->once()->andReturn(false);
        $result = $counter->invoked('targetId', $guest);
        $this->assertFalse($result);

        $session->shouldReceive('invoked')->once()->andReturn(true);
        $result = $counter->invoked('targetId', $guest);
        $this->assertTrue($result);

        $this->setIdTypeInit($counter);
        $counter->invoked('targetId', $guest);
    }

    /**
     * User 참여 여부
     *
     * @return void
     */
    public function testUserInvoked()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $this->setSessionTypeInit($counter);

        $user = $this->getUser();
        $auth->shouldReceive('user')->andReturn($user);
        $user->shouldReceive('getId')->andReturn('user');

        $repo->shouldReceive('find')->once()->andReturn(null);
        $result = $counter->invoked('targetId', $user);
        $this->assertFalse($result);

        $repo->shouldReceive('find')->once()->andReturn(['targetId' => 'targetId']);
        $result = $counter->invoked('targetId', $user);
        $this->assertTrue($result);
    }

    /**
     * 로그 기록
     *
     * @return void
     */
    public function testGetLog()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        $repo->shouldReceive('find')->andReturn(['targetId' => 'targetId']);

        $user = $this->getUser();
        $user->shouldReceive('getId')->andReturn('user');
        $result = $counter->get('targetId', $user);

        $this->assertEquals(['targetId'=>'targetId'], $result);
    }

    /**
     * Repository helper interface test
     *
     * @return void
     */
    public function testForRepositoryInterface()
    {
        $repo = $this->repo;
        $session = $this->session;
        $configHandler = $this->configHandler;
        $member = $this->member;
        $auth = $this->auth;
        $request = $this->request;

        $counter = m::mock('Xpressengine\Counter\Counter', [$repo, $session, $configHandler, $member, $auth, $request])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        // get users
        $repo->shouldReceive('fetchByUserIds')->andReturn(['userId']);
        $member->shouldReceive('find')->andReturn(['user1'=>'userId']);
        $result = $counter->getUsers('targetId');
        $this->assertEquals(['user1'=>'userId'], $result[0]);

        $result = $counter->getUserIds('targetId');
        $this->assertEquals(['userId'], $result);
    }
}

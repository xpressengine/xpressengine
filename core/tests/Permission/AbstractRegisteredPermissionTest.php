<?php
namespace Xpressengine\Tests\Permission;

use Mockery as m;
use Xpressengine\Permission\Permissions\AbstractRegisteredPermission;
use Xpressengine\Permission\Action;
use Xpressengine\Permission\Registered;

class AbstractRegisteredPermissionTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $repo = m::mock('Xpressengine\Member\Repositories\VirtualGroupRepositoryInterface');
        $repo->shouldReceive('fetchAllByMember')->with(null)->andReturn([]);
        $repo->shouldReceive('fetchAllByMember')->with(m::on(function ($arg) {
            return $arg !== null;
        }))->andReturn([
            (object)['id' => 'virtual', 'title' => 'Virtual']
        ]);
        AbstractRegisteredPermission::setVirtualGroupRepository($repo);
    }

    public function tearDown()
    {
        m::close();
    }

    public function testJudge()
    {
        //{"create":{"rating":"guest","group":["721f801b-680c-4056-bd8e-b34873f15e18","b2578e5d-abac-497e-bca8-346dcd5d4fa7"],"user":[""],"except":[""]}}
        $createGrant = [
            'rating' => 'manager',
            'group' => [

            ],
            'user' => [

            ],
            'except' => [

            ],
            'vgroup' => [
                'virtual'
            ]
        ];
        $readGrant = [
            'rating' => 'guest',
            'group' => [

            ],
            'user' => [

            ],
            'except' => [

            ],
            'vgroup' => [

            ]
        ];

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered->shouldReceive('offsetGet')->with(Action::CREATE)->andReturn($createGrant);
        $mockRegistered->shouldReceive('offsetGet')->with(Action::READ)->andReturn($readGrant);

        $mockGuest = m::mock('Xpressengine\Member\Entities\Guest');
        $mockGuest->shouldReceive('getId')->andReturnNull();
        $mockGuest->shouldReceive('getGroups')->andReturn([]);
        $instance = new SampleRegisteredPermission('some.target', $mockGuest, $mockRegistered);

        $this->assertFalse($this->invokeMethod($instance, 'judge', [Action::CREATE]));
        $this->assertTrue($this->invokeMethod($instance, 'judge', [Action::READ]));


        $mockUser = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');
        $mockUser->shouldReceive('getId')->andReturn('userid');
        $mockUser->shouldReceive('getGroups')->andReturn([]);
        $mockUser->shouldReceive('getRating')->andReturn('member');


        $instance = new SampleRegisteredPermission('some.target', $mockUser, $mockRegistered);

        $this->assertTrue($this->invokeMethod($instance, 'judge', [Action::CREATE]));
        $this->assertTrue($this->invokeMethod($instance, 'judge', [Action::READ]));

    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}

class SampleRegisteredPermission extends AbstractRegisteredPermission
{
    protected $actions = [Action::CREATE, Action::READ];

    public function __construct($target, $user, Registered $registered)
    {
        $this->target = $target;
        $this->user = $user;

        parent::__construct($registered);
    }
}


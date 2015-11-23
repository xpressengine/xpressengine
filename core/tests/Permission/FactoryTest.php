<?php
namespace Xpressengine\Tests\Permission;

use Mockery as m;
use Xpressengine\Permission\Factory;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\Registered;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testMakeReturnsRoutePermissionWhenWantRoute()
    {
        list($auth, $routes, $repo) = $this->getMocks();

        $mockRoute = m::mock('Illuminate\Routing\Route');
        $mockRegistered = m::mock('Xpressengine\Permission\Registered');

        $mockUser = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');

        $auth->shouldReceive('user')->andReturn($mockUser);
        $auth->shouldReceive('guest')->andReturn(false);

        $routes->shouldReceive('getByName')->once()->with('settings.member')->andReturn($mockRoute);

        $repo->shouldReceive('findByTypeAndName')->once()->with('default', 'route', 'settings.member')->andReturn($mockRegistered);
        $repo->shouldReceive('fetchAncestor')->once()->with($mockRegistered)->andReturn([]);

        $instance = new Factory($auth, $routes, $repo);
        $permission = $instance->make('route', 'settings.member');

        $this->assertInstanceOf('Xpressengine\Permission\Permissions\RoutePermission', $permission);
    }

    public function testMakeReturnsInstancePermissionWhenWantInstance()
    {
        list($auth, $routes, $repo) = $this->getMocks();

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');

        $mockRegisteredAsc1 = m::mock('Xpressengine\Permission\Registered');
        $mockRegisteredAsc1->name = 'plugin.board';
        $mockRegisteredAsc2 = m::mock('Xpressengine\Permission\Registered');
        $mockRegisteredAsc2->name = 'plugin';

        $mockRegistered->shouldReceive('addParent')->once()->with($mockRegisteredAsc1)->andReturnNull();
        $mockRegistered->shouldReceive('addParent')->once()->with($mockRegisteredAsc2)->andReturnNull();

        $mockUser = m::mock('Xpressengine\Member\Entities\Guest');

        $auth->shouldReceive('user')->andReturn($mockUser);

        $repo->shouldReceive('findByTypeAndName')->once()->with('default', 'instance', 'plugin.board.notice')->andReturn($mockRegistered);
        $repo->shouldReceive('fetchAncestor')->once()->with($mockRegistered)->andReturn([
            $mockRegisteredAsc1, $mockRegisteredAsc2
        ]);

        $instance = new Factory($auth, $routes, $repo);
        $permission = $instance->make('instance', 'plugin.board.notice');

        $this->assertInstanceOf('Xpressengine\Permission\Permissions\InstancePermission', $permission);
    }

    public function testMakesByType()
    {
        list($auth, $routes, $repo) = $this->getMocks();
        $instance = new Factory($auth, $routes, $repo);

        $mockUser = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');
        $auth->shouldReceive('user')->andReturn($mockUser);

        $mockRegistered1 = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered1->name = 'plugin';
        $mockRegistered2 = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered2->name = 'plugin.board';
        $mockRegistered2->shouldReceive('addParent');
        $repo->shouldReceive('fetchByType')->once()->with('default', 'route')->andReturn([$mockRegistered1, $mockRegistered2]);

        $mockRoute1 = m::mock('Illuminate\Routing\Route');
        $mockRoute2 = m::mock('Illuminate\Routing\Route');
        $routes->shouldReceive('getByName')->once()->with('plugin')->andReturn($mockRoute1);
        $routes->shouldReceive('getByName')->once()->with('plugin.board')->andReturn($mockRoute2);

        $permissions = $instance->makesByType('route');

        $this->assertEquals(2, count($permissions));
        $this->assertInstanceOf('Xpressengine\Permission\Permission', reset($permissions));
    }

    public function testMakesByTypeThrowsExceptionWhenCustomPermissionIsNotPermission()
    {
        list($auth, $routes, $repo) = $this->getMocks();
        $instance = new Factory($auth, $routes, $repo);
        $instance->extend('custom', function ($target, $user, $registered) {
            return new \stdClass();
        });

        $mockUser = m::mock('Xpressengine\Member\Entities\MemberEntityInterface');
        $auth->shouldReceive('user')->andReturn($mockUser);

        $mockRegistered1 = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered1->name = 'plugin';
        $mockRegistered2 = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered2->name = 'plugin.board';
        $mockRegistered2->shouldReceive('addParent');
        $repo->shouldReceive('fetchByType')->once()->with('default', 'custom')->andReturn([$mockRegistered1, $mockRegistered2]);

        try {
            $permissions = $instance->makesByType('custom');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Permission\Exceptions\NotMatchedInstanceException', $e);
        }
    }

    public function testRegisterExecutedInsertWhenNotExists()
    {
        list($auth, $routes, $repo) = $this->getMocks();

        $grant = new Grant();
        $grant->set('access', 'guest');
        $grant->set('delete', 'group', ['group_id_1', 'group_id_2']);

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockParent = m::mock('Xpressengine\Permission\Registered');

        $repo->shouldReceive('findByTypeAndName')->once()->with('default', 'instance', 'plugin.dummy')->andReturnNull();
        $repo->shouldReceive('fetchAncestor')->once()->andReturn([$mockParent]);
        $repo->shouldReceive('insert')->once()->with(m::on(function ($value) {
            return $value instanceof Registered;
        }))->andReturn($mockRegistered);

        $instance = new Factory($auth, $routes, $repo);
        $instance->register('instance', 'plugin.dummy', $grant);
    }

    public function testRegisterExecutedUpdateWhenNotExists()
    {
        list($auth, $routes, $repo) = $this->getMocks();

        $grant = new Grant();
        $grant->set('access', 'guest');
        $grant->set('delete', 'group', ['group_id_1', 'group_id_2']);

        $mockParent = m::mock('Xpressengine\Permission\Registered');

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered->shouldReceive('setGrant')->once()->with($grant)->andReturnNull();
        $mockRegistered->shouldReceive('getOriginal')->once()->andReturn([
            "access" => [
                "rating" => "manager",
                "group" => [],
                "user" => [],
                "except" => []
            ]
        ]);
        $mockRegistered->shouldReceive('addParent')->once()->with($mockParent);


        $repo->shouldReceive('findByTypeAndName')->once()->with('default', 'instance', 'plugin.dummy')->andReturn($mockRegistered);
        $repo->shouldReceive('fetchAncestor')->once()->andReturn([$mockParent]);
        $repo->shouldReceive('update')->once()->with($mockRegistered)->andReturn($mockRegistered);

        $instance = new Factory($auth, $routes, $repo);
        $instance->register('instance', 'plugin.dummy', $grant);
    }

    public function testMoveThrowsExceptionWhenGivenInvalidTo()
    {
        list($auth, $routes, $repo) = $this->getMocks();
        $instance = new Factory($auth, $routes, $repo);

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered->siteKey = 'default';
        $mockRegistered->type = 'instance';

        $repo->shouldReceive('findByTypeAndName')->once()->with('default', 'instance', 'invalid.to')->andReturnNull();


        try {
            $instance->move($mockRegistered, 'invalid.to');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Permission\Exceptions\InvalidArgumentException', $e);
        }
    }

    public function testMoveThrowsExceptionWhenNotTopAndNotHasParent()
    {
        list($auth, $routes, $repo) = $this->getMocks();
        $instance = new Factory($auth, $routes, $repo);

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered->shouldReceive('getParent')->andReturnNull();
        $mockRegistered->shouldReceive('getDepth')->andReturn(2);

        try {
            $instance->move($mockRegistered);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Permission\Exceptions\InvalidArgumentException', $e);
        }
    }

    public function testMoveFromTopToAnotherChild()
    {
        list($auth, $routes, $repo) = $this->getMocks();
        $instance = new Factory($auth, $routes, $repo);

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered->siteKey = 'default';
        $mockRegistered->type = 'instance';
        $mockRegistered->shouldReceive('getParent')->andReturnNull();
        $mockRegistered->shouldReceive('getDepth')->andReturn(1);

        $mockToRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockToRegistered->type = 'instance';

        $repo->shouldReceive('findByTypeAndName')->once()->with('default', 'instance', 'valid.to')->andReturn($mockToRegistered);
        $repo->shouldReceive('affiliate')->once()->with($mockRegistered, 'valid.to');


        $instance->move($mockRegistered, 'valid.to');
    }

    public function testMoveFromChildToTop()
    {
        list($auth, $routes, $repo) = $this->getMocks();
        $instance = new Factory($auth, $routes, $repo);

        $mockParent = m::mock('Xpressengine\Permission\Registered');

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered->shouldReceive('getParent')->andReturn($mockParent);

        $repo->shouldReceive('foster')->once()->with($mockRegistered, null);


        $instance->move($mockRegistered);
    }

    public function testMoveFromChildToAnotherChild()
    {
        list($auth, $routes, $repo) = $this->getMocks();
        $instance = new Factory($auth, $routes, $repo);

        $mockParent = m::mock('Xpressengine\Permission\Registered');

        $mockRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockRegistered->siteKey = 'default';
        $mockRegistered->type = 'instance';
        $mockRegistered->shouldReceive('getParent')->andReturn($mockParent);

        $mockToRegistered = m::mock('Xpressengine\Permission\Registered');
        $mockToRegistered->type = 'instance';

        $repo->shouldReceive('findByTypeAndName')->once()->with('default', 'instance', 'valid.to')->andReturn($mockToRegistered);
        $repo->shouldReceive('foster')->once()->with($mockRegistered, 'valid.to');


        $instance->move($mockRegistered, 'valid.to');
    }

    private function getMocks()
    {
        return [
            m::mock('Illuminate\Auth\AuthManager'),
            m::mock('Illuminate\Routing\RouteCollection'),
            m::mock('Xpressengine\Permission\PermissionRepository'),
        ];
    }
}

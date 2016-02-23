<?php
namespace Xpressengine\Tests\Permission;

use Mockery as m;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\Permission;

class PermissionHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testLoad()
    {
        list($repo) = $this->getMocks();
        $instance = m::mock('Xpressengine\Permission\PermissionHandler[makeKeyForLoaded, find]', [$repo])
            ->shouldAllowMockingProtectedMethods();

        $mockPermission = m::mock('Xpressengine\Permission\Permission');

        $instance->shouldReceive('makeKeyForLoaded')->once()
            ->with('default', 'plugin.dummy')
            ->andReturn('default-plugin.dummy');
        $instance->shouldReceive('find')->once()->with('plugin.dummy', 'default')->andReturn($mockPermission);

        $this->assertTrue($this->invokeMethod($instance, 'load', ['default', 'plugin.dummy']));
    }

    public function testFind()
    {
        list($repo) = $this->getMocks();
        $instance = m::mock('Xpressengine\Permission\PermissionHandler[setAncestor]', [$repo])
            ->shouldAllowMockingProtectedMethods();

        $mockPermission = m::mock('Xpressengine\Permission\Permission');

        $instance->shouldReceive('setAncestor')->once()->with($mockPermission);
        $repo->shouldReceive('findByName')->once()->with('default', 'plugin.dummy')->andReturn($mockPermission);

        $permission = $instance->find('plugin.dummy', 'default');

        $this->assertEquals($mockPermission, $permission);
    }

    public function testSetAncestor()
    {
        list($repo) = $this->getMocks();
        $instance = new PermissionHandler($repo);

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockParent = m::mock('Xpressengine\Permission\Permission');
        $mockParent->shouldReceive('get')->with('siteKey')->andReturn('default');
        $mockParent->shouldReceive('get')->with('name')->andReturn('plugin');

        $repo->shouldReceive('fetchAncestor')->once()->with($mockPermission)->andReturn([$mockParent]);

        $mockPermission->shouldReceive('addParent')->once()->with($mockParent);

        $this->invokeMethod($instance, 'setAncestor', [$mockPermission]);
    }

    public function testFindOrNew()
    {
        list($repo) = $this->getMocks();
        $instance = m::mock('Xpressengine\Permission\PermissionHandler[find, setAncestor]', [$repo])
            ->shouldAllowMockingProtectedMethods();

        $instance->shouldReceive('find')->once()->with('plugin.dummy', 'default')->andReturnNull();
        $instance->shouldReceive('setAncestor')->once()->with(m::on(function ($permission) {
            return $permission instanceof Permission;
        }));

        $permission = $instance->findOrNew('plugin.dummy', 'default');

        $this->assertEquals('default', $permission->siteKey);
        $this->assertEquals('plugin.dummy', $permission->name);
    }

    public function testRegisterExecutedInsertWhenNotExists()
    {
        list($repo) = $this->getMocks();
        $instance = new PermissionHandler($repo);

        $grant = new Grant();
        $grant->set('access', 'guest');
        $grant->set('delete', 'group', ['group_id_1', 'group_id_2']);

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockParent = m::mock('Xpressengine\Permission\Permission');
        $mockParent->shouldReceive('get')->with('siteKey')->andReturn('default');
        $mockParent->shouldReceive('get')->with('name')->andReturn('plugin');

        $repo->shouldReceive('findByName')->once()->with('default', 'plugin.dummy')->andReturnNull();
        $repo->shouldReceive('fetchAncestor')->once()->andReturn([$mockParent]);
        $repo->shouldReceive('insert')->once()->with(m::on(function ($value) {
            return $value instanceof Permission;
        }))->andReturn($mockPermission);


        $instance->register('plugin.dummy', $grant, 'default');
    }

    public function testRegisterExecutedUpdateWhenNotExists()
    {
        list($repo) = $this->getMocks();
        $instance = m::mock('Xpressengine\Permission\PermissionHandler[findOrNew]', [$repo])
            ->shouldAllowMockingProtectedMethods();

        $grant = new Grant();
        $grant->set('access', 'guest');
        $grant->set('delete', 'group', ['group_id_1', 'group_id_2']);

        $mockParent = m::mock('Xpressengine\Permission\Permission');
        $mockParent->shouldReceive('get')->with('siteKey')->andReturn('default');
        $mockParent->shouldReceive('get')->with('name')->andReturn('plugin');

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockPermission->exists = true;
        $mockPermission->shouldReceive('setGrant')->once()->with($grant)->andReturnNull();

        $instance->shouldReceive('findOrNew')->once()->with('plugin.dummy', 'default')->andReturn($mockPermission);

        $repo->shouldReceive('update')->once()->with($mockPermission)->andReturn($mockPermission);

        $instance->register('plugin.dummy', $grant, 'default');
    }

    public function testDestory()
    {
        list($repo) = $this->getMocks();
        $instance = m::mock('Xpressengine\Permission\PermissionHandler[find]', [$repo])
            ->shouldAllowMockingProtectedMethods();

        $mockPermission = m::mock('Xpressengine\Permission\Permission');

        $instance->shouldReceive('find')->once()->with('plugin.dummy', 'default')->andReturn($mockPermission);
        $repo->shouldReceive('delete')->once()->with($mockPermission);

        $instance->destroy('plugin.dummy', 'default');
    }

    public function testMoveThrowsExceptionWhenGivenInvalidTo()
    {
        list($repo) = $this->getMocks();
        $instance = new PermissionHandler($repo);

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockPermission->shouldReceive('get')->with('siteKey')->andReturn('default');
        $mockPermission->shouldReceive('get')->with('type')->andReturn('instance');

        $repo->shouldReceive('findByName')->once()->with('default', 'invalid.to')->andReturnNull();


        try {
            $instance->move($mockPermission, 'invalid.to');

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Permission\Exceptions\InvalidArgumentException', $e);
        }
    }

    public function testMoveThrowsExceptionWhenNotTopAndNotHasParent()
    {
        list($repo) = $this->getMocks();
        $instance = new PermissionHandler($repo);

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockPermission->shouldReceive('getParent')->andReturnNull();
        $mockPermission->shouldReceive('getDepth')->andReturn(2);

        try {
            $instance->move($mockPermission);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Permission\Exceptions\NoParentException', $e);
        }
    }

    public function testMoveFromTopToAnotherChild()
    {
        list($repo) = $this->getMocks();
        $instance = new PermissionHandler($repo);

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockPermission->shouldReceive('get')->with('siteKey')->andReturn('default');
        $mockPermission->shouldReceive('get')->with('type')->andReturn('instance');
        $mockPermission->shouldReceive('getParent')->andReturnNull();
        $mockPermission->shouldReceive('getDepth')->andReturn(1);

        $mockToRegistered = m::mock('Xpressengine\Permission\Permission');
        $mockToRegistered->shouldReceive('get')->with('type')->andReturn('instance');

        $repo->shouldReceive('findByName')->once()->with('default', 'valid.to')->andReturn($mockToRegistered);
        $repo->shouldReceive('affiliate')->once()->with($mockPermission, 'valid.to');


        $instance->move($mockPermission, 'valid.to');
    }

    public function testMoveFromChildToTop()
    {
        list($repo) = $this->getMocks();
        $instance = new PermissionHandler($repo);

        $mockParent = m::mock('Xpressengine\Permission\Permission');

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockPermission->shouldReceive('getParent')->andReturn($mockParent);

        $repo->shouldReceive('foster')->once()->with($mockPermission, null);


        $instance->move($mockPermission);
    }

    public function testMoveFromChildToAnotherChild()
    {
        list($repo) = $this->getMocks();
        $instance = new PermissionHandler($repo);

        $mockParent = m::mock('Xpressengine\Permission\Permission');

        $mockPermission = m::mock('Xpressengine\Permission\Permission');
        $mockPermission->shouldReceive('get')->with('siteKey')->andReturn('default');
        $mockPermission->shouldReceive('get')->with('type')->andReturn('instance');
        $mockPermission->shouldReceive('getParent')->andReturn($mockParent);

        $mockToRegistered = m::mock('Xpressengine\Permission\Permission');
        $mockToRegistered->shouldReceive('get')->with('type')->andReturn('instance');

        $repo->shouldReceive('findByName')->once()->with('default', 'valid.to')->andReturn($mockToRegistered);
        $repo->shouldReceive('foster')->once()->with($mockPermission, 'valid.to');


        $instance->move($mockPermission, 'valid.to');
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Permission\PermissionRepository'),
        ];
    }

    private function invokeMethod(&$object, $methodName, array $parameters = array())
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}

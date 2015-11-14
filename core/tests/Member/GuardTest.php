<?php
namespace Xpressengine\Tests\Member;

use Mockery as m;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Xpressengine\Member\Entities\Guest;
use Xpressengine\Member\Guard;

class GuardTest extends \PHPUnit_Framework_TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testIsAuthedReturnsTrueWhenUserIsNotNull()
    {
        $user = m::mock('\Xpressengine\Member\Authenticatable');
        $mock = $this->getGuard();
        $mock->setUser($user);
        $this->assertTrue($mock->check());
        $this->assertFalse($mock->guest());
    }
    public function testUserMethodReturnsCachedUser()
    {
        $user = m::mock('\Xpressengine\Member\Authenticatable');
        $mock = $this->getGuard();
        $mock->setUser($user);
        $this->assertEquals($user, $mock->user());
    }
    public function testNullIsReturnedForUserIfNoUserFound()
    {
        $mock = $this->getGuard();
        $mock->getSession()->shouldReceive('get')->once()->andReturn(null);
        $this->assertInstanceOf('\Xpressengine\Member\Entities\Guest', $mock->user());
    }
    public function testUserIsSetToRetrievedUser()
    {
        $mock = $this->getGuard();
        $mock->getSession()->shouldReceive('get')->once()->andReturn(1);
        $user = m::mock('\Xpressengine\Member\Authenticatable');
        $mock->getProvider()->shouldReceive('retrieveById')->once()->with(1)->andReturn($user);
        $this->assertEquals($user, $mock->user());
        $this->assertEquals($user, $mock->getUser());
    }

    public function testIdIfUserGiven()
    {
        $user = m::mock('\Xpressengine\Member\Authenticatable');
        $user->shouldReceive('getAuthIdentifier')->once()->andReturn(1);

        $mock = $this->getGuard();
        $mock->getSession()->shouldReceive('get')->once()->andReturn(null);
        $mock->setUser($user);

        $this->assertEquals(1, $mock->id());
    }

    public function testIdReturnNullIfUserNotGiven()
    {
        $mock = $this->getGuard();
        $mock->getSession()->shouldReceive('get')->twice()->andReturn(null);

        $this->assertEquals(null, $mock->id());
    }

    public function testLogoutRemovesSessionTokenAndRememberMeCookie()
    {
        list($session, $provider, $request, $cookie) = $this->getMocks();
        $mock = $this->getMock('\Xpressengine\Member\Guard', ['getName', 'getRecallerName'], [$provider, $session, $request]);
        $mock->setCookieJar($cookies = m::mock('Illuminate\Cookie\CookieJar'));

        $user = m::mock('Illuminate\Contracts\Auth\Authenticatable');
        $user->shouldReceive('setRememberToken')->once();

        $mock->expects($this->once())->method('getName')->will($this->returnValue('foo'));
        $mock->expects($this->once())->method('getRecallerName')->will($this->returnValue('bar'));

        $provider->shouldReceive('updateRememberToken')->once();
        $cookie = m::mock('Symfony\Component\HttpFoundation\Cookie');
        $cookies->shouldReceive('forget')->once()->with('bar')->andReturn($cookie);
        $cookies->shouldReceive('queue')->once()->with($cookie);

        $mock->getSession()->shouldReceive('remove')->once()->with('foo');
        $mock->setUser($user);
        $mock->logout();

        $this->assertNull($mock->getUser());
    }

    protected function getGuard()
    {
        list($session, $provider, $request, $cookie) = $this->getMocks();
        return new Guard($provider, $session, $request);
    }

    protected function getMocks()
    {
        return [
            m::mock('Symfony\Component\HttpFoundation\Session\SessionInterface'),
            m::mock('Illuminate\Contracts\Auth\UserProvider'),
            Request::create('/', 'GET'),
            m::mock('Illuminate\Cookie\CookieJar'),
        ];
    }
}

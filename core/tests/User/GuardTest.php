<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Illuminate\Cookie\CookieJar;
use Mockery as m;
use Symfony\Component\HttpFoundation\Request;
use Xpressengine\User\Guard;
use Xpressengine\User\Models\Guest;

class GuardTest extends \PHPUnit\Framework\TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testIsAuthedReturnsTrueWhenUserIsNotNull()
    {
        $user = m::mock(\Xpressengine\User\Models\User::class);
        $mock = $this->getGuard();
        $mock->setUser($user);
        $this->assertTrue($mock->check());
        $this->assertFalse($mock->guest());
    }

    public function testUserMethodReturnsCachedUser()
    {
        $user = m::mock(\Xpressengine\User\Models\User::class);
        $mock = $this->getGuard();
        $mock->setUser($user);
        $this->assertEquals($user, $mock->user());
    }
    public function testNullIsReturnedForUserIfNoUserFound()
    {
        $mock = $this->getGuard();
        $mock->getSession()->shouldReceive('get')->once()->andReturn(null);
        $this->assertInstanceOf(\Xpressengine\User\Models\Guest::class, $mock->user());
    }
    public function testUserIsSetToRetrievedUser()
    {
        $mock = $this->getGuard();
        $mock->getSession()->shouldReceive('get')->once()->andReturn(1);
        $user = m::mock(\Xpressengine\User\Models\User::class);
        $mock->getProvider()->shouldReceive('retrieveById')->once()->with(1)->andReturn($user);
        $this->assertEquals($user, $mock->user());
        $this->assertEquals($user, $mock->getUser());
    }

    public function testIdIfUserGiven()
    {
        $user = m::mock(\Xpressengine\User\Models\User::class);
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
        list($session, $provider, $adminAuth, $request) = $this->getMocks();

        $mock = $this->getMockBuilder(Guard::class)
            ->setMethods(['clearUserDataFromStorage'])
            ->setConstructorArgs(['xe', $provider, $session, $adminAuth, $request])
            ->getMock();
        $mock->setCookieJar($cookies = m::mock(CookieJar::class));

        $user = m::mock(\Illuminate\Contracts\Auth\Authenticatable::class);
        $user->shouldReceive('setRememberToken');

        $mock->expects($this->once())->method('clearUserDataFromStorage')->will($this->returnValue(null));

        /** @var m\MockInterface $session */
        $session->shouldReceive('remove')->once()->with('auth.admin')->andReturnNull();

        $provider->shouldReceive('updateRememberToken');

        $mock->setUser($user);
        $mock->logout();

        $this->assertInstanceOf(Guest::class, $mock->getUser());
    }

    protected function getGuard()
    {
        list($session, $provider, $adminAuth, $request) = $this->getMocks();
        return new Guard('xe', $provider, $session, $adminAuth, $request);
    }

    protected function getMocks()
    {
        return [
            m::mock(\Illuminate\Contracts\Session\Session::class),
            m::mock(\Illuminate\Contracts\Auth\UserProvider::class),
            ['session'=>'auth.admin', 'expire'=>30, 'password'=>'password'],
            Request::create('/', 'GET'),
        ];
    }
}

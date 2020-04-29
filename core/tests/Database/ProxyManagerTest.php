<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Database;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Database\ProxyManager;

/**
 * Class ProxyManagerTest
 * @package Xpressengine\Tests\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ProxyManagerTest extends TestCase
{
    /**
     * @var \Xpressengine\Register\Container
     */
    protected $register;

    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        ProxyManager::destruct();
        m::close();
    }

    /**
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        $register = m::mock('Xpressengine\Register\Container');
        $register->shouldReceive('set');

        $this->register = $register;
    }

    /**
     * @return m\MockInterface|\Xpressengine\Database\ProxyInterface
     */
    private function getProxyInstance()
    {
        return m::mock('Xpressengine\Database\ProxyInterface');
    }

    /**
     * test register
     *
     * @return void
     */
    public function testRegister()
    {
        $register = $this->register;
        $proxyManager = ProxyManager::instance($register);

        $proxyInstance = $this->getProxyInstance();

        $register->shouldReceive('push');
        $proxyManager->register($proxyInstance);
    }

    /**
     * test get registered
     *
     * @return void
     */
    public function testGets()
    {
        $register = $this->register;
        $proxyManager = ProxyManager::instance($register);

        $proxyInstance = $this->getProxyInstance();

        $register->shouldReceive('get')->andReturn([
            $proxyInstance
        ]);

        $result = $proxyManager->gets($proxyInstance);

        $this->assertInstanceOf('Xpressengine\Database\ProxyInterface', $result[0]);
    }

    /**
     * test get registered proxy
     *
     * @expectedException \Xpressengine\Database\Exceptions\NotExistsProxyException
     * @return void
     */
    public function testGetProxy()
    {
        $register = $this->register;
        $proxyManager = ProxyManager::instance($register);

        $proxyInstance = $this->getProxyInstance();
        $register->shouldReceive('get')->with(ProxyManager::REGISTER_KEY, 'a')->andReturn($proxyInstance);
        $register->shouldReceive('get')->with(ProxyManager::REGISTER_KEY, 'b')->andReturn(null);

        $result = $proxyManager->getProxy('a');
        $this->assertInstanceOf('Xpressengine\Database\ProxyInterface', $result);

        $proxyManager->getProxy('b');
    }

    /**
     * test proxy interface
     *
     * @return void
     */
    public function testProxyInterface()
    {
        $register = $this->register;
        $proxyManager = ProxyManager::instance($register);

        $connector = m::mock('Xpressengine\Database\VirtualConnectionInterface');

        $proxyInstance = $this->getProxyInstance();
        $proxyInstance->shouldReceive('set');
        $proxyInstance->shouldReceive('insert');
        $proxyInstance->shouldReceive('update');
        $proxyInstance->shouldReceive('delete');

        $register->shouldReceive('get')->andReturn([
            $proxyInstance
        ]);

        $proxyManager->set($connector, []);
        $proxyManager->insert([]);
        $proxyManager->update([], []);
        $proxyManager->delete([]);

        $query = m::mock('Xpressengine\Database\DynamicQuery');

        $proxyInstance->shouldReceive('get')->andReturn($query);
        $proxyInstance->shouldReceive('first')->andReturn($query);
        $proxyInstance->shouldReceive('wheres')->andReturn($query);
        $proxyInstance->shouldReceive('orders')->andReturn($query);

        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $proxyManager->get($query));
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $proxyManager->first($query));
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $proxyManager->wheres($query, []));
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $proxyManager->orders($query, []));
    }
}

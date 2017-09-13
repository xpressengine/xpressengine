<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Database;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Database\DatabaseCoupler;

/**
 * Class DatabaseCouplerTest
 * @package Xpressengine\Tests\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DatabaseCouplerTest extends TestCase
{
    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        DatabaseCoupler::destruct();
        m::close();
    }


    /**
     * test get attributes
     *
     * @return void
     */
    public function testGetAttributes()
    {
        $databaseManager = m::mock('Illuminate\Database\DatabaseManager');

        $transactionHandler = m::mock('Xpressengine\Database\TransactionHandler');
        $transactionHandler->shouldReceive('init')->andReturn();

        $proxyManager = m::mock('Xpressengine\Database\ProxyManager');

        /**
         * @var \Illuminate\Database\DatabaseManager $databaseManager
         * @var \Xpressengine\Database\TransactionHandler $transactionHandler
         * @var \Xpressengine\Database\ProxyManager $proxyManager
         */
        $coupler = DatabaseCoupler::instance($databaseManager, $transactionHandler, $proxyManager);

        $this->assertInstanceOf('Illuminate\Database\DatabaseManager', $coupler->databaseManager());
        $this->assertInstanceOf('Xpressengine\Database\ProxyManager', $coupler->getProxy());
        $this->assertInstanceOf('Xpressengine\Database\TransactionHandler', $coupler->getTransaction());
    }

    /**
     * test manager connector
     *
     * @return void
     */
    public function testManageConnector()
    {

        $defaultConnection = m::mock('Illuminate\Database\Connection');
        $defaultConnection->shouldReceive('getName')->andReturn('default');
        $defaultConnection->shouldReceive('transactionLevel')->andReturn(0);

        $someConnection = m::mock('Illuminate\Database\Connection');
        $someConnection->shouldReceive('getName')->andReturn('some');
        $someConnection->shouldReceive('transactionLevel')->andReturn(0);

        $databaseManager = m::mock('Illuminate\Database\DatabaseManager');
        $databaseManager->shouldReceive('connection')->with(null)->andReturn($defaultConnection);
        $databaseManager->shouldReceive('connection')->with('some')->andReturn($someConnection);

        $transactionHandler = m::mock('Xpressengine\Database\TransactionHandler');
        $transactionHandler->shouldReceive('init')->andReturn();
        $transactionHandler->shouldReceive('setCurrent')->andReturn();

        $proxyManager = m::mock('Xpressengine\Database\ProxyManager');

        /**
         * @var \Illuminate\Database\DatabaseManager $databaseManager
         * @var \Xpressengine\Database\TransactionHandler $transactionHandler
         * @var \Xpressengine\Database\ProxyManager $proxyManager
         */
        $coupler = DatabaseCoupler::instance($databaseManager, $transactionHandler, $proxyManager);

        $newConnector = m::mock('Xpressengine\Database\VirtualConnection');
        $newConnector->shouldReceive('getName')->andReturn('default');
        $coupler->addConnector('default', $newConnector);
        $this->assertEquals(1, count($coupler->connectors()));

        $newConnector = m::mock('Xpressengine\Database\VirtualConnection');
        $newConnector->shouldReceive('getName')->andReturn('some');
        $coupler->addConnector('some', $newConnector);
        $this->assertEquals(2, count($coupler->connectors()));

        $connector = $coupler->getConnector();
        $this->assertEquals('default', $connector->getName());
        $connector = $coupler->getConnector('some');
        $this->assertEquals('some', $connector->getName());


        $connection = $coupler->connect('default');
        $this->assertEquals('default', $connection->getName());

        $connection = $coupler->connect('some');
        $this->assertEquals('some', $connection->getName());
    }
}

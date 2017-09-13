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
use Xpressengine\Database\DatabaseHandler;

/**
 * Class DatabaseHandlerTest
 * @package Xpressengine\Tests\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DatabaseHandlerTest extends TestCase
{
    protected $coupler;

    /**
     * @var array
     */
    protected $databaseConfig = [
        'default' => [
            'master' => ['master_conn'],
            'slave' => ['slave_conn'],
        ],
        'some' => [
            'master' => ['master_conn', 'some1_con'],
            'slave' => ['slave_conn', 'some2_con'],
        ]
    ];

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
     * test database connect
     *
     * @return void
     */
    public function testDatabaseConnect()
    {

        $defaultConnection = m::mock('Illuminate\Database\Connection');
        $defaultConnection->shouldReceive('getName')->andReturn('default');

        $databaseManager = m::mock('Illuminate\Database\DatabaseManager');
        $databaseManager->shouldReceive('getDefaultConnection')->andReturn($defaultConnection);
        $databaseManager->shouldReceive('setDefaultConnection');

        $queryBuilder = m::mock('Xpressengine\Database\DynamicQuery');

        $defaultConnector = m::mock('Xpressengine\Database\VirtualConnection');
        $defaultConnector->shouldReceive('getName')->andReturn('default');
        $defaultConnector->shouldReceive('table')->andReturn($queryBuilder);

        $someConnector = m::mock('Xpressengine\Database\VirtualConnection');
        $someConnector->shouldReceive('getName')->andReturn('some');

        $coupler = m::mock('Xpressengine\Database\DatabaseCoupler');
        $coupler->shouldReceive('getConnector')->with(DatabaseHandler::DEFAULT_CONNECTOR_NAME)->andReturn(
            $defaultConnector
        );
        $coupler->shouldReceive('getConnector')->with('some')->andReturn($someConnector);
        $coupler->shouldReceive('addConnector')->with('default', $defaultConnector)->andReturn($defaultConnector);
        $coupler->shouldReceive('addConnector')->with('some', $someConnector)->andReturn($someConnector);
        $coupler->shouldReceive('databaseManager')->andReturn($databaseManager);

        /** @var \Xpressengine\Database\DatabaseCoupler $coupler */
        $handler = new DatabaseHandler(
            $coupler,
            $this->databaseConfig
        );

        // make default connector
        $connector = $handler->connection();
        $this->assertInstanceOf('Xpressengine\Database\VirtualConnection', $connector);
        $this->assertEquals('default', $connector->getName());


        $connection = $handler->getDefaultConnection();
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('default', $connection->getName());

        $handler->setDefaultConnection('some1_con');

        // test magic method
        $queryBuilder = $handler->table('table');
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $queryBuilder);
    }
}

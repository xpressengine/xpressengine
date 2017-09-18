<?php
/**
 * connector test
 *
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Database;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Database\DatabaseCoupler;
use Xpressengine\Database\VirtualConnection;
use PDO;
use Exception;

/**
 * Class DatabaseCouplerTest
 * @package Xpressengine\Tests\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class VirtualConnectionTest extends TestCase
{
    /**
     * connector 설정의 이름
     */
    const CONN_NAME = 'default';

    /**
     * table prefix 이름
     */
    const TABLE_PREFIX = 'prefix';

    /**
     * connector 를 생성하기 위한 설정 값
     * xe.php 설정의 database 설정이 넘어가야함.
     *
     * @var array
     */
    protected $databaseConfig = [
        'master' => ['master_conn'],
        'slave' => ['slave_conn'],
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
     * test get connector name
     *
     * @return void
     */
    public function testGetName()
    {
        $databaseCoupler = m::mock('Xpressengine\Database\DatabaseCoupler');

        /** @var DatabaseCoupler $databaseCoupler */
        $connector = new VirtualConnection($databaseCoupler, self::CONN_NAME, $this->databaseConfig);

        $name = $connector->getName();

        $this->assertEquals(self::CONN_NAME, $name);
    }

    /**
     * test get default connection
     *
     * @return void
     */
    public function testGetDefaultConnection()
    {
        $defaultConnection = m::mock('Illuminate\Database\Connection');

        $databaseCoupler = m::mock('Xpressengine\Database\DatabaseCoupler');
        $databaseCoupler->shouldReceive('connect')->andReturn($defaultConnection);

        /** @var DatabaseCoupler $databaseCoupler */
        $connector = new VirtualConnection($databaseCoupler, self::CONN_NAME, $this->databaseConfig);

        $connection  = $connector->getDefaultConnection();

        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
    }

    /**
     * test Illuminate\Database\ConnectionInterface
     *
     * @return void
     * @see Illuminate\Database\ConnectionInterface
     */
    public function testConnectionInterface()
    {
        $defaultConnection = m::mock('Illuminate\Database\Connection');
        $defaultConnection->shouldReceive('getSchemaBuilder')->andReturn(
            m::mock('Illuminate\Database\Schema\Builder')
        );
        $defaultConnection->shouldReceive('getTablePrefix')->andReturn(self::TABLE_PREFIX);

        $databaseCoupler = m::mock('Xpressengine\Database\DatabaseCoupler');
        $databaseCoupler->shouldReceive('connect')->andReturn($defaultConnection);

        /** @var DatabaseCoupler $databaseCoupler */
        $connector = new VirtualConnection($databaseCoupler, self::CONN_NAME, $this->databaseConfig);

        $schemaBuilder = $connector->getSchemaBuilder();
        $this->assertInstanceOf('Illuminate\Database\Schema\Builder', $schemaBuilder);

        $tablePrefix = $connector->getTablePrefix();
        $this->assertEquals(self::TABLE_PREFIX, $tablePrefix);
    }

    /**
     * test get proxy manager
     *
     * @return void
     */
    public function testGetProxyManager()
    {
        $databaseCoupler = m::mock('Xpressengine\Database\DatabaseCoupler');
        $databaseCoupler->shouldReceive('getProxy')->andReturn(
            m::mock('Xpressengine\Database\ProxyManager')
        );

        /** @var DatabaseCoupler $databaseCoupler */
        $connector = new VirtualConnection($databaseCoupler, self::CONN_NAME, $this->databaseConfig);

        $proxyManager = $connector->getProxyManager();
        $this->assertInstanceOf('Xpressengine\Database\ProxyManager', $proxyManager);
    }

    /**
     * test connection
     *
     * @return void
     */
    public function testConnection()
    {
        $masterConnection = m::mock('Illuminate\Database\Connection');
        $masterConnection->shouldReceive('setFetchMode')->andReturn(null);
        $masterConnection->shouldReceive('getName')->andReturn('master_conn');

        $slaveConnection = m::mock('Illuminate\Database\Connection');
        $slaveConnection->shouldReceive('setFetchMode')->andReturn(null);
        $slaveConnection->shouldReceive('getName')->andReturn('slave_conn');

        $databaseCoupler = m::mock('Xpressengine\Database\DatabaseCoupler');
        $databaseCoupler->shouldReceive('connect')->with('master_conn')->andReturn(
            $masterConnection
        );
        $databaseCoupler->shouldReceive('connect')->with('slave_conn')->andReturn(
            $slaveConnection
        );

        /** @var DatabaseCoupler $databaseCoupler */
        $connector = new VirtualConnection($databaseCoupler, self::CONN_NAME, $this->databaseConfig);

        $connection = $connector->connection('master');
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('master_conn', $connection->getName());

        $connection = $connector->connection('slave');
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('slave_conn', $connection->getName());

        $connection = $connector->master();
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('master_conn', $connection->getName());

        $connection = $connector->slave();
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('slave_conn', $connection->getName());

        $connection = $connector->getConnection('select');
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('slave_conn', $connection->getName());

        $connection = $connector->getConnection('insert');
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('master_conn', $connection->getName());

        $connection = $connector->getConnection('transaction');
        $this->assertInstanceOf('Illuminate\Database\Connection', $connection);
        $this->assertEquals('master_conn', $connection->getName());
    }

    /**
     * test make querybuilder
     *
     * @return void
     */
    public function testGetQueryBuilder()
    {
        $defaultConnection = m::mock('Illuminate\Database\Connection');
        $defaultConnection->shouldReceive('getPostProcessor')->andReturn(
            m::mock('Illuminate\Database\Query\Processors\Processor')
        );
        $defaultConnection->shouldReceive('setFetchMode');
        $defaultConnection->shouldReceive('getQueryGrammar')->andReturn(
            m::mock('Illuminate\Database\Query\Grammars\Grammar')
        );

        $databaseCoupler = m::mock('Xpressengine\Database\DatabaseCoupler');
        $databaseCoupler->shouldReceive('connect')->andReturn($defaultConnection);


        /** @var DatabaseCoupler $databaseCoupler */
        $connector = new VirtualConnection($databaseCoupler, self::CONN_NAME, $this->databaseConfig);

        $queryBuilder = $connector->table('table');
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $queryBuilder);

        $queryBuilder = $connector->dynamic('table');
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $queryBuilder);

        $queryBuilder = $connector->dynamic('table', [], false);
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $queryBuilder);
    }

    /**
     * test transaction handler interface
     *
     * @return void
     */
    public function testTransactionHandler()
    {
        $this->transactionCounter = 0;
        $transactionHandler = m::mock('Xpressengine\Database\TransactionHandler');
        $transactionHandler->shouldReceive('beginTransaction')->andReturn();
        $transactionHandler->shouldReceive('commit')->andReturn();
        $transactionHandler->shouldReceive('rollBack')->andReturn();
        $transactionHandler->shouldReceive('transactionLevel')->andReturn(0);

        $databaseCoupler = m::mock('Xpressengine\Database\DatabaseCoupler');
        $databaseCoupler->shouldReceive('getTransaction')->andReturn(
            $transactionHandler
        );

        /** @var DatabaseCoupler $databaseCoupler */
        $connector = new VirtualConnection($databaseCoupler, self::CONN_NAME, $this->databaseConfig);

        $transaction = $connector->transactionHandler();
        $this->assertInstanceOf('Xpressengine\Database\TransactionHandler', $transaction);

        $connector->beginTransaction();
        $connector->commit();
        $connector->rollBack();
        $level = $connector->transactionLevel();
        $this->assertEquals(0, $level);
    }
}

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
use Xpressengine\Database\TransactionHandler;

/**
 * Class TransactionHandlerTest
 * @package Xpressengine\Tests\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class TransactionHandlerTest extends TestCase
{
    protected $connector;

    /**
     * @var TransactionHandler
     */
    protected $transaction;

    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        TransactionHandler::destruct();
        m::close();
    }

    /**
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        $transaction = TransactionHandler::instance();

        $this->transaction = $transaction;
    }

    /**
     * invoked method
     *
     * @param mixed  $object     object
     * @param string $methodName method name
     * @param array  $parameters parameters
     * @return mixed
     */
    private function invokeMethod(&$object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * set property
     *
     * @param mixed  $object       object
     * @param string $propertyName method name
     * @param mixed  $value        parameters
     * @return void
     */
    private function setProperty(&$object, $propertyName, $value)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);
        $property->setValue($object, $value);
    }


    /**
     * get connector
     *
     * @return m\MockInterface|\Xpressengine\Database\VirtualConnection
     */
    private function getConnector()
    {
        return m::mock('Xpressengine\Database\VirtualConnection');
    }

    /**
     * get connection
     *
     * @return m\MockInterface|\Illuminate\Database\Connection
     */
    private function getConnection()
    {
        return m::mock('Illuminate\Database\Connection');
    }

    /**
     * get database coupler
     *
     * @return m\MockInterface|\Xpressengine\Database\DatabaseCoupler
     */
    private function getDatabaseCoupler()
    {
        return m::mock('Xpressengine\Database\DatabaseCoupler');
    }

    /**
     * test set current
     * 다중 connection 을 지원할 때 여러 database 의 transaction 을 하나로 처리하기 위해서
     * 새로 connection 을 연결 할 때 transaction 이 시작되었는지 확인해서 처리
     *
     * @return void
     */
    public function testSetCurrent()
    {
        $transaction = $this->transaction;
        $connection = $this->getConnection();

        // 시작된 트랜잭션 없음
        $transaction->setCurrent($connection);


        $this->setProperty($transaction, 'globalTransactions', 1);

        // 시작된 트랜잭션 있고 connection 에도 transaction 이 시작되어 있음
        $connection->shouldReceive('transactionLevel')->once()->andReturn(1);
        $transaction->setCurrent($connection);

        // 시작된 트랜잭션 있고 connection dms transaction 이 시작 안됨
        $connection->shouldReceive('transactionLevel')->once()->andReturn(0);
        $connection->shouldReceive('beginTransaction')->once();
        $transaction->setCurrent($connection);
    }

    /**
     * test begin transaction
     *
     * @return void
     */
    public function testBeginTransaction()
    {
        $transaction = $this->transaction;

        $coupler = $this->getDatabaseCoupler();

        $connector1 = $this->getConnector();
        $connector1->shouldReceive('master')->andReturn($connector1);
        $connector1->shouldReceive('transactionLevel')->once()->andReturn(0);
        $connector1->shouldReceive('transactionLevel')->once()->andReturn(1);
        $connector1->shouldReceive('beginTransaction');
        $connector2 = $this->getConnector();
        $connector2->shouldReceive('master')->andReturn($connector2);
        $connector2->shouldReceive('transactionLevel')->once()->andReturn(0);
        $connector2->shouldReceive('transactionLevel')->once()->andReturn(1);
        $connector2->shouldReceive('beginTransaction');
        $connectors = [$connector1, $connector2];
        $coupler->shouldReceive('connectors')->andReturn($connectors);

        $transaction->beginTransaction($coupler);
        $this->assertEquals(1, $transaction->transactionLevel());

        $transaction->beginTransaction($coupler);
        $this->assertEquals(2, $transaction->transactionLevel());
    }

    /**
     * test commit
     *
     * @return void
     */
    public function testCommit()
    {
        $transaction = $this->transaction;

        $this->setProperty($transaction, 'globalTransactions', 2);

        $coupler = $this->getDatabaseCoupler();

        $connector1 = $this->getConnector();
        $connector1->shouldReceive('master')->andReturn($connector1);
        $connector1->shouldReceive('transactionLevel')->once()->andReturn(0);
        $connector1->shouldReceive('commit');
        $connector2 = $this->getConnector();
        $connector2->shouldReceive('master')->andReturn($connector2);
        $connector2->shouldReceive('transactionLevel')->once()->andReturn(1);
        $connector2->shouldReceive('commit');
        $connectors = [$connector1, $connector2];
        $coupler->shouldReceive('connectors')->andReturn($connectors);

        $transaction->commit($coupler);
        $this->assertEquals(1, $transaction->transactionLevel());

        $transaction->commit($coupler);
        $this->assertEquals(0, $transaction->transactionLevel());
    }

    /**
     * test roll back
     *
     * @return void
     */
    public function testRollBack()
    {
        $transaction = $this->transaction;

        $this->setProperty($transaction, 'globalTransactions', 2);

        $coupler = $this->getDatabaseCoupler();

        $transaction->rollBack($coupler);
        $this->assertEquals(1, $transaction->transactionLevel());

        $this->setProperty($transaction, 'globalTransactions', 1);

        $connector1 = $this->getConnector();
        $connector1->shouldReceive('master')->andReturn($connector1);
        $connector1->shouldReceive('transactionLevel')->once()->andReturn(0);
        $connector1->shouldReceive('rollBack');
        $connector2 = $this->getConnector();
        $connector2->shouldReceive('master')->andReturn($connector2);
        $connector2->shouldReceive('transactionLevel')->once()->andReturn(1);
        $connector2->shouldReceive('rollBack');
        $connectors = [$connector1, $connector2];
        $coupler->shouldReceive('connectors')->andReturn($connectors);

        $transaction->rollBack($coupler);
        $this->assertEquals(0, $transaction->transactionLevel());
    }
}

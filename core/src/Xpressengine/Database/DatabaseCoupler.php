<?php
/**
 * DatabaseCoupler
 *
 * PHP version 5
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database;

use Illuminate\Database\DatabaseManager;

/**
 * DatabaseCoupler
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DatabaseCoupler
{

    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * @var TransactionHandler
     */
    protected $transaction;

    /**
     * @var ProxyManager
     */
    protected $proxy;

    /**
     * list of VirtualConnection
     *
     * @var VirtualConnectionInterface[]
     */
    protected $connectors;

    /**
     * singleton instances
     *
     * @var array
     */
    private static $instance;

    /**
     * singleton
     *
     * @param DatabaseManager    $databaseManager database manager
     * @param TransactionHandler $transaction     transaction handler
     * @param ProxyManager       $proxy           proxy manager
     */
    private function __construct(
        DatabaseManager $databaseManager,
        TransactionHandler $transaction,
        ProxyManager $proxy
    ) {
        $this->databaseManager = $databaseManager;
        $this->transaction = $transaction;
        $this->proxy = $proxy;
    }

    /**
     * destroy singleton instance
     * test 를 위해서 singleton class destruct 를 실행 해야 할 일이 있는데.. 호출 안됨
     * 아마도 내부 $instance 가 null 이 되야 __desctruct 되는 구조인듯
     *
     * @return void
     */
    public static function destruct()
    {
        self::$instance = null;
    }

    /**
     * not able clone
     *
     * @return void
     */
    private function __clone()
    {
        // nothing to do
    }

    /**
     * create instance if not exists
     *
     * @param DatabaseManager    $databaseManager database manager
     * @param TransactionHandler $transaction     transaction handler
     * @param ProxyManager       $proxy           proxy manager
     * @return DatabaseCoupler
     */
    public static function instance(
        DatabaseManager $databaseManager,
        TransactionHandler $transaction,
        ProxyManager $proxy
    ) {
        self::$instance = new static($databaseManager, $transaction, $proxy);

        return self::$instance;
    }

    /**
     * get DatabaseManager
     *
     * @return \Illuminate\Database\DatabaseManager
     */
    public function databaseManager()
    {
        return $this->databaseManager;
    }

    /**
     * get ProxyManager
     *
     * @return ProxyManager
     */
    public function getProxy()
    {
        return $this->proxy;
    }

    /**
     * get TransactionHandler
     *
     * @return TransactionHandler
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * get list of VirtualConnection
     *
     * @return array
     */
    public function connectors()
    {
        return $this->connectors;
    }

    /**
     * get VirtualConnection
     *
     * @param string $name config/xe.php database connector name
     * @return VirtualConnectionInterface
     */
    public function getConnector($name = null)
    {
        if ($name === null) {
            $name = DatabaseHandler::DEFAULT_CONNECTOR_NAME;
        }

        return isset($this->connectors[$name]) ? $this->connectors[$name] : null;
    }

    /**
     * add connector
     *
     * @param string                     $name      config/xe.php database connector name
     * @param VirtualConnectionInterface $connector connector
     * @return VirtualConnectionInterface
     */
    public function addConnector($name, VirtualConnectionInterface $connector)
    {
        return $this->connectors[$name] = $connector;
    }

    /**
     * 실제 처리 될 connection 을 생성해서 반환.
     * > $name 은 config/database.php 에 설정 된 이름이며
     * config/xe.php database 에서 참조됨.
     *
     * @param null|string $connectionName database name
     * @return \Illuminate\Database\Connection
     */
    public function connect($connectionName = null)
    {
        if ($connectionName === 'default') {
            $connectionName = null;
        }

        $connection = $this->databaseManager->connection($connectionName);

        $this->transaction->setCurrent($connection);

        return $connection;
    }
}

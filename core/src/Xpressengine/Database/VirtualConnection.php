<?php
/**
 * VirtualConnection
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

use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Database\Connection;
use Illuminate\Database\DetectsDeadlocks;
use Illuminate\Database\DetectsLostConnections;
use PDO;
use Closure;
use Exception;
use Throwable;

/**
 * VirtualConnection
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class VirtualConnection implements VirtualConnectionInterface
{
    use DetectsDeadlocks,
        DetectsLostConnections;

    /**
     * master type key name
     */
    const TYPE_MASTER = 'master';

    /**
     * slave type key name
     */
    const TYPE_SLAVE = 'slave';

    /**
     * default database connection name (config/database.php 의 기본 connection 설정 이름)
     */
    const DEFAULT_CONNECTION_NAME = 'default';

    /**
     * @var DatabaseCoupler
     */
    protected $coupler;

    /**
     * @var DynamicQuery
     */
    protected $queryBuilder;

    /**
     * connector name
     *
     * @var string
     */
    protected $name;

    /**
     * config/database.php config name for create master connection instance
     *
     * @var string
     */
    protected $master;

    /**
     * config/database.php config name for create slave connection instance
     *
     * @var string
     */
    protected $slave;

    /**
     * @var string $tablePrefix
     */
    protected $tablePrefix;

    /**
     * connections list
     * * config/xe.php database key 에 따라 master, slave 로 구분해서
     * /Illuminate/Database/Connection 을 갖는다.
     * ```php
     *      $connections = [
     *          'master' => /Illuminate/Database/Connection,
     *           'slave' => /Illuminate/Database/Connection,
     *      ]
     * ```
     *
     * @var array
     */
    protected $connections;

    /**
     * Cache store instance
     *
     * @var CacheContract
     */
    protected static $cache;

    /**
     * The number of minutes to store cache items.
     *
     * @var int
     */
    protected $minutes = 60;

    /**
     * Create instance
     *
     * @param DatabaseCoupler $coupler database coupler
     * @param string          $name    connector name
     * @param array           $config  database config (xe.php file 의 database 설정)
     */
    public function __construct(DatabaseCoupler $coupler, $name, array $config)
    {
        $this->coupler = $coupler;
        $this->name = $name;
        $this->setNames($config);
    }

    /**
     * get name for connector
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * DynamicQuery 에서 사용
     * \Illuminate\Database\Query\Builder 를 만들 때 Connection 이 필요함.
     *
     * @return Connection
     */
    public function getDefaultConnection()
    {
        return $this->coupler->connect();
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function getSchemaBuilder()
    {
        return $this->getDefaultConnection()->getSchemaBuilder();
    }

    /**
     * Get table prefix name.
     *
     * @return string
     */
    public function getTablePrefix()
    {
        return $this->getDefaultConnection()->getTablePrefix();
    }

    /**
     * set connection name.
     * 설정된 master, slave 이름들에서 사용 할 이름을 선택.
     *
     * @param array $config database config
     * @return void
     */
    private function setNames(array $config)
    {
        foreach ($this->fixConfig($config) as $type => $names) {
            $this->{$type} = $this->connectionName($names);
        }
    }

    /**
     * 설정 정보 확인
     * master, slave 설정이 없을 경우 기본 설정을 넣어 줌
     *
     * @param array $config database config
     * @return mixed
     */
    private function fixConfig(array $config)
    {
        if (isset($config[self::TYPE_MASTER]) === false) {
            $config[self::TYPE_MASTER] = [self::DEFAULT_CONNECTION_NAME];
        }

        if (isset($config[self::TYPE_SLAVE]) === false) {
            $config[self::TYPE_SLAVE] = [self::DEFAULT_CONNECTION_NAME];
        }

        return $config;
    }

    /**
     * $type 에서 사용 될 connection name 결정.
     *
     * @param array $names connection 이름
     * @return \Illuminate\Database\Connection
     */
    private function connectionName($names)
    {
        $index = $_SERVER['REQUEST_TIME'] % count($names);
        return $names[$index];
    }

    /**
     * get ProxyManager.
     * DynamicQuery 에서 VirtualConnection 를 주입 받아 사용.
     *
     * @return ProxyManager
     */
    public function getProxyManager()
    {
        return $this->coupler->getProxy();
    }

    /**
     * get connection
     *
     * @param string $type master or slave
     * @return \Illuminate\Database\Connection
     */
    public function connection($type = self::DEFAULT_CONNECTION_NAME)
    {
        $connection = ($this->connections[$type] === null) ?
            $this->coupler->connect($this->{$type}) :
            $this->connections[$type];

        return $connection;
    }

    /**
     * get master connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function master()
    {
        return $this->connection(self::TYPE_MASTER);
    }

    /**
     * get slave connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function slave()
    {
        return $this->connection(self::TYPE_SLAVE);
    }

    /**
     * get connection by $queryType.
     * 'select' 쿼리일 경우 $slaveConnection 을 넘겨주고 그렇지 않을 경우 $masterConnection 을 반환.
     * database 를 쿼리 실행 시 연결.
     *
     * @param string $type query type
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection($type = 'select')
    {
        if ($type === 'select') {
            return $this->connection(self::TYPE_SLAVE);
        } else {
            return $this->connection(self::TYPE_MASTER);
        }
    }

    /**
     * Begin a fluent query against a database table.
     * ProxyManager 를 통한 처리를 하지 않음.
     *
     * @param string $table table name
     * @return DynamicQuery
     */
    public function table($table)
    {
        return $this->query()->from($table);
    }

    /**
     * DynamicField 를 이용해 처리.
     * ProxyManager 에 register 된 Proxy 들을 처리.
     *
     * @param string $table   table name
     * @param array  $options proxy options
     * @param bool   $proxy   use proxy
     * @return DynamicQuery
     */
    public function dynamic($table, array $options = [], $proxy = true)
    {
        if (empty($options['table'])) {
            $options['table'] = $table;
        }
        $query = $this->query();
        $query->setProxyOption($options);
        $query->useDynamic(true);
        $query->useProxy($proxy);
        return $query->from($table);
    }


    /**
     * Get a new query builder instance.
     *
     * @return DynamicQuery
     */
    public function query()
    {
        /** @var VirtualConnection $this */
        return new DynamicQuery($this, $this->getQueryGrammar(), $this->getPostProcessor());
    }

    /**
     * Get a new raw query expression.
     *
     * @param mixed $value value
     * @return \Illuminate\Database\Query\Expression
     */
    public function raw($value)
    {
        return $this->getConnection()->raw($value);
    }

    /**
     * Run a select statement and return a single result.
     *
     * @param string $query    query
     * @param array  $bindings bindings
     * @return mixed
     */
    public function selectOne($query, $bindings = array())
    {
        return $this->getConnection()->selectOne($query, $bindings);
    }

    /**
     * Run a select statement against the database.
     *
     * @param string $query    query
     * @param array  $bindings bindings
     * @return array
     */
    public function select($query, $bindings = array())
    {
        return $this->getConnection()->select($query, $bindings);
    }

    /**
     * Run an insert statement against the database.
     *
     * @param string $query    query
     * @param array  $bindings bindings
     * @return bool
     */
    public function insert($query, $bindings = array())
    {
        return $this->getConnection('insert')->insert($query, $bindings);
    }

    /**
     * Run an update statement against the database.
     *
     * @param string $query    query
     * @param array  $bindings bindings
     * @return int
     */
    public function update($query, $bindings = array())
    {
        return $this->getConnection('update')->update($query, $bindings);
    }

    /**
     * Run a delete statement against the database.
     *
     * @param string $query    query
     * @param array  $bindings bindings
     * @return int
     */
    public function delete($query, $bindings = array())
    {
        return $this->getConnection('delete')->delete($query, $bindings);
    }

    /**
     * Execute an SQL statement and return the boolean result.
     *
     * @param string $query    query
     * @param array  $bindings bindings
     * @return bool
     */
    public function statement($query, $bindings = array())
    {
        return $this->getConnection()->statement($query, $bindings);
    }

    /**
     * Run an SQL statement and get the number of rows affected.
     *
     * @param string $query    query
     * @param array  $bindings bindings
     * @return int
     */
    public function affectingStatement($query, $bindings = array())
    {
        return $this->getConnection()->affectingStatement($query, $bindings);
    }

    /**
     * Run a raw, unprepared query against the PDO connection.
     *
     * @param string $query query
     * @return bool
     */
    public function unprepared($query)
    {
        return $this->getConnection()->unprepared($query);
    }

    /**
     * Prepare the query bindings for execution.
     *
     * @param array $bindings bindings
     * @return array
     */
    public function prepareBindings(array $bindings)
    {
        return $this->getConnection()->prepareBindings($bindings);
    }

    /**
     * Execute a Closure within a transaction.
     *
     * @param \Closure $callback callback
     * @param int      $attempts number of attempts
     * @return mixed
     *
     * @throws \Exception|\Throwable
     */
    public function transaction(Closure $callback, $attempts = 1)
    {
        return $this->transactionHandler()->transaction($this->coupler, $callback, $attempts);
    }

    /**
     * get TransactionHandler
     *
     * @return TransactionHandler
     */
    public function transactionHandler()
    {
        return $this->coupler->getTransaction();
    }
    /**
     * Start a new database transaction.
     * DatabaseHandler 를 통해서 transaction 관리.
     *
     * @return void
     */
    public function beginTransaction()
    {
        $this->transactionHandler()->beginTransaction($this->coupler);
    }

    /**
     * Commit the active database transaction.
     * DatabaseHandler 를 통해서 commit.
     *
     * @return void
     */
    public function commit()
    {
        $this->transactionHandler()->commit($this->coupler);
    }

    /**
     * Rollback the active database transaction.
     *
     * @return void
     */
    public function rollBack()
    {
        $this->transactionHandler()->rollBack($this->coupler);
    }

    /**
     * Get the number of active transactions.
     *
     * @return int
     */
    public function transactionLevel()
    {
        return $this->transactionHandler()->transactionLevel();
    }

    /**
     * Execute the given callback in "dry run" mode.
     *
     * @param Closure $callback closure
     * @return array
     */
    public function pretend(Closure $callback)
    {
        return $this->getConnection()->pretend($callback);
    }

    /**
     * return database table schema
     *
     * @param string $table table name
     * @return array
     */
    public function getSchema($table)
    {
        $cache = static::getCache();

        if ($cache->has($table) === false) {
            $this->setSchemaCache($table);
        }

        $schema = $cache->get($table);

        return $schema;
    }

    /**
     * set database table schema
     *
     * @param string $table table name
     * @param bool   $force force
     * @return bool
     */
    public function setSchemaCache($table, $force = false)
    {
        $cache = static::getCache();

        if ($force === true) {
            $cache->forget($table);
        }

        $schema = $this->getConnection('master')->getSchemaBuilder()->getColumnListing($table);
        if (count($schema) === 0) {
            return false;
        }

        $cache->put($table, $schema, $this->minutes);
        return true;
    }

    /**
     * Set the cache store.
     *
     * @param CacheContract $cache cache instance
     * @return void
     */
    public static function setCache(CacheContract $cache)
    {
        static::$cache = $cache;
    }

    /**
     * Get the cache store.
     *
     * @return CacheContract|null
     */
    public static function getCache()
    {
        return static::$cache;
    }

    /**
     * Set the number of minutes to store cache items.
     *
     * @param int $minutes number of minutes
     * @return void
     */
    public function setCacheExpire($minutes)
    {
        $this->minutes = $minutes;
    }

    /**
     * 인터페이스에 정의되지 않은 기능을 수행 하기 위함.
     * Illuminate\Database\Connection 의 method 실행.
     *
     * @param string $method     method name
     * @param array  $parameters parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array(array($this->getConnection('master'), $method), $parameters);
    }
}

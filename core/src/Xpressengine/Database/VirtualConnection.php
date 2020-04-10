<?php
/**
 * VirtualConnection
 *
 * PHP version 7
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database;

use Illuminate\Contracts\Cache\Repository as CacheContract;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\DetectsDeadlocks;
use Illuminate\Database\DetectsLostConnections;
use Closure;

/**
 * VirtualConnection
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class VirtualConnection implements VirtualConnectionInterface
{
    use DetectsDeadlocks,
        DetectsLostConnections;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var ProxyManager
     */
    protected $proxy;

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
     * The database table schemas
     *
     * @var array
     */
    private static $schemas = [];

    /**
     * Create instance
     *
     * @param ConnectionInterface $connection connection instance
     * @param ProxyManager        $proxy      proxy manager instance
     */
    public function __construct(ConnectionInterface $connection, ProxyManager $proxy)
    {
        $this->connection = $connection;
        $this->proxy = $proxy;
    }

    /**
     * get ProxyManager.
     * DynamicQuery 에서 VirtualConnection 를 주입 받아 사용.
     *
     * @return ProxyManager
     */
    public function getProxyManager()
    {
        return $this->proxy;
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
        return new DynamicQuery($this, $this->connection->getQueryGrammar(), $this->connection->getPostProcessor());
    }

    /**
     * Get a new raw query expression.
     *
     * @param mixed $value value
     * @return \Illuminate\Database\Query\Expression
     */
    public function raw($value)
    {
        return $this->connection->raw($value);
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
        return $this->connection->selectOne($query, $bindings);
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
        return $this->connection->select($query, $bindings);
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
        return $this->connection->insert($query, $bindings);
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
        return $this->connection->update($query, $bindings);
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
        return $this->connection->delete($query, $bindings);
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
        return $this->connection->statement($query, $bindings);
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
        return $this->connection->affectingStatement($query, $bindings);
    }

    /**
     * Run a raw, unprepared query against the PDO connection.
     *
     * @param string $query query
     * @return bool
     */
    public function unprepared($query)
    {
        return $this->connection->unprepared($query);
    }

    /**
     * Prepare the query bindings for execution.
     *
     * @param array $bindings bindings
     * @return array
     */
    public function prepareBindings(array $bindings)
    {
        return $this->connection->prepareBindings($bindings);
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
        return $this->connection->transaction($callback, $attempts);
    }

    /**
     * Start a new database transaction.
     * DatabaseHandler 를 통해서 transaction 관리.
     *
     * @return void
     */
    public function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    /**
     * Commit the active database transaction.
     * DatabaseHandler 를 통해서 commit.
     *
     * @return void
     */
    public function commit()
    {
        $this->connection->commit();
    }

    /**
     * Rollback the active database transaction.
     *
     * @return void
     */
    public function rollBack()
    {
        $this->connection->rollBack();
    }

    /**
     * Get the number of active transactions.
     *
     * @return int
     */
    public function transactionLevel()
    {
        return $this->connection->transactionLevel();
    }

    /**
     * Execute the given callback in "dry run" mode.
     *
     * @param Closure $callback closure
     * @return array
     */
    public function pretend(Closure $callback)
    {
        return $this->connection->pretend($callback);
    }

    /**
     * return database table schema
     *
     * @param string $table table name
     * @return array
     */
    public function getSchema($table)
    {
        if (!isset(static::$schemas[$table])) {
            $cache = static::getCache();

            if ($cache->has($table) === false) {
                $this->setSchemaCache($table);
            }

            static::$schemas[$table] = $cache->get($table);
        }

        return static::$schemas[$table];
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

        $schema = $this->connection->getSchemaBuilder()->getColumnListing($table);
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
        return call_user_func_array([$this->connection, $method], $parameters);
    }
}

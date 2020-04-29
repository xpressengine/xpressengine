<?php
/**
 * ProxyManager
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

use Illuminate\Database\Query\Builder;
use Xpressengine\Register\Container;

/**
 * ProxyManager
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 * @see         \Xpressengine\DynamicField\DatabaseProxy
 */
class ProxyManager
{

    const REGISTER_KEY = 'DATABASE_PROXY';

    /**
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * @var array
     */
    protected $options;

    /**
     * @var Container
     */
    protected $container;

    /**
     * singleton instances
     *
     * @var array
     */
    private static $instance;

    /**
     * singleton
     *
     * @param Container $container register's container
     */
    private function __construct(Container $container)
    {
        $this->container = $container;
        $this->container->set(self::REGISTER_KEY, []);
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
     * @param Container $container register's container
     * @return object
     */
    public static function instance(Container $container)
    {
        if (!self::$instance) {
            self::$instance = new static($container);
        }

        return self::$instance;
    }

    /**
     * destroy singleton instance
     *
     * @return void
     */
    public static function destruct()
    {
        self::$instance = null;
    }

    /**
     * register proxy
     *
     * @param ProxyInterface $proxy proxy instance
     * @return void
     */
    public function register(ProxyInterface $proxy)
    {
        $this->container->push(self::REGISTER_KEY, $proxy);
    }

    /**
     * get registered proxies
     *
     * @return array
     */
    public function gets()
    {
        return $this->container->get(self::REGISTER_KEY);
    }

    /**
     * get registered proxy
     *
     * @param string $name proxy name
     * @return ProxyInterface
     * @throws Exceptions\NotExistsProxyException
     */
    public function getProxy($name)
    {
        $proxy = $this->container->get(self::REGISTER_KEY, $name);
        if ($proxy == null) {
            throw new Exceptions\NotExistsProxyException;
        }

        return $proxy;
    }

    /**
     * set connection
     * 등록된 proxy 로 connection 을 주입하기 위해 connection 정보를 가짐
     * DynamicQuery 에서 주입 받음
     *
     * @param VirtualConnectionInterface $conn    connection
     * @param array                      $options options
     * @return void
     */
    public function set(VirtualConnectionInterface $conn, array $options)
    {
        $this->conn = $conn;
        $this->options = $options;
    }

    /**
     * insert
     *
     * @param array $args parameters
     * @return void
     */
    public function insert(array $args)
    {
        /** @var ProxyInterface $proxy */
        foreach ($this->gets() as $proxy) {
            $proxy->set($this->conn, $this->options);
            $proxy->insert($args);
        }
    }

    /**
     * update
     *
     * @param array $args   parameters
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres = null)
    {
        /** @var ProxyInterface $proxy */
        foreach ($this->gets() as $proxy) {
            $proxy->set($this->conn, $this->options);
            $proxy->update($args, $wheres);
        }
    }

    /**
     * delete
     *
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function delete(array $wheres)
    {
        /** @var ProxyInterface $proxy */
        foreach ($this->gets() as $proxy) {
            $proxy->set($this->conn, $this->options);
            $proxy->delete($wheres);
        }
    }

    /**
     * 등록된 모든 proxy 의 get() interface 처리
     *
     * @param Builder $query query builder
     * @return Builder
     */
    public function get(Builder $query)
    {
        /** @var ProxyInterface $proxy */
        foreach ($this->gets() as $proxy) {
            $proxy->set($this->conn, $this->options);
            $query = $proxy->get($query);
        }
        return $query;
    }

    /**
     * 등록된 모든 proxy의 first()를 처리함.
     *
     * @param Builder $query query builder
     * @return Builder
     */
    public function first(Builder $query)
    {
        /** @var ProxyInterface $proxy */
        foreach ($this->gets() as $proxy) {
            $proxy->set($this->conn, $this->options);
            $query = $proxy->first($query);
        }
        return $query;
    }

    /**
     * 등록된 모든 proxy의 wheres()를 처리함.
     *
     * @param Builder $query  query builder
     * @param array   $wheres parameters for where
     * @return Builder
     */
    public function wheres(Builder $query, array $wheres)
    {
        /** @var ProxyInterface $proxy */
        foreach ($this->gets() as $proxy) {
            $proxy->set($this->conn, $this->options);
            $query = $proxy->wheres($query, $wheres);
        }
        return $query;
    }

    /**
     * 등록된 모든 proxy의 orders()를 처리함.
     *
     * @param Builder $query  query builder
     * @param array   $orders parameters for order
     * @return Builder
     */
    public function orders(Builder $query, array $orders)
    {
        /** @var ProxyInterface $proxy */
        foreach ($this->gets() as $proxy) {
            $proxy->set($this->conn, $this->options);
            $query = $proxy->orders($query, $orders);
        }
        return $query;
    }
}

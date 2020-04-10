<?php
/**
 * DatabaseHandler
 *
 * PHP version 7
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 * @mainpage
 */

namespace Xpressengine\Database;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\DatabaseManager;

/**
 * DatabaseHandler
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DatabaseHandler implements ConnectionResolverInterface
{
    /**
     * @var DatabaseManager
     */
    protected $manager;

    /**
     * @var ProxyManager
     */
    protected $proxy;

    /**
     * create instance
     *
     * @param DatabaseManager $manager database manager instance
     * @param ProxyManager    $proxy   proxy manager instance
     */
    public function __construct(DatabaseManager $manager, ProxyManager $proxy)
    {
        $this->manager = $manager;
        $this->proxy = $proxy;
    }

    /**
     * Get a database connection instance.
     *
     * @param null|string $name connection name
     * @return VirtualConnectionInterface
     */
    public function connection($name = null)
    {
        return $this->wrap($this->manager->connection($name));
    }

    /**
     * Wrap connection instance
     *
     * @param \Illuminate\Database\Connection $connection connection instance
     * @return VirtualConnection
     */
    protected function wrap($connection)
    {
        return new VirtualConnection($connection, $this->proxy);
    }

    /**
     * Disconnect from the given database and remove from local cache.
     *
     * @param string $name connection name
     * @return void
     */
    public function purge($name = null)
    {
        $this->manager->purge($name);
    }

    /**
     * Disconnect from the given database.
     *
     * @param string $name connection name
     * @return void
     */
    public function disconnect($name = null)
    {
        $this->manager->disconnect($name);
    }

    /**
     * Reconnect to the given database.
     *
     * @param string $name connection name
     * @return VirtualConnection
     */
    public function reconnect($name = null)
    {
        return $this->wrap($this->manager->reconnect($name));
    }

    /**
     * Illuminate\Database\ConnectionResolverInterface
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        return $this->manager->getDefaultConnection();
    }

    /**
     * Illuminate\Database\ConnectionResolverInterface
     *
     * @param string $connectionName connection 이름
     * @return void
     */
    public function setDefaultConnection($connectionName)
    {
        $this->manager->setDefaultConnection($connectionName);
    }

    /**
     * Get all of the support drivers.
     *
     * @return array
     */
    public function supportedDrivers()
    {
        return $this->manager->supportedDrivers();
    }

    /**
     * Get all of the drivers that are actually available.
     *
     * @return array
     */
    public function availableDrivers()
    {
        return $this->manager->availableDrivers();
    }

    /**
     * Register an extension connection resolver.
     *
     * @param string   $name     connection name
     * @param callable $resolver connection resolver
     * @return void
     */
    public function extend($name, callable $resolver)
    {
        $this->manager->extend($name, $resolver);
    }

    /**
     * Return all of the created connections.
     *
     * @return array
     */
    public function getConnections()
    {
        return $this->manager->getConnections();
    }

    /**
     * \Illuminate\Database\DatabaseManager 와 동일한 기능을 제공.
     * \Xpressengine\Database\VirtualConnection 의 method 실행.
     *
     * @param string $method     method name
     * @param array  $parameters parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->connection(), $method], $parameters);
    }
}

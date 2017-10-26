<?php
/**
 * DatabaseHandler
 *
 * PHP version 5
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @mainpage
 */

namespace Xpressengine\Database;

use Illuminate\Database\ConnectionResolverInterface;

/**
 * DatabaseHandler
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DatabaseHandler implements ConnectionResolverInterface
{
    const DEFAULT_CONNECTOR_NAME = 'default';

    /**
     * @var DatabaseCoupler
     */
    protected $coupler;

    /**
     * ## config/xe.php database 설정
     * ```php
     *      'database' => [
     *          'connectorName' => [
     *              'master' => ['connectionName', 'connectionName', ...],
     *              'slave' => ['connectionName', 'connectionName', ...],
     *          ],
     *          ...
     *      ]
     * ```
     *
     * @var array
     */
    protected $config;

    /**
     * create instance
     *
     * @param DatabaseCoupler $coupler database coupler
     * @param array           $config  config/xe.php database 설정
     */
    public function __construct(DatabaseCoupler $coupler, array $config)
    {
        $this->coupler = $coupler;
        $this->config = $config;
    }

    /**
     * get connector
     * 실제 connection 을 만들지 않고 connector 에서 config 에 따라
     * master, slave 가 어떤 connection 이름을 사용할지 결정 후 connector 를 반환.
     *
     * @param null|string $name config/xe.php database connector name
     * @return VirtualConnectionInterface
     */
    public function connection($name = null)
    {
        if ($name === null) {
            $name = self::DEFAULT_CONNECTOR_NAME;
        }

        return $this->makeConnector($name);
    }

    /**
     * get config
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * get connector from DatabaseCoupler
     *
     * @param string $name config/xe.php database connector name
     * @return VirtualConnectionInterface
     */
    private function makeConnector($name)
    {
        if (($connector = $this->coupler->getConnector($name)) === null) {
            $connector = $this->coupler->addConnector(
                $name,
                new VirtualConnection($this->coupler, $name, $this->config($name))
            );
        }

        return $connector;
    }

    /**
     * get config
     *
     * @param string $connectorName config/xe.php database connector name
     * @return array
     */
    private function config($connectorName)
    {
        return $this->config[$connectorName];
    }

    /**
     * Illuminate\Database\ConnectionResolverInterface
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        return $this->coupler->databaseManager()->getDefaultConnection();
    }

    /**
     * Illuminate\Database\ConnectionResolverInterface
     *
     * @param string $connectionName connection 이름
     * @return void
     */
    public function setDefaultConnection($connectionName)
    {
        $this->coupler->databaseManager()->setDefaultConnection($connectionName);
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
        return call_user_func_array(array($this->connection(), $method), $parameters);
    }
}

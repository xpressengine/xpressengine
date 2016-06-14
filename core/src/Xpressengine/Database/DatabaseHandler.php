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
 * * Illuminate\Database 를 이용해 데이터 연결
 * * 다중 database 연결/Transaction 지원
 * * 각 package, plugin 에서 database connection 을 선택적으로 이용 할 수 있도록 지원
 * * xe.php 의 database config 설정
 *      - laravel database config 를 이용해서 Database 연결
 * * Illuminate\Database 의 인터페이스 지원
 *      - 다중 connection, proxy 처리를 위해 추가 인터페이스 지원
 *
 * ## app binding
 * * xe.db 로 바인딩 되어 있음
 * * XeDB facade 제공
 *
 * ## interception
 * * XeDB
 *
 * ## 사용법
 *
 * ### Database connection
 * * 기본 설정으로 되어 있는 database connect
 * * database.php 의 default 설정으로 연결
 *
 * ```php
 * // VirtualConnectionInterface
 * $connector = XeDB::connection();
 * ```
 * * xe.php 의 database config 'configName' 설정으로 되어 있는 database connect
 *
 * ```php
 * $connector = XeDB::connection('configName');
 * ```
 *
 * ### Transaction
 * * VirtualConnection 통해 TransactionHandler 에서 처리
 * * 모든 Connection 에 transaction 처리됨
 *
 * ```php
 * XeDB::beginTransaction();
 * XeDB::commit();
 * XeDB::rollBack();
 * ```
 *
 * ### Query
 * * Database 에 query 하기 위해서 VirtualConnectionInterface 의 table(), dynamic() 메소드 사용
 * * table(), dynamic() 은 DynamicQuery 반환
 * * DynamicQuery 는 Illuminate\Database\Query\Builder 사용
 * * dynamic() 은 ProxyManager 를 사용하도록 함 (DynamicField 의 DatabaseProxy 참고)
 *
 * ```php
 * $connector = app('xe.db');
 * $query = XeDB::table('user');
 * $result = XeDB::table('user')->first();
 *
 * $proxyConfig = [... config for proxy ...];
 * $query = XeDB::dynamic('tableName', $proxyConfig);
 * ```
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

<?php
/**
 * VirtualConnectionInterface
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

use Illuminate\Database\ConnectionInterface;

/**
 * VirtualConnectionInterface
 *
 * ConnectionInterface 를 따르며 DynamicField 처리를 위해 dynamic 메소드 추가
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface VirtualConnectionInterface extends ConnectionInterface
{
    /**
     * Begin a fluent query against a database table.
     *
     * @param string $table   table name
     * @param array  $options use by proxy fire id
     * @param bool   $proxy   use proxy
     * @return DynamicQuery
     */
    public function dynamic($table, array $options = [], $proxy = true);

    /**
     * get default connection
     *
     * @return \Illuminate\Database\Connection
     */
    public function getDefaultConnection();

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\Builder
     */
    public function getSchemaBuilder();

    /**
     * return database table schema
     *
     * @param string $table table name
     * @return array
     */
    public function getSchema($table);

    /**
     * set database table schema
     *
     * @param string $table table name
     * @param bool   $force force
     * @return bool
     */
    public function setSchemaCache($table, $force = false);

    /**
     * Get table prefix name.
     *
     * @return string
     */
    public function getTablePrefix();

    /**
     * get connection by $queryType.
     * 'select' 쿼리일 경우 $slaveConnection 을 넘겨주고 그렇지 않을 경우 $masterConnection 을 반환.
     * database 를 쿼리 실행 시 연결.
     *
     * @param string $type query type
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection($type);

    /**
     * get ProxyManager.
     * DynamicQuery 에서 VirtualConnection 를 주입 받아 사용.
     *
     * @return ProxyManager
     */
    public function getProxyManager();
}

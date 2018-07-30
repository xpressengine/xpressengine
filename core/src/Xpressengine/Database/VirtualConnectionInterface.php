<?php
/**
 * VirtualConnectionInterface
 *
 * PHP version 7
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
     * get ProxyManager.
     * DynamicQuery 에서 VirtualConnection 를 주입 받아 사용.
     *
     * @return ProxyManager
     */
    public function getProxyManager();
}

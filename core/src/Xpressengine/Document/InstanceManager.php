<?php
/**
 * InstanceManager
 *
 * PHP version 7
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 * @mainpage
 */

namespace Xpressengine\Document;

use Xpressengine\Database\VirtualConnectionInterface as VirtualConnection;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Document\Exceptions\DivisionTableAlreadyExistsException;
use Xpressengine\Document\Models\Document;
use Xpressengine\Migrations\DocumentMigration;

/**
 * InstanceManager
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class InstanceManager
{

    /**
     * @var VirtualConnection
     */
    protected $connection;


    /**
     * @var ConfigHandler
     */
    protected $configHandler;


    /**
     * create instance
     *
     * @param VirtualConnection $connection    database connection
     * @param ConfigHandler     $configHandler config handler
     */
    public function __construct(VirtualConnection $connection, ConfigHandler $configHandler)
    {
        $this->connection = $connection;
        $this->configHandler = $configHandler;
    }

    /**
     * document instance 생성
     * ex) 게시판 생성
     * document instance 를 생성하면 instance id 로 config 를 생성하고
     * 설정에 따라 division table 을 생성한다.
     *
     * @param ConfigEntity $config config
     * @return void
     */
    public function add(ConfigEntity $config)
    {
        $this->connection->beginTransaction();

        $this->configHandler->add($config);
        if ($config->get('division') === true) {
            $this->createDivisionTable($config);
        }

        $this->connection->commit();
    }

    /**
     * create division table
     *
     * @param ConfigEntity $config document's instance config
     * @return void
     */
    protected function createDivisionTable(ConfigEntity $config)
    {
        $table = $this->getDivisionTableName($config);
        $schema = $this->connection->getSchemaBuilder();
        if ($schema->hasTable($table)) {
            throw new DivisionTableAlreadyExistsException;
        }

        $migration = new DocumentMigration();
        $migration->createDivision($schema, $table);
    }

    /**
     * get division table name
     *
     * @param ConfigEntity $config document config entity
     * @return string
     */
    public function getDivisionTableName(ConfigEntity $config)
    {
        if ($config->get('division') === false) {
            return Document::TABLE_NAME;
        }

        $instanceId = $config->get('instanceId');
        if ($instanceId === null || $instanceId === '') {
            return Document::TABLE_NAME;
        }

        return sprintf('%s_%s', Document::TABLE_NAME, $instanceId);
    }

    /**
     * update instance config
     *
     * @param ConfigEntity $config config
     * @return void
     */
    public function put(ConfigEntity $config)
    {
        $this->configHandler->put($config);
    }

    /**
     * drop instance
     *
     * @param ConfigEntity $config 현재 설정 되어 있는 config
     * @return void
     */
    public function remove(ConfigEntity $config)
    {
        $this->connection->beginTransaction();

        $this->configHandler->remove($config);

        $this->dropDivisionTable($config);

        $this->connection->commit();
    }

    /**
     * drop document instance
     *
     * @param ConfigEntity $config 현제 설정 되어 있는 config
     * @return void
     */
    protected function dropDivisionTable(ConfigEntity $config)
    {
        if ($config->get('division') === true) {
            $this->connection->getSchemaBuilder()->drop($this->getDivisionTableName($config));
        }
    }
}

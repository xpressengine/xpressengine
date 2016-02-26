<?php
/**
 * InstanceManager
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @mainpage
 * hiha
 */
namespace Xpressengine\Document;

use Illuminate\Database\Schema\Blueprint;
use Xpressengine\Database\VirtualConnectionInterface as VirtualConnection;
use Illuminate\Contracts\Hashing\Hasher;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Document\Models\Document;
use Xpressengine\Migrations\DocumentMigration;

/**
 * InstanceManager
 * Document instance 관리
 * Instance 생성 시 등록 한 설정에 따라 테이블 분리(division), 변경 이력 관리(revision) 지원
 *
 * ## 사용법
 *
 * ### Instance 생성
 * ```php
 * $documentHandler = app('xe.document');
 *
 * $configHandler = $documentHandler->getConfigHandler();
 * $configEntity = $configHandler->create('newInstanceId');
 *
 * $instanceManager = $documentHandler->getInstanceManager();
 * $instanceManager->add($configEntity);
 * ```
 *
 * ### Instance 삭제
 * ```php
 * $documentHandler = app('xe.document');
 *
 * $configHandler = $documentHandler->getConfigHandler();
 * $configEntity = $configHandler->create('newInstanceId');
 *
 * $instanceManager = $documentHandler->getInstanceManager();
 * $instanceManager->remove($configEntity);
 * ```
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
     * @param VirtualConnection $connection database connection
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
        $table = sprintf('documents_%s', $config->get('instanceId'));
        $schema = $this->connection->getSchemaBuilder();
        if ($schema->hasTable($table)) {
            throw new Exceptions\DivisionTableAlreadyExistsException;
        }

        $migration = new DocumentMigration();
        $migration->createDivision($schema, $table);
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
     * @param ConfigEntity $config     현재 설정 되어 있는 config
     * @param int          $fetchCount fetch count
     * @return void
     */
    public function remove(ConfigEntity $config, $fetchCount = 10)
    {
        $this->connection->beginTransaction();

        $this->configHandler->remove($config);

        $this->dropDivisionTable($config);

        // division table 은 drop 했으므로 처리하지 않는다.
        $config->set('division', false);
        while ($docs = $this->repo->fetch(['instanceId' => $config->get('instanceId')], null, $config, $fetchCount)) {
            foreach ($docs as $doc) {
                $this->repo->delete(new DocumentEntity($doc), $config);
            }
        }

        $this->connection->commit();
    }

    /**
     * drop document instance
     * * ex) 게시판 삭제
     *
     * @param ConfigEntity $config 현제 설정 되어 있는 config
     * @return void
     */
    protected function dropDivisionTable(ConfigEntity $config)
    {
        if ($config->get('division') === true) {
            $document = new Document;

            $this->connection->delete(sprintf(
                "DROP TABLE `%s%s`",
                $this->connection->getTablePrefix(),
                $document->divisionTable($config)
            ));
        }
    }
}

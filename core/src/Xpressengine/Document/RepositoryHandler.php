<?php
/**
 * RepositoryHandler
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
 */
namespace Xpressengine\Document;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Document\Repositories\RevisionRepository;
use Xpressengine\Document\Repositories\DocumentRepository;
use Xpressengine\Document\Repositories\ReplyHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Xpressengine\Config\ConfigEntity;

/**
 * RepositoryHandler
 * 3종류의 Repository 처리
 * 문서를 위한 DocumentRepository
 * 문서 변경이력 관를 위한 RevisionRepository
 * 인스턴스 별 테이블 분리 처리를 위한 - DivisionRepository
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class RepositoryHandler implements RepositoryInterface
{

    /**
     * Database connection
     *
     * @var VirtualConnectionInterface
     */
    protected $connection;

    /**
     * @var RevisionRepository
     */
    protected $revision;

    /**
     * @var DocumentRepository
     */
    protected $document;

    /**
     * @var ReplyHelper
     */
    protected $reply;
    /**
     * create instance
     *
     * @param VirtualConnectionInterface $connection database connection
     * @param DocumentRepository         $document   document repository instance
     * @param RevisionRepository         $revision   revision repository instance
     * @param ReplyHelper                $reply      reply
     */
    public function __construct(
        VirtualConnectionInterface $connection,
        DocumentRepository $document,
        RevisionRepository $revision,
        ReplyHelper $reply
    ) {
        $this->connection = $connection;
        $this->document = $document;
        $this->revision = $revision;
        $this->reply = $reply;
    }

    /**
     * connector 반환
     *
     * @return VirtualConnectionInterface
     */
    public function connection()
    {
        return $this->connection;
    }

    /**
     * get reply helper
     *
     * @return ReplyHelper
     */
    public function getReplyHelper()
    {
        return $this->reply;
    }

    /**
     * insert document
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config config entity
     * @return DocumentEntity
     */
    public function insert(DocumentEntity $doc, ConfigEntity $config)
    {
        if ($doc->id == null) {
            throw new Exceptions\RequiredValueException;
        }
        if ($doc->writer == null) {
            throw new Exceptions\RequiredValueException;
        }

        // set default values
        if ($doc->userType == null) {
            $doc->userType = $doc::USER_TYPE_USER;
        }
        if ($doc->approved == null) {
            $doc->approved = $doc::APPROVED_APPROVED;
        }
        if ($doc->published == null) {
            $doc->published = $doc::PUBLISHED_PUBLISHED;
        }
        if ($doc->status == null) {
            $doc->status = $doc::STATUS_PUBLIC;
        }
        if ($doc->display == null) {
            $doc->display = $doc::DISPLAY_VISIBLE;
        }
        if ($doc->createdAt == null) {
            $doc->createdAt = date('Y-m-d H:i:s');
        }
        if ($doc->updatedAt == null) {
            $doc->updatedAt = $doc->createdAt;
        }
        if ($doc->published == 'published' && $doc->publishedAt == null) {
            $doc->publishedAt = $doc->createdAt;
        }
        if ($doc->langCode == null) {
            $doc->langCode = 'default';
        }

        $timestamp = time();
        if ($doc->parentId == null || $doc->parentId == '') {
            $doc->head = $timestamp . '-' . $doc->id;
        } else {
            // for 계층 모델
            if ($doc->parentId !== $doc->id) {
                $parent = $this->findById($doc->parentId);
                if ($parent === null) {
                    throw new Exceptions\DocumentNotExistsException;
                }

                $parent = new DocumentEntity($parent);

                $lastChar = $this->document->getLastChildReply(
                    $parent,
                    $this->reply->getReplyCharLen()
                );
                $this->reply->setReply($doc, $parent, $lastChar);
                $doc->head = $parent->head;
            }
        }
        $doc->listOrder = $doc->head . (isset($doc->reply) ? $doc->reply : '');


        $this->connection->beginTransaction();

        $doc = $this->document->insert($doc, $config);

        if ($config->get('revision') === true && $this->revision->isChanged($doc) === true) {
            $this->revision->insert($doc, $config);
        }

        $this->connection->commit();
        return $doc;
    }

    /**
     * update document
     *
     * @param DocumentEntity $doc          document entity
     * @param ConfigEntity   $config       config entity
     * @param ConfigEntity   $originConfig original instance config entity
     * @return DocumentEntity
     */
    public function update(DocumentEntity $doc, ConfigEntity $config, ConfigEntity $originConfig = null)
    {
        $this->connection->beginTransaction();

        $doc = $this->document->update($doc, $config);

        if ($config->get('revision') === true && $this->revision->isChanged($doc) === true) {
            $this->revision->insert($doc, $config);
        }

        if ($config->get('division') === true) {
            $diff = $doc->diff();
            if (isset($diff['instanceId'])) {
                $this->document->insertDivision($doc, $config);
            } else {
                $this->document->updateDivision($doc, $config);
            }
        }

        // 인스턴스 아이디 변경 시 이전 인스턴스 디비전 테이블 데이터 삭제
        if ($originConfig != null && $originConfig->get('division') === true) {
            $diff = $doc->diff();
            if (isset($diff['instanceId'])) {
                $doc->instanceId = $doc->getOriginal()['instanceId'];
                $this->document->deleteDivision($doc, $originConfig);
            }
        }

        $this->connection->commit();
        return $doc;
    }

    /**
     * delete document
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config config entity
     * @return int
     */
    public function delete(DocumentEntity $doc, ConfigEntity $config)
    {
        $this->connection->beginTransaction();

        if ($config->get('revision') === true) {
            $this->revision->delete($doc);
        }

        $count = $this->document->delete($doc, $config);

        $this->connection->commit();
        return $count;
    }

    /**
     * get document
     * 문서를 조회
     *
     * @param string       $id      document id
     * @param ConfigEntity $config  config entity
     * @param array        $columns get columns
     * @return array
     */
    public function find($id, ConfigEntity $config, array $columns = ['*'])
    {
        return $this->document->find($id, $config, $columns);
    }

    /**
     * instanceId 없이 조회
     * dynamic field 정보 제외
     *
     * @param string $id      document id
     * @param array  $columns get columns
     * @return array|null
     */
    public function findById($id, array $columns = ['*'])
    {
        return $this->document->findById($id, $columns);
    }

    /**
     * 여러개 id로 조회
     * dynamic field 정보 제외
     *
     * @param array $ids     document ids
     * @param array $columns get columns
     * @return mixed
     */
    public function fetchByIds(array $ids, array $columns = ['*'])
    {
        return $this->document->fetchByIds($ids, $columns);
    }

    /**
     * get document list
     * 문서 리스트 조회
     *
     * @param array        $wheres  make where query
     * @param array        $orders  make order query
     * @param ConfigEntity $config  config entity
     * @param int          $limit   limit
     * @param array        $columns get columns
     * @return array
     */
    public function fetch(
        array $wheres = null,
        array $orders = null,
        ConfigEntity $config = null,
        $limit = null,
        array $columns = ['*']
    ) {
        return $this->document->fetch($wheres, $orders, $config, $limit, $columns);
    }

    /**
     * get document list by Paginator
     * 문서 리스트 조회
     *
     * @param array        $wheres  make where query
     * @param array        $orders  make order query
     * @param ConfigEntity $config  config entity
     * @param int          $perPage pre page of list
     * @param array        $columns get columns
     * @return LengthAwarePaginator
     */
    public function paginate(
        array $wheres = null,
        array $orders = null,
        ConfigEntity $config = null,
        $perPage = 20,
        array $columns = ['*']
    ) {
        return $this->document->paginate($wheres, $orders, $config, $perPage, $columns);
    }

    /**
     * get document count
     * 문서 수 조회
     *
     * @param array        $wheres make where query
     * @param ConfigEntity $config config entity
     * @return int
     */
    public function count(array $wheres, ConfigEntity $config = null)
    {
        return $this->document->count($wheres, $config);
    }

    /**
     * get document count
     * 문서 수 조회
     *
     * @param string $instanceId instance id
     * @return int
     */
    public function countByInstanceId($instanceId)
    {
        return $this->document->countByInstanceId($instanceId);
    }

    /**
     * get revision
     * DynamicField 정보 없이 조회
     *
     * @param string $revisionId revision document id
     * @return array
     */
    public function fetchRevision($revisionId)
    {
        return $this->revision->find($revisionId);
    }

    /**
     * get revision list
     * DynamicField 정보를 위해서 config 가 필요하며 instance 별로 정보 조회가 가능하다.
     *
     * @param string       $id     document id
     * @param ConfigEntity $config document config entity
     * @return array
     */
    public function getsRevision($id, ConfigEntity $config)
    {
        return $this->revision->fetchById($id, $config);
    }

    /**
     * 같은 depth 에 가장 마지막 자식노드의 reply 코드 값
     *
     * @param DocumentEntity $doc          document entity
     * @param int            $replyCharLen replay 구분 글자 수
     * @return string
     */
    public function getLastChildReply(DocumentEntity $doc, $replyCharLen)
    {
        return $this->document->getLastChildReply($doc, $replyCharLen);
    }

    /**
     * document 의 덧글 리스트 반환
     *
     * @param DocumentEntity $doc document entity
     * @return array
     */
    public function getReplies(DocumentEntity $doc)
    {
        return $this->document->getReplies($doc);
    }

    /**
     * Division table 에 별도로 데이터를 delete 할 경우
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config document config entity
     * @return void
     */
    public function deleteDivision(DocumentEntity $doc, ConfigEntity $config)
    {
        $this->document->deleteDivision($doc, $config);
    }

    /**
     * Division table 에 별도로 데이터를 insert 할 경우
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config document config entity
     * @return void
     */
    public function insertDivision(DocumentEntity $doc, ConfigEntity $config)
    {
        $this->document->insertDivision($doc, $config);
    }

    /**
     * Revision table 에 별도로 데이터를 insert 할 경우
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config document config entity
     * @return void
     */
    public function insertRevision(DocumentEntity $doc, ConfigEntity $config)
    {
        $this->revision->insert($doc, $config);
    }


    /**
     * create division table
     *
     * @param ConfigEntity $config document's instance config
     * @return void
     */
    public function createDivisionTable(ConfigEntity $config)
    {
        if ($config->get('division') === true) {
            $row = $this->connection->select(
                sprintf('show create table %sdocuments', $this->connection()->getTablePrefix())
            );
            $createTable = $row[0]['Create Table'];

            $tables = $this->connection->select(sprintf(
                "SHOW TABLES like '%sdocuments_%s'",
                $this->connection()->getTablePrefix(),
                $config->get('instanceId')
            ));
            if (empty($tables) === false) {
                throw new Exceptions\DivisionExistsException;
            }

            $this->connection->insert(str_replace(
                sprintf('CREATE TABLE `%sdocuments`', $this->connection()->getTablePrefix()),
                sprintf(
                    'CREATE TABLE `%s%s`',
                    $this->connection()->getTablePrefix(),
                    $this->document->divisionTable($config)
                ),
                $createTable
            ));
        }
    }

    /**
     * drop document instance
     * * ex) 게시판 삭제
     *
     * @param ConfigEntity $config 현제 설정 되어 있는 config
     * @return void
     */
    public function dropDivisionTable(ConfigEntity $config)
    {
        if ($config->get('division') === true) {
            $this->connection->delete(sprintf(
                "DROP TABLE `%s%s`",
                $this->connection()->getTablePrefix(),
                $this->document->divisionTable($config)
            ));
        }
    }
}

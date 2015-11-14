<?php
/**
 * This file is repository division decorator
 *
 * PHP version 5
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Comment\Repositories;

use Closure;
use Illuminate\Database\Schema\Builder as SchemaBuilder;
use Xpressengine\Comment\CommentEntity;
use Xpressengine\Comment\CommentHandler;
use Xpressengine\Comment\Exception;
use Xpressengine\Comment\Exceptions\AlreadyExistsTableException;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Comment\Repository;
use Xpressengine\Database\VirtualConnectionInterface;

/**
 * database repository 를 decorating 하여 division 을 처리 함.
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class DivisionDecorator implements Repository
{
    /**
     * Repository instance
     *
     * @var Repository
     */
    protected $repo;

    /**
     * SchemaBuilder instance
     *
     * @var SchemaBuilder
     */
    protected $schema;

    /**
     * Schema for create division table
     *
     * @var callable
     */
    protected $schemaClosure;

    /**
     * ConfigManager instance
     *
     * @var ConfigManager
     */
    protected $configs;

    /**
     * Prefix of key string
     *
     * @var string
     */
    protected $prefix = CommentHandler::PREFIX;

    /**
     * division repository instances
     *
     * @var array
     */
    protected $divisions = [];

    /**
     * constructor
     *
     * @param Repository    $repo          Repository instance
     * @param SchemaBuilder $schema        SchemaBuilder instance
     * @param Closure       $schemaClosure Schema for create division table
     * @param ConfigManager $configs       ConfigManager instance
     */
    public function __construct(
        Repository $repo,
        SchemaBuilder $schema,
        Closure $schemaClosure,
        ConfigManager $configs
    ) {
        $this->repo = $repo;
        $this->schema = $schema;
        $this->schemaClosure = $schemaClosure;
        $this->configs = $configs;
    }

    /**
     * comment 찾기
     *
     * @param string $id comment identifier
     * @return CommentEntity
     */
    public function find($id)
    {
        return $this->repo->find($id);
    }

    /**
     * comment 찾기
     *
     * @param string $instanceId instance identifier
     * @param string $id         comment identifier
     * @return CommentEntity
     */
    public function findBaseInstanceId($instanceId, $id)
    {
        if ($this->isEnable($instanceId) === true) {
            return $this->getDivision($instanceId)->find($id);
        }

        return $this->repo->findBaseInstanceId($instanceId, $id);
    }

    /**
     * comment 목록 반환
     *
     * @param array $wheres 검색 조건
     * @param int   $take   아이템 갯수, 0 일 경우 전체를 가져옴
     * @param array $orders 정렬 조건
     * @return array CommentEntity list
     */
    public function fetch(array $wheres, $take = 0, array $orders = [])
    {
        return $this->repo->fetch($wheres, $take, $orders);
    }

    /**
     * instance id 를 기반으로 comment 목록을 가져옴
     *
     * @param string $instanceId instance identifier
     * @param array  $wheres     검색 조건
     * @param int    $take       아이템 갯수, 0 일 경우 전체를 가져옴
     * @param array  $orders     정렬 조건
     * @return array CommentEntity list
     */
    public function fetchBaseInstanceId($instanceId, array $wheres, $take = 0, array $orders = [])
    {
        if ($this->isEnable($instanceId) === true) {
            return $this->getDivision($instanceId)->fetch($wheres, $take, $orders);
        }

        return $this->repo->fetchBaseInstanceId($instanceId, $wheres, $take, $orders);
    }

    /**
     * comment 레코드 수를 반환
     *
     * @param array $wheres 검색 조건
     * @return int
     */
    public function count(array $wheres)
    {
        return $this->repo->count($wheres);
    }

    /**
     * instance id 를 기반으로 comment 레코드 수를 반환
     *
     * @param string $instanceId instance identifier
     * @param array  $wheres     검색 조건
     * @return int
     */
    public function countBaseInstanceId($instanceId, array $wheres)
    {
        if ($this->isEnable($instanceId) === true) {
            return $this->getDivision($instanceId)->count($wheres);
        }

        return $this->repo->countBaseInstanceId($instanceId, $wheres);
    }

    /**
     * comment 목록을 가진 paginator 를 반환
     *
     * @param array $wheres 검색 조건
     * @param int   $take   아이템 갯수
     * @param array $orders 정렬 조건
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator CommentEntity paginator
     */
    public function paginate(array $wheres, $take, array $orders = [])
    {
        return $this->repo->paginate($wheres, $take, $orders);
    }

    /**
     * comment id 들을 전달받아 목록을 구성
     *
     * @param array $ids comment id list
     * @return array CommentEntity list
     */
    public function fetchIn(array $ids)
    {
        return $this->repo->fetchIn($ids);
    }

    /**
     * comment 저장
     *
     * @param CommentEntity $comment comment object
     * @return CommentEntity
     */
    public function insert(CommentEntity $comment)
    {
        $comment = $this->repo->insert($comment);

        if ($this->isEnable($comment->instanceId) === true) {
            $this->getDivision($comment->instanceId)->insert($comment);
        }

        return $comment;
    }

    /**
     * comment 수정
     *
     * @param CommentEntity $comment comment object
     * @return CommentEntity
     */
    public function update(CommentEntity $comment)
    {
        $comment = $this->repo->update($comment);

        if ($this->isEnable($comment->instanceId) === true) {
            $this->getDivision($comment->instanceId)->update($comment);
        }

        return $comment;
    }

    /**
     * comment 삭제
     *
     * @param CommentEntity $comment comment object
     * @return int
     */
    public function delete(CommentEntity $comment)
    {
        if ($this->isEnable($comment->instanceId) === true) {
            $this->getDivision($comment->instanceId)->delete($comment);
        }

        return $this->repo->delete($comment);
    }

    /**
     * comment 임시 삭제
     *
     * @param CommentEntity $comment comment object
     * @param array         $updates data for update
     * @return int
     */
    public function softDelete(CommentEntity $comment, array $updates = [])
    {
        if ($this->isEnable($comment->instanceId) === true) {
            $this->getDivision($comment->instanceId)->softDelete($comment, $updates);
        }

        return $this->repo->softDelete($comment, $updates);
    }

    /**
     * comment 임시 삭제 취소
     *
     * @param CommentEntity $comment comment object
     * @param array         $updates data for update
     * @return CommentEntity
     */
    public function unDelete(CommentEntity $comment, array $updates = [])
    {
        if ($this->isEnable($comment->instanceId) === true) {
            $this->getDivision($comment->instanceId)->unDelete($comment, $updates);
        }

        return $this->repo->unDelete($comment, $updates);
    }

    /**
     * record 내용 삭제 (record 는 남음)
     *
     * @param CommentEntity $comment comment object
     * @return int
     */
    public function clearDelete(CommentEntity $comment)
    {
        if ($this->isEnable($comment->instanceId) === true) {
            $this->getDivision($comment->instanceId)->clearDelete($comment);
        }

        return $this->repo->clearDelete($comment);
    }

    /**
     * comment 이동
     *
     * @param CommentEntity $comment    comment object
     * @param string        $instanceId 이동할 instance identifier
     * @return CommentEntity
     * @throws Exception
     */
    public function moveTo(CommentEntity $comment, $instanceId)
    {
        if ($comment->instanceId == $instanceId) {
            // exception throwing ?
            return $comment;
        }

        $this->getConnection()->beginTransaction();

        try {
            if ($this->isEnable($comment->instanceId) === true) {
                $this->getDivision($comment->instanceId)->delete($comment);
            }

            // 여기서 다시 select 해오지 않아도 될까?
            $comment->instanceId = $instanceId;
            $comment = $this->repo->update($comment);

            if ($this->isEnable($comment->instanceId) === true) {
                $this->getDivision($comment->instanceId)->insert($comment);
            }
        } catch (\Exception $e) {
            $this->getConnection()->rollBack();

            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        $this->getConnection()->commit();

        return $comment;
    }

    /**
     * 같은 depth 에 가장 마지막 자식노드의 reply 코드 값
     *
     * @param CommentEntity $comment comment object
     * @return string
     */
    public function getLastChildReply(CommentEntity $comment)
    {
        if ($this->isEnable($comment->instanceId) === true) {
            return $this->getDivision($comment->instanceId)->getLastChildReply($comment);
        }

        return $this->repo->getLastChildReply($comment);
    }

    /**
     * 구분되어질 instance 정보를 생성, division 테이블 생성
     *
     * @param string $instanceId instance identifier
     * @return void
     * @throws AlreadyExistsTableException
     */
    public function createInstance($instanceId)
    {
        if ($this->isEnable($instanceId) === true) {
            if ($this->schema->hasTable($this->getTable($instanceId)) === true) {
                throw new AlreadyExistsTableException(['table' => $this->getTable($instanceId)]);
            }

            $this->createTable($instanceId);
        }
    }

    /**
     * instance 내 모든 데이터 삭제
     *
     * @param string $instanceId instance identifier
     * @return void
     */
    public function dropInstance($instanceId)
    {
        if ($this->isEnable($instanceId) === true) {
            if ($this->schema->hasTable($this->getTable($instanceId)) === true) {
                $this->schema->drop($this->getTable($instanceId));
            }
        }

        $this->repo->dropInstance($instanceId);
    }

    /**
     * division repository instance 를 반환
     *
     * @param string $instanceId instance identifier
     * @return DivisionRepository
     */
    protected function getDivision($instanceId)
    {
        if (!isset($this->divisions[$instanceId])) {
            $this->divisions[$instanceId] = $this->createRepository(
                $this->getConnection(),
                $this->getTable($instanceId)
            );
        }

        return $this->divisions[$instanceId];
    }

    /**
     * division 테이블을 생성
     *
     * @param string $instanceId instance identifier
     * @return void
     */
    protected function createTable($instanceId)
    {
        $this->schema->create($this->getTable($instanceId), $this->schemaClosure);
    }

    /**
     * 테이블 이름을 반환
     *
     * @param string $instanceId instance identifier
     * @return string table name
     */
    protected function getTable($instanceId)
    {
        return $this->prefix . '_' . $instanceId;
    }

    /**
     * division 사용 설정이 되었는지 판별
     *
     * @param string $instanceId instance identifier
     * @return bool
     */
    protected function isEnable($instanceId)
    {
        $config = $this->getConfig($instanceId);

        return $config->get('division');
    }

    /**
     * instance 별 설정 정보를 반환
     *
     * @param string $instanceId instance identifier
     * @return \Xpressengine\Config\ConfigEntity
     */
    protected function getConfig($instanceId)
    {
        return $this->configs->get($this->prefix . '.' . $instanceId);
    }

    /**
     * Database connection
     *
     * @return VirtualConnectionInterface
     */
    public function getConnection()
    {
        return $this->repo->getConnection();
    }

    /**
     * division repository 생성
     *
     * @param VirtualConnectionInterface $conn  connection instance
     * @param string                     $table division table name
     * @return DivisionRepository
     */
    protected function createRepository($conn, $table)
    {
        return new DivisionRepository($conn, $table);
    }
}

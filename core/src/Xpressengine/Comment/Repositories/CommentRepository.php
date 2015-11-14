<?php
/**
 * This file is comment database repository
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

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Comment\Repository;
use Xpressengine\Comment\CommentEntity;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Database\BuildWhereTrait;

/**
 * 실제 db에 comment 정보를 입력, 반환 하는 역할을 수행
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CommentRepository implements Repository
{
    use BuildWhereTrait;

    /**
     * Connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * Keygen instance
     *
     * @var Keygen
     */
    protected $keygen;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * constructor
     *
     * @param VirtualConnectionInterface $conn   Connection instance
     * @param Keygen                     $keygen Keygen instance
     */
    public function __construct(VirtualConnectionInterface $conn, Keygen $keygen)
    {
        $this->conn = $conn;
        $this->keygen = $keygen;
    }

    /**
     * comment 찾기
     *
     * @param string $id         comment identifier
     * @param string $instanceId instance identifier
     * @return CommentEntity
     */
    public function find($id, $instanceId = null)
    {
        $dfId = $instanceId !== null ? ['id' => $instanceId] : [];
        $row = $this->conn->dynamic($this->table, $dfId)->where('id', $id)->first();

        if ($row !== null) {
            return $this->createEntity((array)$row);
        }

        return null;
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
        return $this->find($id, $instanceId);
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
        $dfInfo = isset($wheres['instanceId']) ? ['id' => $wheres['instanceId']] : [];
        $query = $this->buildWhere($this->conn->dynamic($this->table, $dfInfo), $wheres);

        if ($take > 0) {
            $query->limit($take);
        }

        foreach ($orders as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $rows = $query->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createEntity((array)$row);
        }

        return $items;
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
        return $this->fetch(array_merge($wheres, ['instanceId' => $instanceId]), $take, $orders);
    }

    /**
     * comment 레코드 수를 반환
     *
     * @param array $wheres 검색 조건
     * @return int
     */
    public function count(array $wheres)
    {
        $dfInfo = isset($wheres['instanceId']) ? ['id' => $wheres['instanceId']] : [];
        $query = $this->buildWhere($this->conn->dynamic($this->table, $dfInfo), $wheres);

        return $query->count();
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
        return $this->count(array_merge($wheres, ['instanceId' => $instanceId]));
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
        $query = $this->buildWhere($this->conn->table($this->table), $wheres);

        foreach ($orders as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        $paginator = $query->paginate($take);

        foreach ($paginator as $key => $value) {
            $paginator[$key] = $this->createEntity((array)$value);
        }

        return $paginator;
    }

    /**
     * comment id 들을 전달받아 목록을 구성
     *
     * @param array $ids comment id list
     * @return array CommentEntity list
     */
    public function fetchIn(array $ids)
    {
        $rows = $this->conn->table($this->table)->whereIn('id', $ids)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createEntity((array)$row);
        }

        return $items;
    }

    /**
     * comment 저장
     *
     * @param CommentEntity $comment comment object
     * @return CommentEntity
     */
    public function insert(CommentEntity $comment)
    {
        $id = $this->keygen->generate();
        $timestamp = time();
        $now = date('Y-m-d H:i:s', $timestamp);
        $attributes = array_merge($comment->getAttributes(), [
            'id' => $id,
            'createdAt' => $now,
            'updatedAt' => $now,
        ]);

        if (isset($attributes['publishedAt']) === false) {
            $attributes['publishedAt'] = $now;
        }

        if (isset($attributes['parentId']) === false) {
            $attributes['head'] = $timestamp . '-' . $id;
        }

        $this->conn->dynamic($this->table, ['id' => $comment->instanceId])->insert($attributes);

        return $this->findBaseInstanceId($comment->instanceId, $id);
    }

    /**
     * comment 수정
     *
     * @param CommentEntity $comment comment object
     * @return CommentEntity
     */
    public function update(CommentEntity $comment)
    {
        $diff = $comment->diff();

        $data = $comment->getAttributes();
        if (count($diff) > 0) {
            $data = array_merge($data, ['updatedAt' => date('Y-m-d H:i:s')]);
            $this->conn->dynamic($this->table, ['id' => $comment->instanceId])
                ->where('id', $comment->id)
                ->update($data);
        }

        return $this->createEntity($data);
    }

    /**
     * comment 삭제
     *
     * @param CommentEntity $comment comment object
     * @return int affecting statement
     */
    public function delete(CommentEntity $comment)
    {
        return $this->conn->dynamic($this->table, ['id' => $comment->instanceId])
            ->where('id', $comment->id)
            ->delete();
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
        $updates = array_merge($updates, ['deletedAt' => date('Y-m-d H:i:s')]);

        return $this->conn->table($this->table)->where('id', $comment->id)->update($updates);
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
        $updates = array_merge($updates, ['deletedAt' => null]);
        $this->conn->table($this->table)->where('id', $comment->id)->update($updates);

        return $this->createEntity(array_merge($comment->getOriginal(), $updates));
    }

    /**
     * record 내용 삭제 (record 는 남음)
     *
     * @param CommentEntity $comment comment object
     * @return int
     */
    public function clearDelete(CommentEntity $comment)
    {
        return $this->conn->table($this->table)->where('id', $comment->id)->update([
            'userId' => null,
            'writer' => '',
            'email' => null,
            'certifyKey' => null,
            'content' => null,
            'display' => 'visible',
            'status' => 'public',
            'removed' => 1
        ]);
    }

    /**
     * comment 이동
     *
     * @param CommentEntity $comment    comment object
     * @param string        $instanceId 이동할 instance identifier
     * @return CommentEntity
     */
    public function moveTo(CommentEntity $comment, $instanceId)
    {

        $update = [
            'instanceId' => $instanceId,
            'updatedAt' => date('Y-m-d H:i:s')
        ];
        $this->conn->table($this->table)
            ->where('id', $comment->id)
            ->update($update);

        return $this->createEntity(array_merge($comment->getOriginal(), $update));
    }

    /**
     * 같은 depth 에 가장 마지막 자식노드의 reply 코드 값
     *
     * @param CommentEntity $comment comment object
     * @return string
     */
    public function getLastChildReply(CommentEntity $comment)
    {
        $reply = $this->conn->table($this->table)
            ->where('head', $comment->head)
            ->where('reply', 'like', $comment->reply . str_repeat('_', CommentEntity::getReplyCharlen()))
            ->max('reply');

        return $reply;
    }

    /**
     * 구분되어질 instance 정보를 생성, division 테이블 생성
     *
     * @param string $instanceId instance identifier
     * @return void
     */
    public function createInstance($instanceId)
    {
        // nothing to do
    }

    /**
     * instance 내 모든 데이터 삭제
     *
     * @param string $instanceId instance identifier
     * @return void
     */
    public function dropInstance($instanceId)
    {
        $this->conn->table($this->table)->where('instanceId', $instanceId)->delete();
    }

    /**
     * Database connection
     *
     * @return VirtualConnectionInterface
     */
    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Entity 객체 생성
     *
     * @param array $attributes entity attributes
     * @return CommentEntity
     */
    protected function createEntity(array $attributes)
    {
        return new CommentEntity($attributes);
    }
}

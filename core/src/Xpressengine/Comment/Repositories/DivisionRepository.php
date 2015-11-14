<?php
/**
 * This file is division repository
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
use Xpressengine\Comment\CommentEntity;
use Xpressengine\Database\BuildWhereTrait;

/**
 * division 되는 instance 에 속한 comment 정보를 저장, 제공 함
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class DivisionRepository
{
    use BuildWhereTrait;

    /**
     * Connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = '';

    /**
     * constructor
     *
     * @param VirtualConnectionInterface $conn  Connection instance
     * @param string                     $table Table name
     */
    public function __construct(VirtualConnectionInterface $conn, $table)
    {
        $this->conn = $conn;
        $this->table = $table;
    }

    /**
     * comment 찾기
     *
     * @param string $id comment identifier
     * @return null|CommentEntity
     */
    public function find($id)
    {
        $row = $this->conn->dynamic($this->table)->where('id', $id)->first();

        if ($row !== null) {
            return $this->createEntity((array)$row);
        }

        return null;
    }

    /**
     * comment 목록 반환
     *
     * @param array $wheres 검색 조건
     * @param int   $take   아이템 갯수
     * @param array $orders 정렬 조건
     * @return array CommentEntity list
     */
    public function fetch(array $wheres, $take, array $orders = [])
    {
        $query = $this->buildWhere($this->conn->dynamic($this->table), $wheres);
        $query->limit($take);

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
     * comment 레코드 수를 반환
     *
     * @param array $wheres 검색 조건
     * @return int
     */
    public function count($wheres)
    {
        $query = $this->buildWhere($this->conn->dynamic($this->table), $wheres);

        return $query->count();
    }

    /**
     * comment 저장
     *
     * @param CommentEntity $comment comment object
     * @return CommentEntity
     */
    public function insert(CommentEntity $comment)
    {
        $this->conn->dynamic($this->table, [], false)->insert($comment->getAttributes());

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
        $this->conn->dynamic($this->table, [], false)->where('id', $comment->id)->update($comment->getAttributes());

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
        return $this->conn->dynamic($this->table, [], false)->where('id', $comment->id)->delete();
    }

    /**
     * comment 임시 삭제
     *
     * @param CommentEntity $comment comment object
     * @param array         $updates data for update
     * @return void
     */
    public function softDelete(CommentEntity $comment, array $updates = [])
    {
        $updates = array_merge($updates, ['deletedAt' => date('Y-m-d H:i:s')]);
        $this->conn->table($this->table)
            ->where('id', $comment->id)
            ->update($updates);
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
    }

    /**
     * record 내용 삭제 (record 는 남음)
     *
     * @param CommentEntity $comment comment object
     * @return int
     */
    public function clearDelete(CommentEntity $comment)
    {
        $this->conn->table($this->table)->where('id', $comment->id)->update([
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
     * table name
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
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

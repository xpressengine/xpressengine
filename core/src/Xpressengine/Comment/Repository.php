<?php
/**
 * This file is repository interface
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
namespace Xpressengine\Comment;

use Illuminate\Database\ConnectionInterface;

/**
 * comment 패키지 저장소의 interface 를 정의 함.
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface Repository
{
    /**
     * comment 찾기
     *
     * @param string $id comment identifier
     * @return CommentEntity
     */
    public function find($id);

    /**
     * comment 찾기
     *
     * @param string $instanceId instance identifier
     * @param string $id         comment identifier
     * @return CommentEntity
     */
    public function findBaseInstanceId($instanceId, $id);

    /**
     * comment 목록 반환
     *
     * @param array $wheres 검색 조건
     * @param int   $take   아이템 갯수, 0 일 경우 전체를 가져옴
     * @param array $orders 정렬 조건
     * @return array CommentEntity list
     */
    public function fetch(array $wheres, $take = 0, array $orders = []);

    /**
     * instance id 를 기반으로 comment 목록을 가져옴
     *
     * @param string $instanceId instance identifier
     * @param array  $wheres     검색 조건
     * @param int    $take       아이템 갯수, 0 일 경우 전체를 가져옴
     * @param array  $orders     정렬 조건
     * @return array CommentEntity list
     */
    public function fetchBaseInstanceId($instanceId, array $wheres, $take = 0, array $orders = []);

    /**
     * comment 레코드 수를 반환
     *
     * @param array $wheres 검색 조건
     * @return int
     */
    public function count(array $wheres);

    /**
     * instance id 를 기반으로 comment 레코드 수를 반환
     *
     * @param string $instanceId instance identifier
     * @param array  $wheres     검색 조건
     * @return int
     */
    public function countBaseInstanceId($instanceId, array $wheres);

    /**
     * comment 목록을 가진 paginator 를 반환
     *
     * @param array $wheres 검색 조건
     * @param int   $take   아이템 갯수
     * @param array $orders 정렬 조건
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator CommentEntity paginator
     */
    public function paginate(array $wheres, $take, array $orders = []);

    /**
     * comment id 들을 전달받아 목록을 구성
     *
     * @param array $ids comment id list
     * @return array CommentEntity list
     */
    public function fetchIn(array $ids);

    /**
     * comment 저장
     *
     * @param CommentEntity $comment comment object
     * @return CommentEntity
     */
    public function insert(CommentEntity $comment);

    /**
     * comment 수정
     *
     * @param CommentEntity $comment comment object
     * @return CommentEntity
     */
    public function update(CommentEntity $comment);

    /**
     * comment 삭제
     *
     * @param CommentEntity $comment comment object
     * @return int affecting statement
     */
    public function delete(CommentEntity $comment);

    /**
     * comment 임시 삭제
     *
     * @param CommentEntity $comment comment object
     * @param array         $updates data for update
     * @return int
     */
    public function softDelete(CommentEntity $comment, array $updates = []);

    /**
     * comment 임시 삭제 취소
     *
     * @param CommentEntity $comment comment object
     * @param array         $updates data for update
     * @return CommentEntity
     */
    public function unDelete(CommentEntity $comment, array $updates = []);

    /**
     * record 내용 삭제 (record 는 남음)
     *
     * @param CommentEntity $comment comment object
     * @return int
     */
    public function clearDelete(CommentEntity $comment);

    /**
     * comment 이동
     *
     * @param CommentEntity $comment    comment object
     * @param string        $instanceId 이동할 instance identifier
     * @return CommentEntity
     */
    public function moveTo(CommentEntity $comment, $instanceId);

    /**
     * 같은 depth 에 가장 마지막 자식노드의 reply 코드 값
     *
     * @param CommentEntity $comment comment object
     * @return string
     */
    public function getLastChildReply(CommentEntity $comment);

    /**
     * 구분되어질 instance 정보를 생성, division 테이블 생성
     *
     * @param string $instanceId instance identifier
     * @return void
     */
    public function createInstance($instanceId);

    /**
     * instance 내 모든 데이터 삭제
     *
     * @param string $instanceId instance identifier
     * @return void
     */
    public function dropInstance($instanceId);

    /**
     * Database connection
     *
     * @return ConnectionInterface
     */
    public function getConnection();
}

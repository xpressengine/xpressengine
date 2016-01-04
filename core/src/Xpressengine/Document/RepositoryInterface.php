<?php
/**
 * RepositoryInterface
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

use Illuminate\Pagination\LengthAwarePaginator;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\VirtualConnectionInterface;

/**
 * RepositoryInterface
 * Document 에 인터페이스를 따르는 객체를 Document Handler 에 주입할 수 있음
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface RepositoryInterface
{
    /**
     * connector 반환
     *
     * @return VirtualConnectionInterface
     */
    public function connection();

    /**
     * insert document
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config config entity
     * @return DocumentEntity
     */
    public function insert(DocumentEntity $doc, ConfigEntity $config);

    /**
     * update document
     *
     * @param DocumentEntity $doc          document entity
     * @param ConfigEntity   $config       config entity
     * @param ConfigEntity   $originConfig original instance config entity
     * @return DocumentEntity
     */
    public function update(DocumentEntity $doc, ConfigEntity $config, ConfigEntity $originConfig = null);

    /**
     * delete document
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config config entity
     * @return int
     */
    public function delete(DocumentEntity $doc, ConfigEntity $config);


    /**
     * get document
     * 하나의 문서를 가져옵니다.
     *
     * @param string       $id      document id
     * @param ConfigEntity $config  config entity
     * @param string       $locale  locale
     * @param array        $columns get columns
     * @return array
     */
    public function find($id, ConfigEntity $config, $locale = null, array $columns = ['*']);

    /**
     * instanceId 없이 조회
     * dynamic field 정보 제외
     *
     * @param string $id      document id
     * @param array  $columns get columns
     * @return mixed
     */
    public function findById($id, array $columns = ['*']);

    /**
     * 여러개 id로 조회
     * dynamic field 정보 제외
     *
     * @param array $ids     document ids
     * @param array $columns get columns
     * @return mixed
     */
    public function fetchByIds(array $ids, array $columns = ['*']);

    /**
     * get document list
     * 여러개의 문서를 가져옵니다.
     * 동작방식은 get()메소드와 동일합니다
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
    );

    /**
     * get document list by Paginator
     * Illuminate\Paginator로 감싸진 document list를 가져옵니다.
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
    );

    /**
     * get document count
     * 문서 수를 가져옵니다.
     *
     * @param array        $wheres make where query
     * @param ConfigEntity $config config entity
     * @return int
     */
    public function count(array $wheres, ConfigEntity $config = null);

    /**
     * get document count
     * 문서 수 반환
     *
     * @param string $instanceId instance id
     * @return int
     */
    public function countByInstanceId($instanceId);

    /**
     * get revision
     * DynamicField 정보를 위해서 config 가 필요하며 instance 별로 정보 조회가 가능하다.
     *
     * @param string $id document id
     * @return array
     */
    public function fetchRevision($id);

    /**
     * get revision list
     * DynamicField 정보를 위해서 config 가 필요하며 instance 별로 정보 조회가 가능하다.
     *
     * @param string       $id     document id
     * @param ConfigEntity $config document config entity
     * @return array
     */
    public function getsRevision($id, ConfigEntity $config);

    /**
     * 같은 depth 에 가장 마지막 자식노드의 reply 코드 값
     *
     * @param DocumentEntity $doc          document entity
     * @param int            $replyCharLen replay 구분 글자 수
     * @return string
     */
    public function getLastChildReply(DocumentEntity $doc, $replyCharLen);

    /**
     * document 의 덧글 리스트 반환
     *
     * @param DocumentEntity $doc document entity
     * @return \Illuminate\Support\Collection
     */
    public function getReplies(DocumentEntity $doc);

    /**
     * Division table 에 별도로 데이터를 delete 할 경우
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config document config entity
     * @return void
     */
    public function deleteDivision(DocumentEntity $doc, ConfigEntity $config);

    /**
     * Revision table 에 별도로 데이터를 insert 할 경우
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config document config entity
     * @return void
     */
    public function insertRevision(DocumentEntity $doc, ConfigEntity $config);

    /**
     * Division table 에 별도로 데이터를 insert 할 경우
     *
     * @param DocumentEntity $doc    document entity
     * @param ConfigEntity   $config document config entity
     * @return void
     */
    public function insertDivision(DocumentEntity $doc, ConfigEntity $config);

    /**
     * create division table
     *
     * @param ConfigEntity $config document's instance config
     * @return void
     * @throws DivisionExistsException
     */
    public function createDivisionTable(ConfigEntity $config);

    /**
     * drop document instance
     * * ex) 게시판 삭제
     *
     * @param ConfigEntity $config 현제 설정 되어 있는 config
     * @return void
     */
    public function dropDivisionTable(ConfigEntity $config);
}

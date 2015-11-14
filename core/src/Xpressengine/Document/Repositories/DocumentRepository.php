<?php
/**
 * DocumentRepository
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Document\Repositories;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\Document\DocumentEntity;
use Xpressengine\Config\ConfigEntity;

/**
 * DocumentRepository
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class DocumentRepository
{

    /**
     * table 이름
     *
     * @var string
     */
    protected $table = 'documents';

    /**
     * Database connection
     *
     * @var VirtualConnectionInterface
     */
    protected $connection;

    /**
     * create instance
     *
     * @param VirtualConnectionInterface $connection database connection
     */
    public function __construct(VirtualConnectionInterface $connection)
    {
        $this->connection = $connection;
    }

    /**
     * get current document's database connection
     *
     * @return VirtualConnectionInterface
     */
    public function connection()
    {
        return $this->connection;
    }

    /**
     * get document table name
     *
     * @return string
     */
    public function table()
    {
        return $this->table;
    }

    /**
     * insert document
     *
     * @param DocumentEntity $doc    insert values
     * @param ConfigEntity   $config document config entity
     * @return DocumentEntity
     */
    public function insert(DocumentEntity $doc, ConfigEntity $config)
    {
        $this->connection->dynamic($this->table, $this->proxyOption($config))->insert($doc->getAttributes());
        $this->insertDivision($doc, $config);

        return $doc;
    }

    /**
     * insert division document
     *
     * @param DocumentEntity $doc    insert values
     * @param ConfigEntity   $config document config entity
     * @return DocumentEntity
     */
    public function insertDivision(DocumentEntity $doc, ConfigEntity $config)
    {
        if ($config->get('division') == true) {
            $this->connection->dynamic($this->divisionTable($config), [], false)->insert($doc->getAttributes());
        }

        return $doc;
    }

    /**
     * update document
     *
     * @param DocumentEntity $doc    insert values
     * @param ConfigEntity   $config document config entity
     * @return DocumentEntity
     */
    public function update(DocumentEntity $doc, ConfigEntity $config)
    {
        $this->connection->dynamic($this->table, $this->proxyOption($config))
            ->where('id', $doc->id)->update($doc->getAttributes());
        $this->updateDivision($doc, $config);

        return $doc;
    }

    /**
     * update division document
     *
     * @param DocumentEntity $doc    insert values
     * @param ConfigEntity   $config document config entity
     * @return DocumentEntity
     */
    public function updateDivision(DocumentEntity $doc, ConfigEntity $config)
    {
        if ($config->get('division') == true) {
            $this->connection->dynamic($this->divisionTable($config), [], false)
                ->where('id', $doc->id)->update($doc->getAttributes());
        }

        return $doc;
    }

    /**
     * delete document by instance id
     *
     * @param string $instanceId instance id
     * @return int 삭제된 문서 수
     */
    public function deleteByInstanceId($instanceId)
    {
        return $this->connection->table($this->table)
            ->where('instanceId', $instanceId)->delete();
    }

    /**
     * delete document
     * 삭제된 레코드 수 반환
     *
     * @param DocumentEntity $doc    insert values
     * @param ConfigEntity   $config document config entity
     * @return int
     */
    public function delete(DocumentEntity $doc, ConfigEntity $config)
    {
        $options = $this->proxyOption($config);

        $this->deleteDivision($doc, $config);

        return $this->connection->dynamic($this->table, $options)
            ->where('id', $doc->id)->delete();
    }

    /**
     * delete division document
     * 삭제된 레코드 수 반환
     *
     * @param DocumentEntity $doc    insert values
     * @param ConfigEntity   $config document config entity
     * @return int
     */
    public function deleteDivision(DocumentEntity $doc, ConfigEntity $config)
    {
        if ($config->get('division') == true) {
            return $this->connection->dynamic($this->divisionTable($config), [], false)
                ->where('id', $doc->id)->delete();
        }
    }

    /**
     * make query
     *
     * @param DynamicQuery $query  query builder
     * @param array        $wheres make where query list
     * @return DynamicQuery
     */
    public function wheres(DynamicQuery $query, array $wheres)
    {
        if (isset($wheres['id'])) {
            $query = $query->where('id', '=', $wheres['id']);
        }

        if (isset($wheres['documentId'])) {
            $query = $query->where('id', '=', $wheres['documentId']);
        }

        if (isset($wheres['ids'])) {
            $query = $query->whereIn('id', $wheres['ids']);
        }

        if (isset($wheres['parentId'])) {
            $query = $query->where('parentId', '=', $wheres['parentId']);
        }

        if (isset($wheres['instanceId'])) {
            $query = $query->where('instanceId', '=', $wheres['instanceId']);
        }

        if (isset($wheres['instanceIds'])) {
            $query = $query->whereIn('instanceId', $wheres['instanceIds']);
        }

        if (isset($wheres['userId']) && $wheres['userId'] != '') {
            $query = $query->where('userId', '=', $wheres['userId']);
        }

        if (isset($wheres['writer']) && $wheres['writer'] != '') {
            $query = $query->where('writer', '=', $wheres['writer']);
        }

        if (isset($wheres['likeUserName'])) {
            $query = $query->where('userName', 'like', $wheres['likeUserName']);
        }

        if (isset($wheres['title_content'])) {
            $query = $query->whereNested(function($query) use ($wheres) {
                $query->where('title', 'like', sprintf('%%%s%%', $wheres['title_content']))
                ->orWhere('content', 'like', sprintf('%%%s%%', $wheres['title_content']));
            });
        }

        if (isset($wheres['title_pureContent'])) {
            $query = $query->whereNested(function($query) use ($wheres) {
                $query->where('title', 'like', sprintf('%%%s%%', $wheres['title_pureContent']))
                    ->orWhere('pureContent', 'like', sprintf('%%%s%%', $wheres['title_pureContent']));
            });
        }

        if (isset($wheres['content'])) {
            $query = $query->where('content', 'like', sprintf('%%%s%%', $wheres['content']));
        }

        if (isset($wheres['title'])) {
            $query = $query->where('title', 'like', sprintf('%%%s%%', $wheres['title']));
        }

        if (isset($wheres['createdAtMore'])) {
            $query = $query->where('createdAt', '>', $wheres['createdAtMore']);
        }

        if (isset($wheres['createdAtLess'])) {
            $query = $query->where('createdAt', '<', $wheres['createdAtLess']);
        }

        // $wheres['created_at_between'] is array
        if (isset($wheres['createdAtBetween'])) {
            $query = $query->whereBetween('createdAt', $wheres['createdAtBetween']);
        }

        if (isset($wheres['status']) && $wheres['status'] != '') {
            $query = $query->where('status', '=', $wheres['status']);
        }

        if (isset($wheres['approved']) && $wheres['approved'] != '') {
            $query = $query->where('approved', '=', $wheres['approved']);
        }

        if (isset($wheres['published']) && $wheres['published'] != '') {
            $query = $query->where('published', '=', $wheres['published']);
        }

        if (isset($wheres['display']) && $wheres['display'] != '') {
            $query = $query->where('display', '=', $wheres['display']);
        }

        $proxyManager = $query->getProxyManager();
        if ($proxyManager !== null) {
            $proxyManager->wheres($query->getQuery(), $wheres);
        }

        return $query;
    }

    /**
     * make query
     *
     * @param DynamicQuery $query  query builder
     * @param array        $orders make order query list
     * @return DynamicQuery
     */
    public function orders(DynamicQuery $query, array $orders)
    {
        // set default
        if (count($orders) == 0) {
            $orders['createdAt'] = 'desc';
        } else {
            foreach ($orders as $key => $order) {
                $query = $query->orderBy($key, $order);
            }
        }

        // 정렬 어떻게 할지.
        return $query;
    }

    /**
     * get a document
     *
     * @param string       $id      document id
     * @param ConfigEntity $config  config entity
     * @param array        $columns get columns list
     * @return array
     */
    public function find($id, ConfigEntity $config, array $columns = ['*'])
    {
        $table = $this->divisionTable($config);
        $options = $this->proxyOption($config);

        return $this->connection->dynamic($table, $options)->where('id', $id)->first($columns);
    }

    /**
     * instanceId 없이 조회
     * dynamicField
     *
     * @param string $id      document id
     * @param array  $columns get columns
     * @return mixed
     */
    public function findById($id, array $columns = ['*'])
    {
        return $this->connection->table($this->table)->where('id', $id)->first($columns);
    }

    /**
     * get document list. search and order
     *
     * @param array $ids     document id
     * @param array $columns get columns
     * @return array
     */
    public function fetchByIds(array $ids, array $columns = ['*'])
    {
        return $this->connection->table($this->table)->whereIn('id', $ids)->get($columns);
    }

    /**
     * get document list. search and order
     *
     * @param array        $wheres  make where query list
     * @param array        $orders  make order query list
     * @param ConfigEntity $config  document config entity
     * @param int          $limit   number of list
     * @param array        $columns get columns list
     * @return array
     */
    public function fetch(
        array $wheres = null,
        array $orders = null,
        ConfigEntity $config = null,
        $limit = null,
        array $columns = ['*']
    ) {
        $table = $this->divisionTable($config);
        if ($config == null) {
            $query = $this->connection->table($table);
        } else {
            $options = $this->proxyOption($config);
            $query = $this->connection->dynamic($table, $options);
        }

        if ($limit !== null) {
            $query = $query->take($limit);
        }

        $wheres = ($wheres !== null) ? $wheres : [];
        $query = $this->wheres($query, $wheres);
        $orders = ($orders !== null) ? $orders : [];
        $query = $this->orders($query, $orders);

        $rows = $query->get($columns);

        return $rows;
    }

    /**
     * get paginator
     *
     * @param array        $wheres  make where query
     * @param array        $orders  make order query
     * @param ConfigEntity $config  config entity
     * @param int          $perPage pre page of list
     * @param array        $columns get columns
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(
        array $wheres = null,
        array $orders = null,
        ConfigEntity $config = null,
        $perPage = 20,
        array $columns = ['*']
    ) {
        $table = $this->divisionTable($config);
        if ($config == null) {
            $query = $this->connection->table($table);
        } else {
            $options = $this->proxyOption($config);
            $query = $this->connection->dynamic($table, $options);
        }

        $wheres = ($wheres !== null) ? $wheres : [];
        $query = $this->wheres($query, $wheres);
        $orders = ($orders !== null) ? $orders : ['created_at' => 'desc'];
        $query = $this->orders($query, $orders);

        $paginator = $query->paginate($perPage, $columns);

        return $paginator;
    }

    /**
     * get list count
     *
     * @param array        $wheres make where query list
     * @param ConfigEntity $config config entity
     * @return int
     */
    public function count(array $wheres, ConfigEntity $config = null)
    {
        $table = $this->divisionTable($config);
        $options = $this->proxyOption($config);

        $query = $this->connection->dynamic($table, $options);
        $query = $this->wheres($query, $wheres);
        $count = $query->count();

        return $count;
    }

    /**
     * get document count
     * 문서 수 반환
     *
     * @param string $instanceId instance id
     * @return int
     */
    public function countByInstanceId($instanceId)
    {
        return $this->connection->table($this->table)->where('instanceId', $instanceId)->count();
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
        $reply = $this->connection->table($this->table)
            ->where('head', $doc->head)
            ->where('reply', 'like', $doc->reply . str_repeat('_', $replyCharLen))
            ->max('reply');

        return $reply;
    }

    /**
     * document 의 덧글 리스트 반환
     *
     * @param DocumentEntity $doc document entity
     * @return array
     */
    public function getReplies(DocumentEntity $doc)
    {
        $query = $this->connection->table($this->table)->where('head', $doc->head);
        if ($doc->reply != null) {
            $query = $query->where('reply', 'like', $doc->reply . '%');
        }
        return $query->get();
    }

    /**
     * get database proxy options
     *
     * @param ConfigEntity $config config entity
     * @return array
     */
    private function proxyOption(ConfigEntity $config = null)
    {
        $options = [];
        if ($config != null) {
            $options['table'] = $this->table;
            $options['id'] = $config->get('instanceId');
        }

        return $options;
    }

    /**
     * division table 이름 반환
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function divisionTable(ConfigEntity $config = null)
    {
        $table = $this->table;
        if ($config != null && $config->get('division') === true) {
            $table = sprintf('%s_division_%s', $this->table, $config->get('instanceId'));
        }

        return $table;
    }
}

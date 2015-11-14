<?php
/**
 * Repository
 *
 * PHP version 5
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Counter;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Database\DynamicQuery;

/**
 * Repository
 *
 * * Counter repository
 * * counter_log table 의 데이터 관리
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Repository
{

    /**
     * @var string
     */
    protected $table = 'counter_log';

    /**
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * create instance
     *
     * @param VirtualConnectionInterface $conn database connection
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * insert counter log
     *
     * @param string $name      counter 이름
     * @param string $option    counter option
     * @param string $targetId  대상 id
     * @param string $userId    아아디
     * @param string $ipaddress 아이피
     * @param int    $point     포인트
     * @return void
     */
    public function insert($name, $option, $targetId, $userId, $ipaddress, $point = 1)
    {
        $this->conn->table($this->table)->insert([
            'counterName' => $name,
            'counterOption' => $option,
            'targetId' => $targetId,
            'userId' => $userId,
            'point' => $point,
            'createdAt' => date('Y-m-d H:i:s'),
            'ipaddress' => $ipaddress,
        ]);
    }

    /**
     * delete counter log
     *
     * @param string $name     counter 이름
     * @param string $option   counter option
     * @param string $targetId 대상 id
     * @param string $userId   아아디
     * @return void
     */
    public function delete($name, $option, $targetId, $userId)
    {
        $this->conn->table($this->table)->where([
            'targetId' => $targetId,
            'userId' => $userId,
            'counterName' => $name,
            'counterOption' => $option,
        ])->delete();
    }

    /**
     * $wheres parameter 로 query 처리
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

        if (isset($wheres['counterName'])) {
            $query = $query->where('counterName', '=', $wheres['counterName']);
        }

        if (isset($wheres['counterOption'])) {
            $query = $query->where('counterOption', '=', $wheres['counterOption']);
        }

        if (isset($wheres['targetId'])) {
            $query = $query->where('targetId', '=', $wheres['targetId']);
        }

        if (isset($wheres['userId'])) {
            $query = $query->where('userId', '=', $wheres['userId']);
        }

        return $query;
    }

    /**
     * $orders parameter로 query를 만든다
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
        }

        if (isset($orders['createdAt'])) {
            $query = $query->orderBy('createdAt', $orders['createdAt']);
        }
        return $query;
    }

    /**
     * get counter log count
     *
     * @param array $wheres make where query list
     * @return int
     */
    public function count(array $wheres)
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        return $query->count();
    }

    /**
     * get counter log count group by option
     *
     * @param array $wheres make where query list
     * @return array
     */
    public function countsByOption(array $wheres)
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        return $query->groupBy('counterOption')->get(['counterOption', $query->raw('count(*) as count')]);
    }

    /**
     * get sum point
     *
     * @param array $wheres make where query list
     * @return int
     */
    public function getPoint(array $wheres)
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        return $query->sum('point');
    }

    /**
     * get sum point
     *
     * @param array $wheres make where query list
     * @return int
     */
    public function getPointByOption(array $wheres)
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        return $query->groupBy('counterOption')->get(['counterOption', $query->raw('sum(point) as point')]);
    }

    /**
     * a counter log information
     *
     * @param array $wheres  make where query list
     * @param array $columns get columns list
     * @return array|null
     */
    public function find(array $wheres, array $columns = ['*'])
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        return $query->first($columns);
    }

    /**
     * get counter log list
     *
     * @param array $wheres  make where query list
     * @param array $orders  make order query list
     * @param int   $limit   number of list
     * @param array $columns get columns list
     * @return array
     */
    public function fetch(array $wheres, array $orders, $limit = null, array $columns = ['*'])
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        $query = $this->orders($query, $orders);

        if ($limit !== null) {
            $query = $query->take($limit);
        }

        return $query->get($columns);
    }

    /**
     * get paginator
     *
     * @param array $wheres  make where query list
     * @param array $orders  make order query list
     * @param int   $perPage count of per page
     * @param array $columns get columns list
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function paginate(array $wheres, array $orders, $perPage, array $columns = ['*'])
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        $query = $this->orders($query, $orders);
        return $query->paginate($perPage, $columns);
    }

    /**
     * userId 리스트 반환
     * 최근 counter log에 insert 된 userId 를 보기 위해
     *
     * @param array $wheres make where query list
     * @param array $orders make order query list
     * @param int   $limit  number of list
     * @return mixed
     */
    public function fetchByUserIds(array $wheres, array $orders, $limit = null)
    {
        $query = $this->conn->table($this->table);
        $query = $this->wheres($query, $wheres);
        $query = $this->orders($query, $orders);

        if ($limit !== null) {
            $query = $query->take($limit);
        }

        return $query->lists('userId');
    }
}

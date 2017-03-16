<?php
/**
 * DynamicQuery
 *
 * PHP version 5
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database;

use Illuminate\Database\Query\Builder;

/**
 * DynamicQuery
 *
 * * Illuminate\Database\Query\Builder 를 extends 하여 기능 추가
 * * insert, update, delete, select 동작할 때 dynamic, proxy 사용여부에 따라 추가 기능 사용
 * * proxy 사용할 때 ProxyManager 에 등록된 Proxy 동작
 * * dynamic 을 사용하지 않으면 Illuminate Builder 직접 사용
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DynamicQuery extends Builder
{
    /**
     * @var VirtualConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    protected $table;

    /**
     * ProxyManager 의 Proxy 에서 사용하기 위한 key
     * A table 에 쿼리후 B, C 테이블에 쿼리하기 위해서 특정 이름을 부여함.
     * A table 의 이름으로 처리하지 못하는 이유는
     * 게시판 처럼 instanceId 로 처리하는 경우가 있기 때문
     * DynamicField 의 config targetName attribute value
     *
     * @var string
     */
    protected $targetName;

    /**
     * ProxyManager 로 전달될 값
     * dynamic() 메소드를 이용할 경우 options 를 지정할 수 있음
     *
     * @var array
     */
    protected $options = [];

    /**
     * proxyManager 동작 여부 설정
     *
     * @var bool
     */
    protected $proxy = false;

    /**
     * dynamic query
     *
     * @var bool
     */
    protected $dynamic = false;

    /**
     * schema() 메소드를 통해 가져온 스키마 데이터
     *
     * @var array
     */
    protected $schemas = [];

    /**
     * dynamic query 사용하면서 join 된 테이블 정보
     *
     * @var array
     */
    protected $dynamicTables = [];

    /**
     * dynamic filter 처리 유무
     *
     * @param bool $use use dynamic flag
     * @return $this
     */
    public function useDynamic($use = true)
    {
        $this->dynamic = $use;
        return $this;
    }

    /**
     * 프록시 처리 유무 설정
     *
     * @param bool $use proxy use
     * @return $this
     */
    public function useProxy($use = true)
    {
        $this->proxy = $use;
        return $this;
    }

    /**
     * proxy 를 위한 options 설정
     *
     * @param array $options proxy option
     * @param bool  $merge   merge options or not
     * @return $this
     */
    public function setProxyOption(array $options, $merge = true)
    {
        if ($merge === true) {
            $this->options = array_merge($this->options, $options);
        } else {
            $this->options = $options;
        }

        return $this;
    }

    /**
     * get table schema
     *
     * @return array
     */
    private function schema()
    {
        return $this->connection->getSchema($this->from);
    }

    /**
     * set dynamic join table information
     *
     * @param string $table table name
     * @return $this
     */
    public function setDynamicTable($table)
    {
        if ($this->hasDynamicTable($table) === false) {
            $this->dynamicTables[] = $table;
        }
        return $this;
    }

    /**
     * has dynamic join table
     *
     * @param string $table table name
     * @return bool
     */
    public function hasDynamicTable($table)
    {
        return in_array($table, $this->dynamicTables);
    }

    /**
     * get dynamic join table
     *
     * @return array
     */
    public function getDynamicTables()
    {
        return $this->dynamicTables;
    }

    /**
     * $args 로 넘어온 데이터와 $columns 를 비교해서 $args 값을 거른다.
     * 처리중인 $columns 와 같은 이름을 데이터만 리턴됨
     * 이 처리는 dynamic 을 통해 proxy 를 처리 할 경우에 대해서 동작됨
     *
     * @param array $args    insert, update data
     * @param array $columns table columns
     * @return array
     */
    private function filter(array $args, array $columns)
    {
        $pure = [];
        foreach ($args as $column => $value) {
            // 컬럼 이름은 문자열만 가능.
            if (is_string($column) && in_array($column, $columns)) {
                $pure[$column] = $args[$column];
            }
        }

        return $pure;
    }

    /**
     * get proxy manager
     *
     * @return ProxyManager|null
     */
    public function getProxyManager()
    {
        if ($this->dynamic === false) {
            return null;
        }

        $proxyManager = $this->connection->getProxyManager();
        $proxyManager->set($this->connection, $this->options);

        return $proxyManager;
    }

    /**
     * insert data
     *
     * @param array $args insert data
     * @return bool
     */
    public function insert(array $args)
    {
        if ($this->dynamic === false) {
            return parent::insert($args);
        }

        $result = true;
        if (count($insert = $this->filter($args, $this->schema())) > 0) {
            $result = parent::insert($insert);
        }

        if ($this->proxy === true) {
            // autoincrement 가 primary key 일 경우 처리 할 것은?
            $this->getProxyManager()->insert($args);
        }

        return $result;
    }

    /**
     * insert data and get id
     *
     * @param array  $args     insert data
     * @param string $sequence sequence
     * @return int
     */
    public function insertGetId(array $args, $sequence = null)
    {
        if ($this->dynamic === false) {
            return parent::insertGetId($args, $sequence);
        }

        $result = 0;
        if (count($insert = $this->filter($args, $this->schema())) > 0) {
            $result = parent::insertGetId($args, $sequence);
        }

        if ($this->proxy === true) {
            // autoincrement 가 primary key 일 경우 처리 할 것은?
            $this->getProxyManager()->insert($args);
        }

        return $result;
    }

    /**
     * update data
     *
     * @param array $args update data
     * @return int
     */
    public function update(array $args)
    {
        if ($this->dynamic === false) {
            return parent::update($args);
        }

        $result = 0;
        if (count($update = $this->filter($args, $this->schema())) > 0) {
            $result = parent::update($update);
        }

        if ($this->proxy === true) {
            $wheres = $this->wheres === null ? [] : $this->wheres;
            $this->getProxyManager()->update($args, $wheres);
        }
        return $result;
    }

    /**
     * Delete a record from the database.
     *
     * @param mixed $id ID
     * @return int
     */
    public function delete($id = null)
    {
        if ($this->dynamic === false) {
            return parent::delete($id);
        }

        $result = parent::delete($id);

        if ($this->proxy === true) {
            $wheres = $this->wheres === null ? [] : $this->wheres;
            $this->getProxyManager()->delete($wheres);
        }

        return $result;
    }

    /**
     * get list
     *
     * @param string $columns get columns list
     * @return array|static[]
     */
    public function count($columns = '*')
    {
        if ($this->dynamic === false) {
            return parent::count($columns);
        }

        if ($this->proxy === true) {
            $this->getProxyManager()->get($this);
        }
        return parent::count($columns);
    }

    /**
     * get list
     *
     * @param array $columns get columns list
     * @return array|static[]
     */
    public function get($columns = ['*'])
    {
        if ($this->dynamic === false) {
            return parent::get($columns);
        }

        if ($this->proxy === true) {
            $this->getProxyManager()->get($this);
        }
        return parent::get($columns);
    }

    /**
     * get first row
     *
     * @param array $columns get columns list
     * @return mixed|static
     */
    public function first($columns = ['*'])
    {
        if ($this->dynamic === false) {
            return parent::first($columns);
        }

        if ($this->proxy === true) {
            $this->getProxyManager()->first($this);
        }
        return parent::first($columns);
    }

    /**
     * Execute a query for a single record by ID.
     *
     * @param int   $id      ID
     * @param array $columns get columns
     * @return mixed|static
     */
    public function find($id, $columns = ['*'])
    {
        if ($this->dynamic === false) {
            return parent::find($id, $columns);
        }

        if ($this->proxy === true) {
            $this->getProxyManager()->first($this);
        }
        return parent::find($id, $columns);
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param int      $perPage  count of list
     * @param array    $columns  get columns
     * @param string   $pageName page parameter name
     * @param int|null $page     page number
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        if ($this->dynamic === false) {
            parent::paginate($perPage, $columns);
        }

        if ($this->proxy === true) {
            $this->getProxyManager()->get($this);
        }

        return parent::paginate($perPage, $columns);
    }

    /**
     * Get a paginator only supporting simple next and previous links.
     *
     * This is more efficient on larger data-sets, etc.
     *
     * @param int    $perPage  count of list
     * @param array  $columns  get columns
     * @param string $pageName page parameter name
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function simplePaginate($perPage = 15, $columns = ['*'], $pageName = 'page')
    {
        if ($this->dynamic === false) {
            parent::simplePaginate($perPage, $columns);
        }

        if ($this->proxy === true) {
            $this->getProxyManager()->get($this);
        }

        return parent::simplePaginate($perPage, $columns);
    }
}

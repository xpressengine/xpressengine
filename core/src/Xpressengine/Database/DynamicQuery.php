<?php
/**
 * DynamicQuery
 *
 * PHP version 5
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Database;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Connection;

/**
 * DynamicQuery
 *
 * * Query 수행할 때 ProxyManage 로 추가 동작을 수행
 * * Illuminate\Database\Query\Builder wrapper
 * * Illuminate\Database\Query\Builder 의 인터페이스를 모두 지원
 *
 * ## 사용법
 *
 * ### query
 * * \Illuminate\Database\Query\Builder 반환
 *
 * ```php
 *  // Illuminate\Database\Query\Builder
 * $query = $queryBuilder->getQuery();
 * ```
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @see         QueryBuilder table() method
 * @method      count
 * @method      DynamicQuery orderBy($column, $direction = 'asc')
 * @method      DynamicQuery groupBy
 * @method      DynamicQuery sum
 * @method      take
 * @method      limit
 * @method      DynamicQuery join($table, $one, $operator = null, $two = null, $type = 'inner', $where = false)
 * @method      DynamicQuery select($columns = ['*'])
 * @method      DynamicQuery whereRaw($sql, array $bindings = [], $boolean = 'and')
 * @method      DynamicQuery whereIn($column, $values, $boolean = 'and', $not = false)
 * @method      DynamicQuery orWhereIn($column, $values)
 * @method      DynamicQuery orWhere($column, $value)
 * @method      DynamicQuery decrement($value)
 * @method      DynamicQuery increment($value)
 * @method      DynamicQuery whereNested($callback)
 * @method      DynamicQuery whereBetween($column, $values)
 */
class DynamicQuery
{
    /**
     * @var VirtualConnectionInterface
     */
    protected $connector;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var Builder
     */
    protected $query;

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
    protected $proxy = true;

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
     * Create instance
     *
     * @param VirtualConnectionInterface $connector connector
     * @param string                     $table     table name
     * @param bool                       $dynamic   proxy use or disuse
     */
    public function __construct(VirtualConnectionInterface $connector, $table, $dynamic = false)
    {
        /**
         * \Illuminate\Database\Query\Builder 를 만들기 위해서 connection 이 필요하다.
         * Builder 를 미리 생성해야 하는 이슈 때문에 driver 를 혼합해서 사용 할 수 없다.
         * mysql, mssql 을 같이 사용 할 수 없음.
         * default connection 으로 사용되는 driver 만 설정이 가능함.
         */
        /**
         * @param Connection $defaultConnection
         */
        $defaultConnection = $connector->getDefaultConnection();
        $processor = $defaultConnection->getPostProcessor();

        $query = new Builder($connector, $defaultConnection->getQueryGrammar(), $processor);
        $query->from($table);

        $this->connector = $connector;
        $this->query = $query;
        $this->table = $table;
        $this->dynamic = $dynamic;
    }

    /**
     * 프록시 처리 유무 설정
     *
     * @param bool $use proxy use
     * @return DynamicQuery
     */
    public function useProxy($use = true)
    {
        $this->proxy = $use;
        $this->dynamic = $use;
        return $this;
    }
    /**
     * proxy 를 위한 options 설정
     *
     * @param array $options proxy option
     * @param bool  $merge   merge options or not
     * @return DynamicQuery
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
     * get illuminate database query builder
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * get table schema
     *
     * @return array
     */
    private function schema()
    {
        return $this->connector->getSchema($this->table);
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

        $proxyManager = $this->connector->getProxyManager();
        $proxyManager->set($this->connector, $this->options);

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
            return $this->query->insert($args);
        }

        $result = true;
        if (count($insert = $this->filter($args, $this->schema())) > 0) {
            $result = $this->query->insert($insert);
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
            return $this->query->insertGetId($args, $sequence);
        }

        $result = 0;
        if (count($insert = $this->filter($args, $this->schema())) > 0) {
            $result = $this->query->insertGetId($insert, $sequence);
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
            return $this->query->update($args);
        }

        $result = 0;
        if (count($update = $this->filter($args, $this->schema())) > 0) {
            $result = $this->query->update($update);
        }

        if ($this->proxy === true) {
            $wheres = $this->query->wheres === null ? [] : $this->query->wheres;
            $this->getProxyManager()->update($args, $wheres);
        }
        return $result;
    }

    /**
     * delete data
     *
     * @return int
     */
    public function delete()
    {
        if ($this->dynamic === false) {
            return $this->query->delete();
        }

        $result = $this->query->delete();

        if ($this->proxy === true) {
            $wheres = $this->query->wheres === null ? [] : $this->query->wheres;
            $this->getProxyManager()->delete($wheres);
        }

        return $result;
    }

    /**
     * get list
     *
     * @param array $columns get columns list
     * @return array|static[]
     */
    public function get(array $columns = ['*'])
    {
        if ($this->dynamic === false) {
            return $this->query->get($columns);
        }

        if ($this->proxy === true) {
            $this->query = $this->getProxyManager()->get($this->query);
        }
        return $this->query->get($columns);
    }

    /**
     * get first row
     *
     * @param array $columns get columns list
     * @return mixed|static
     */
    public function first(array $columns = ['*'])
    {
        if ($this->dynamic === false) {
            return $this->query->first($columns);
        }

        if ($this->proxy === true) {
            $this->query = $this->getProxyManager()->first($this->query);
        }
        return $this->query->first($columns);
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param int   $perPage count of list
     * @param array $columns get columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, array $columns = ['*'])
    {
        if ($this->dynamic === false) {
            $this->query->paginate($perPage, $columns);
        }

        if ($this->proxy === true) {
            $this->query = $this->getProxyManager()->get($this->query);
        }

        return $this->query->paginate($perPage, $columns);
    }

    /**
     * Get a paginator only supporting simple next and previous links.
     *
     * This is more efficient on larger data-sets, etc.
     *
     * @param int   $perPage count of list
     * @param array $columns get columns
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function simplePaginate($perPage, array $columns = ['*'])
    {
        if ($this->dynamic === false) {
            $this->query->simplePaginate($perPage, $columns);
        }

        if ($this->proxy === true) {
            $this->query = $this->getProxyManager()->get($this->query);
        }

        return $this->query->simplePaginate($perPage, $columns);
    }

    /**
     * make where query with alias
     *
     * @param mixed  $column   column name or Closure
     * @param string $operator operator
     * @param mixed  $value    column's value or Closure
     * @param string $boolean  have 'and', 'or' value
     * @return DynamicQuery
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        // add alias name
        if (gettype($column) === 'string') {
            $columnInfo = explode('.', $column);
            if (count($columnInfo)===1) {
                $column = $columnInfo[0];
                $alias = $this->table;
            } else {
                $alias = $columnInfo[0];
                $column = $columnInfo[1];
            }
            $column = sprintf('%s.%s', $alias, $column);
        }

        $this->query = $this->query->where($column, $operator, $value, $boolean);
        return $this;
    }

    /**
     * Get the SQL representation of the query.
     *
     * @return string
     */
    public function toSql()
    {
        return $this->query->toSql();
    }

    /**
     * \Illuminate\Database\Query\Builder 의 method 호출
     * return 이 \Illuminate\Database\Query\Builder 일 경우는 \Xpressengine\Database\DynamicQuery 를 return
     *
     * @param string $method     method name
     * @param array  $parameters parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $result = call_user_func_array(array($this->query, $method), $parameters);
        if (gettype($result) == 'object' && get_class($result) === 'Illuminate\Database\Query\Builder') {
            $this->query = $result;
            return $this;
        } else {
            return $result;
        }
    }
}

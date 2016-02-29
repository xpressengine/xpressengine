<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Member\Repositories;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Member\Entities\Entity;
use Xpressengine\User\Exceptions\IDNotFoundException;

/**
 * 이 Trait는 Xpressengine의 Member Package에서 Database를 사용하는 Repository를 구현할 때 사용하는 Trait이다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
trait DatabaseRepositoryTrait
{
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var bool
     */
    protected $isDynamic = false;

    /**
     * @var string
     */
    protected $mainTable;

    /**
     * @var Keygen
     */
    protected $generator;

    /**
     * @var string
     */
    public $entityClass;

    /**
     * @var array
     */
    protected $relations = [];

    /**
     * @var string
     */
    protected $defaultSort;

    /**
     * @var string
     */
    protected $defaultOrder = 'asc';

    /**
     * @var int
     */
    protected $defaultPerPage = 10;

    /**
     * 이 Repostiory에서 반환하는 Entity 정보와 관련된 다른 Entity에 대한 연결정보를 등록한다.
     *
     * 예를 들어 회원정보를 출력할 때, 회원이 소유한 이메일 정보를 추가로 출력한다면
     * `addRelation('mails', ..)`을 사용하여 등록할 수 있다.
     * 이 때, 두번째 파라메터는 회원 조회를 할 때, 조건으로 이메일 id를 사용할 수 있도록 해준다.
     * 세번째 파라메터는 조회된 회원정보를 출력할 때, 그 회원이 소유한 이메일 정보를 추가하여 반환할 때 사용한다.
     *
     * @param string   $name          연결할 Entity를 인식할 때 사용할 id
     * @param callable $selectClosure 연결할 Entity의 정보를 추가로 출력할 때 사용할 Closure
     * @param callable $whereClosure  연결할 Entity의 정보를 조건으로 사용할 때 사용할 Closure
     *
     * @return void
     */
    public function addRelation($name, $selectClosure, $whereClosure = null)
    {
        $this->relations[$name] = ['where' => $whereClosure, 'select' => $selectClosure];
        $entityClass = $this->entityClass;
        $entityClass::addRelationField($name);
    }

    /**
     * db connection을 지정한다.
     *
     * @param ConnectionInterface $conn db connection
     *
     * @return void
     */
    public function setConnection($conn)
    {
        $this->connection = $conn;
    }

    /**
     * db connection을 반환한다.
     *
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * 이 Repository에서 사용하는 db table을 지정한다.
     *
     * @param string $table db table
     *
     * @return void
     */
    public function setTable($table)
    {
        $this->mainTable = $table;
    }

    /**
     * 이 Repository에서 사용하는 entity의 클래스를 지정한다.
     *
     * @param string $entityClass Entity의 클래스명
     *
     * @return void
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * 주어진 ID에 해당하는 정보가 존재하는지의 여부를 반환한다.
     *
     * @param string $id 조회할 Entity의 id
     *
     * @return bool
     */
    public function has($id)
    {
        return $this->count(['id' => $id]) !== 0;
    }

    /**
     * 주어진 id에 해당하는 entity를 조회하여 반환한다.
     *
     * @param string        $id   조회할 entity의 아이디
     * @param string[]|null $with entity와 함께 반환할 relation 정보
     *
     * @return null|Entity
     */
    public function find($id, $with = null)
    {
        return $this->fetchOne(['id' => $id], $with);
    }

    /**
     * 주어진 id에 해당하는 entity들의 목록을 반환한다.
     *
     * @param string[]      $ids  조회할 entity의 아이디 목록
     * @param string[]|null $with entity와 함께 반환할 relation 정보
     *
     * @return array
     */
    public function findAll($ids, $with = null)
    {
        return $this->fetchAll(['id' => $ids], $with);
    }

    /**
     * 주어진 조건에 해당하는 entity 목록을 조회한다. 조회할 때에는 pagination이 적용된다.
     *
     * @param array              $wheres     검색 조건
     * @param string[]|null      $with       entity와 함께 반환할 relation 정보
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    public function fetch($wheres, $with = null, $navigation = 10)
    {
        $query = $this->table();
        $query = $this->wheres($query, $wheres);
        return $this->getEntities($query, $with, $navigation);
    }

    /**
     * 주어진 조건에 해당하는 entity 하나를 조회한다.
     *
     * @param array         $wheres 검색 조건
     * @param string[]|null $with   entity와 함께 반환할 relation 정보
     *
     * @return null|Entity
     */
    public function fetchOne($wheres, $with = null)
    {
        $query = $this->table();
        $query = $this->wheres($query, $wheres);
        return $this->getEntity($query, $with);
    }

    /**
     * 주어진 조건에 해당하는 모든 entity 조회한다.
     *
     * @param mixed         $wheres 검색 조건
     * @param string[]|null $with   entity와 함께 반환할 relation 정보
     *
     * @return array
     */
    public function fetchAll($wheres, $with = null)
    {
        $query = $this->table();
        $query = $this->wheres($query, $wheres);
        return $this->getEntities($query, $with);
    }

    /**
     * entity 목록을 조회한다. pagination된 결과를 반환한다.
     *
     * @param string[]|null      $with       entity와 함께 반환할 relation 정보
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    public function paginate($with = null, $navigation = 10)
    {
        $query = $this->table();
        return $this->getEntities($query, $with, $navigation);
    }

    /**
     * 모든 entity 목록을 조회한다.
     *
     * @param string[]|null $with entity와 함께 반환할 relation 정보
     *
     * @return array
     */
    public function all($with = null)
    {
        $query = $this->table();
        return $this->getEntities($query, $with);
    }

    /**
     * 주어진 조건에 해당하는 entity 목록을 조회한다. $searches 파라메터에 지정된 조건은 like 검색을 수행한다.
     *
     * $searches 파라메터는 아래와 같이 지정될 수 있다.
     * ```
     * $searches = [
     *      'displayName' => 'foo',
     * ]
     * // where displayName like '%foo%'
     *
     * $searches = [
     *      'displayName|email' => 'foo'
     * ]
     * // where displayName like '%foo%' or email like '%foo%'
     *
     * $searches = [
     *      'displayName' => 'foo',
     *      'email' => 'bar'
     * ]
     * // where displayName like '%foo%' and email like '%bar%'
     * ```
     *
     * @param mixed              $searches   like 검색을 위한 조건
     * @param mixed              $wheres     검색 조건
     * @param string[]|null      $with       entity와 함께 반환할 relation 정보
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    public function search($searches, $wheres = null, $with = null, $navigation = 10)
    {
        $query = $this->table();
        $query = $this->searches($query, $searches);
        if ($wheres !== null) {
            $query = $this->wheres($query, $wheres);
        }
        return $this->getEntities($query, $with, $navigation);
    }

    /**
     * 주어진 조건에 해당하는 entity의 갯수를 반환한다.
     *
     * @param mixed $wheres 검색 조건
     *
     * @return int
     */
    public function count($wheres = null)
    {
        $query = $this->table();
        if ($wheres !== null) {
            $query = $this->wheres($query, $wheres);
        }
        return $query->count();
    }

    /**
     * 주어진 entity 정보를 database에 추가한다.
     *
     * @param Entity $entity 삽입할 정보
     *
     * @return Entity
     */
    public function insert($entity)
    {
        $now = $this->getCurrentTime();
        if (!isset($entity->id)) {
            $this->generateId($entity);
        }
        $entity->createdAt = $entity->updatedAt = $now;

        $data = $entity->getAttributes();
        $relations = array_keys($this->relations);

        $this->table()->insert(array_except($data, $relations));

        return $entity;
    }

    /**
     * 주어진 entity 정보를 database에 업데이트한다.
     *
     * @param Entity $entity 업데이트할 정보
     *
     * @return Entity
     */
    public function update($entity)
    {
        if ($entity->id === null) {
            throw new IDNotFoundException();
        }

        $data = $entity->diff();

        if (count($data) > 0) {
            $data['updatedAt'] = $this->getCurrentTime();
            $this->table()->where('id', $entity->id)->update($data);
            $entity->updatedAt = $data['updatedAt'];
        }
        $entity->syncOriginal();
        return $entity;
    }

    /**
     * 주어진 entity를 database에서 삭제한다.
     *
     * @param Entity $entity 삭제할 entity 정보
     *
     * @return int
     */
    public function delete($entity)
    {
        if ($entity->id === null) {
            throw new IDNotFoundException();
        }

        return $this->table()->where('id', $entity->id)->delete();
    }

    /**
     * 주어진 query를 실행한 후 query결과를 entity 목록으로 생성하여 반환한다.
     *
     * @param Builder            $query      질의
     * @param string[]|null      $with       entity와 함께 반환할 relation 정보
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    protected function getEntities($query, $with = null, $navigation = null)
    {
        $collection = $this->executeQuery($query, $navigation);

        $collection = $this->loadRelations($collection, $with);

        return $this->makeEntities($collection);
    }

    /**
     * 주어진 db query를 실행한다.
     *
     * @param Builder            $query      질의
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    protected function executeQuery($query, $navigation = null)
    {
        // set default
        $order = $this->defaultOrder;
        $sort = $this->defaultSort;
        $perPage = $this->defaultPerPage;
        $page = null;

        if (is_array($navigation)) {
            list($page, $perPage) = $navigation;
        } elseif (is_object($navigation)) {
            $page = data_get($navigation, 'page', $page);
            $perPage = data_get($navigation, 'perPage', $perPage);
            $order = data_get($navigation, 'order', $order);
            $sort = data_get($navigation, 'sort', $sort);
        }

        if ($sort !== null) {
            $query->orderBy($sort, $order);
        }

        if ($navigation === null) {
            $collection = $query->get();
        } elseif ($page !== null) {
            $collection = $query->forPage($page, $perPage);
        } else {
            $collection = $query->paginate($perPage);
        }

        return $collection;
    }

    /**
     * 주어진 query를 실행한 후 query결과를 entity로 생성하여 반환한다.
     *
     * @param Builder       $query 질의
     * @param string[]|null $with  entity와 함께 반환할 relation 정보
     *
     * @return null|Entity
     */
    protected function getEntity($query, $with = null)
    {
        $attributes = $query->first();

        if ($attributes === null) {
            return null;
        }

        $collection = [$attributes];
        $collection = $this->loadRelations($collection, $with);

        return $this->newEntity(array_shift($collection));
    }

    /**
     * 주어진 테이블에 질의할 수 있는 QueryBulider를 생성하여 반환한다.
     * 두번째 파라메터가 true로 지정되면 해당 테이블에 dynamic field가 적용된 테이블로 간주하고, 질의한다.
     *
     * @param string $table      질의할 대상 table, null일 경우 Repository에 지정된 기본 테이블이 사용된다.
     * @param bool   $useDynamic 질의할 때 Xpressengine의 dynamicField를 사용할 것인지의 여부
     *
     * @return Builder
     */
    protected function table($table = null, $useDynamic = null)
    {
        $table = $table === null ? $this->mainTable : $table;
        $useDynamic = $useDynamic === null ? $this->isDynamic : $useDynamic;

        if ($useDynamic) {
            return $this->connection->dynamic($table);
        } else {
            return $this->connection->table($table);
        }
    }

    /**
     * 주어진 array에 해당하는 raw data 목록을 사용하여 entity 목록을 생성하여 반환한다.
     *
     * @param array $collection raw data 목록
     *
     * @return array
     */
    protected function makeEntities(&$collection)
    {
        foreach ($collection as $key => &$attributes) {
            $collection[$key] = $this->newEntity($attributes);
        }

        return $collection;
    }

    /**
     * 주어진 array에 해당하는 raw data를 사용하여 entity를 생성하여 반환한다.
     *
     * @param array $attributes raw data
     *
     * @return Entity
     */
    protected function newEntity($attributes)
    {
        return new $this->entityClass($attributes);
    }

    /**
     * database에서 질의해온 결과(raw data)에 두번째 파라메터로 지정된 relation 정보를 생성하여 추가한다.
     *
     * @param array         $collection raw data
     * @param string[]|null $with       entity와 함께 반환할 relation 정보
     *
     * @return array
     */
    protected function loadRelations(&$collection, $with = null)
    {
        // eager loading for relation fields
        if ($with !== null && count((array) $with) > 0) {
            $relationData = [];
            $ids = array_pluck($collection, 'id');

            // get relation field
            foreach ((array) $with as $relation) {
                $selectClosure = $this->relations[$relation]['select'];
                $relationData[$relation] = $selectClosure($ids) ?: [];
            }

            // sort relation field by id x fieldname
            $sortedRelationData = [];
            foreach ($relationData as $relation => $data) {
                foreach ($data as $id => $d) {
                    array_set($sortedRelationData, $id.'.'.$relation, $d);
                }
            }
            foreach ($collection as $key => &$row) {
                $id = $row['id'];
                $row = array_merge($row, array_get($sortedRelationData, $id, []));
                $collection[$key] = $row;
            }
        }
        return $collection;
    }

    /**
     * 주어진 query에 검색 조건을 적용한다.
     *
     * @param Builder      $query 검색조건을 적용할 query
     * @param string|array $field 검색할 조건의 필드명
     * @param mixed        $value 검색할 조건의 필드 값, $field 파라메터가 array 형식일 경우 이 파라메터는 무시된다.
     *
     * @return Builder
     */
    protected function wheres($query, $field, $value = null)
    {
        // multi condition
        if (is_array($field)) {
            foreach ($field as $f => $v) {
                $query = $this->where($query, $f, $v);
            }
            // single condition
        } else {
            //todo: check $value is null!!
            $query = $this->where($query, $field, $value);
        }
        return $query;
    }

    /**
     * 주어진 query에 단일 검색 조건을 적용한다.
     *
     * @param Builder $query 검색조건을 적용할 query
     * @param string  $field 검색할 조건의 필드명
     * @param mixed   $value 검색할 조건의 필드 값
     *
     * @return Builder
     */
    protected function where($query, $field, $value)
    {
        if (isset($this->relations[$field])) {
            $relationQuery = $this->relations[$field]['where'];
            return $relationQuery($query, $value);
        } elseif (is_array($value)) {
            $query = $query->whereIn($field, $value);
            return $query;
        } else {
            $query = $query->where($field, $value);
            return $query;
        }
    }

    /**
     * 주어진 query에 like 검색 조건을 추가한다.
     *
     * @param Builder $query    검색조건을 적용할 query
     * @param mixed   $searches 검색할 조건
     *
     * @return Builder
     */
    protected function searches($query, $searches)
    {
        foreach ($searches as $field => $value) {
            $fields = explode(',', $field);
            $query->where(array_shift($fields), 'like', '%'.$value.'%');

            foreach ($fields as $f) {
                $query->orWhere($f, 'like', '%'.$value.'%');
            }
        }

        return $query;
    }

    /**
     * 현재 시간을 반환한다.
     *
     * @return string
     */
    protected function getCurrentTime()
    {
        return date('Y-m-d H:i:s');
    }

    /**
     * Xpressengine의 Keygen을 사용하여 고유 아이디를 생성한후 주어진 entity의 id로 지정한다.
     *
     * @param Entity $entity id를 지정할 entkty
     *
     * @return void
     */
    protected function generateId($entity)
    {
        $entity->id = $this->generator->generate();
    }
}

<?php
/**
 * ProxyInterface
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
use Xpressengine\Database\VirtualConnectionInterface;

/**
 * ProxyInterface
 *
 * * DynamicQuery 에서 first, get, insert, update, delete 처리 시 ProxyManager 에 등록된 Proxy 처리
 * * ProxyManager 에 등록하기 위한 interface
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @see         Xpressengine\DynamicField\DynamicField
 */
interface ProxyInterface
{

    /**
     * set connection
     *
     * @param VirtualConnectionInterface $connection connection
     * @param array                      $options    table name
     * @return void
     */
    public function set(VirtualConnectionInterface $connection, array $options);

    /**
     * insert
     *
     * @param array $args parameters
     * @return void
     * @see QueryBuilde::insert()
     */
    public function insert(array $args);

    /**
     * update
     *
     * @param array $args   parameters
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     * @see QueryBuilde::update()
     */
    public function update(array $args, array $wheres);

    /**
     * delete
     *
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     * @see QueryBuilder::delete()
     */
    public function delete(array $wheres);

    /**
     * DynamicQuery 에서 get() method 실행 시 join 처리
     * 리스트 가져올 때 join 처리.
     * 하나의 row 를 처리할 때 join 이 다를 수 있기때문에 joinFirst()로 두가지 제공.
     *
     * @param Builder $query query builder
     * @return Builder
     * @see QueryBuilder::et()
     */
    public function get(Builder $query);

    /**
     * DynamicQuery 에서 first() method 실행 시 join 처리
     *
     * @param Builder $query query builder
     * @return Builder
     * @see QueryBuilder::first()
     */
    public function first(Builder $query);

    /**
     * 등록된 모든 proxy 의 wheres()를 처리함.
     *
     * @param Builder $query  query builder
     * @param array   $wheres parameters for where
     * @return Builder
     */
    public function wheres(Builder $query, array $wheres);

    /**
     * 등록된 모든 proxy의 orders()를 처리함.
     *
     * @param Builder $query  query builder
     * @param array   $orders parameters for order
     * @return Builder
     */
    public function orders(Builder $query, array $orders);
}

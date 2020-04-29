<?php
/**
 * ProxyInterface
 *
 * PHP version 7
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database;

use Illuminate\Database\Query\Builder;

/**
 * ProxyInterface
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
     * @param DynamicQuery $query query builder
     * @return DynamicQuery
     * @see QueryBuilder::et()
     */
    public function get(DynamicQuery $query);

    /**
     * DynamicQuery 에서 first() method 실행 시 join 처리
     *
     * @param DynamicQuery $query query builder
     * @return DynamicQuery
     * @see QueryBuilder::first()
     */
    public function first(DynamicQuery $query);

    /**
     * 등록된 모든 proxy 의 wheres()를 처리함.
     *
     * @param DynamicQuery $query  query builder
     * @param array        $wheres parameters for where
     * @return Builder
     */
    public function wheres(DynamicQuery $query, array $wheres);

    /**
     * 등록된 모든 proxy의 orders()를 처리함.
     *
     * @param DynamicQuery $query  query builder
     * @param array        $orders parameters for order
     * @return DynamicQuery
     */
    public function orders(DynamicQuery $query, array $orders);
}

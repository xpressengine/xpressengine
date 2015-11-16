<?php
/**
 * This file is interface of repository
 *
 * PHP version 5
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Storage;

/**
 * 파일의 정보를 저장, 제공하기위한 인터페이스를 제공
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface FileRepository
{
    /**
     * find record
     *
     * @param string $id file identifier
     * @return File
     */
    public function find($id);

    /**
     * insert query
     *
     * @param File $file file instance
     * @return File
     */
    public function insert(File $file);

    /**
     * update query
     *
     * @param File $file file instance
     * @return File
     */
    public function update(File $file);

    /**
     * return record list
     *
     * @param array $wheres where clause list
     * @return array
     */
    public function fetch(array $wheres);

    /**
     * return record list by identifier
     *
     * @param array $ids file identifier
     * @return array
     */
    public function fetchIn(array $ids);

    /**
     * return target has file records
     *
     * @param string $targetId own target identifier
     * @return array
     */
    public function fetchByTargetId($targetId);

    /**
     * returns paginator consisting of file
     *
     * @param array $wheres where clause
     * @param int   $take   take record count
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $wheres, $take);

    /**
     * delete record
     *
     * @param File $file file instance
     * @return void
     */
    public function delete(File $file);

    /**
     * related file to target
     *
     * @param string $targetId target identifier
     * @param string $id       file identifier
     * @return void
     */
    public function relating($targetId, $id);

    /**
     * unrelated file
     *
     * @param string $targetId target identifier
     * @param string $id       file identifier
     * @return void
     */
    public function unRelating($targetId, $id);

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param string $column column name
     * @param array  $wheres where clause
     * @return int
     */
    public function sum($column, array $wheres = []);

    /**
     * Retrieve the sum of the values of a given column by groupBy
     *
     * @param string $column  column for sum
     * @param string $groupBy groupBy column
     * @param array  $wheres  where clause
     * @return array groupBy => sumValue format
     */
    public function sumGroupBy($column, $groupBy, array $wheres = []);

    /**
     * Retrieve the "count" result of the query.
     *
     * @param array $wheres where clause
     * @return int
     */
    public function count(array $wheres = []);

    /**
     * Retrieve the "count" result of the query by groupBy
     *
     * @param string $groupBy groupBy column
     * @param array  $wheres  where clause
     * @return array groupBy => count format
     */
    public function countGroupBy($groupBy, array $wheres = []);
}

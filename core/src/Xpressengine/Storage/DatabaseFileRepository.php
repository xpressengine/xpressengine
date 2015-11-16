<?php
/**
 * This file is repository using a database
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

use Exception;
use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Database\BuildWhereTrait;

/**
 * 데이터베이스로 부터 파일의 정보를 제공, 저장
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class DatabaseFileRepository implements FileRepository
{
    use BuildWhereTrait;

    /**
     * database connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * table name
     *
     * @var string
     */
    protected $table = 'files';

    /**
     * relation table name
     *
     * @var string
     */
    protected $relationTable = 'files_relation';

    /**
     * constructor
     *
     * @param VirtualConnectionInterface $conn database connection instance
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * find record
     *
     * @param string $id file identifier
     * @return File
     */
    public function find($id)
    {
        $row = $this->conn->table($this->table)->where('id', $id)->first();

        return $row !== null ? $this->createFile((array)$row) : null;
    }

    /**
     * insert query
     *
     * @param File $file file instance
     * @return File
     */
    public function insert(File $file)
    {
        $attributes = array_merge($file->getAttributes(), [
            'createdAt' => date('Y-m-d H:i:s')
        ]);

        $this->conn->table($this->table)->insert($attributes);

        return $this->createFile($attributes);
    }

    /**
     * update query
     *
     * @param File $file file instance
     * @return File
     */
    public function update(File $file)
    {
        $diff = $file->diff();

        if (count($diff) > 0) {
            $this->conn->table($this->table)->where('id', $file->id)->update($diff);
        }

        return $this->createFile(array_merge($file->getOriginal(), $diff));
    }

    /**
     * return record list
     *
     * @param array $wheres where clause list
     * @return array
     */
    public function fetch(array $wheres)
    {
        $query = $this->buildWhere($this->conn->table($this->table), $wheres);

        $rows = $query->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createFile((array)$row);
        }

        return $items;
    }

    /**
     * return record list by identifier
     *
     * @param array $ids file identifier
     * @return array
     */
    public function fetchIn(array $ids)
    {
        $rows = $this->conn->table($this->table)->whereIn('id', $ids)->get();

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createFile((array)$row);
        }

        return $items;
    }

    /**
     * return target has file records
     *
     * @param string $targetId own target identifier
     * @return array
     */
    public function fetchByTargetId($targetId)
    {
        $rows = $this->conn->table($this->table)
            ->leftJoin($this->relationTable, $this->table . '.id', '=', $this->relationTable . '.filesId')
            ->where($this->relationTable . '.targetId', $targetId)
            ->get([$this->table . '.*']);

        $items = [];
        foreach ($rows as $row) {
            $items[] = $this->createFile((array)$row);
        }

        return $items;
    }

    /**
     * returns paginator consisting of file
     *
     * @param array $wheres where clause
     * @param int   $take   take record count
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(array $wheres, $take)
    {
        $query = $this->buildWhere($this->conn->table($this->table), $wheres);

        $query->orderBy('createdAt', 'desc');

        $paginator = $query->paginate($take);

        foreach ($paginator as $idx => $row) {
            $paginator[$idx] = $this->createFile((array)$row);
        }

        return $paginator;
    }

    /**
     * delete record
     *
     * @param File $file file instance
     * @return void
     * @throws Exception
     */
    public function delete(File $file)
    {
        $this->conn->beginTransaction();

        try {
            $this->conn->table($this->table)->where('id', $file->id)->delete();

            $this->conn->table($this->relationTable)->where('filesId', $file->id)->delete();
        } catch (Exception $e) {
            $this->conn->rollBack();

            throw $e;
        }

        $this->conn->commit();
    }

    /**
     * related file to target
     *
     * @param string $targetId target identifier
     * @param string $id       file identifier
     * @return void
     * @throws Exception
     */
    public function relating($targetId, $id)
    {
        if ($this->findRelationOne($targetId, $id) === null) {
            $this->conn->beginTransaction();

            try {
                $this->conn->table($this->relationTable)->insert([
                    'targetId' => $targetId,
                    'filesId' => $id,
                    'createdAt' => date('Y-m-d H:i:s')
                ]);

                $this->conn->table($this->table)
                    ->where('id', $id)
                    ->orWhere('parentId', $id)
                    ->increment('useCount');
            } catch (Exception $e) {
                $this->conn->rollBack();

                throw $e;
            }

            $this->conn->commit();
        }
    }

    /**
     * unrelated file
     *
     * @param string $targetId target identifier
     * @param string $id       file identifier
     * @return void
     * @throws Exception
     */
    public function unRelating($targetId, $id)
    {
        if ($row = $this->findRelationOne($targetId, $id)) {
            $this->conn->beginTransaction();
            try {
                $row = (array)$row;
                $this->conn->table($this->relationTable)
                    ->where('id', $row['id'])
                    ->delete();

                $this->conn->table($this->table)
                    ->where('id', $id)
                    ->orWhere('parentId', $id)
                    ->decrement('useCount');
            } catch (Exception $e) {
                $this->conn->rollBack();

                throw $e;
            }

            $this->conn->commit();
        }
    }

    /**
     * get one relation
     *
     * @param string $targetId target identifier
     * @param string $id       file identifier
     * @return \stdClass|null
     */
    private function findRelationOne($targetId, $id)
    {
        return $this->conn->table($this->relationTable)
            ->where('targetId', $targetId)
            ->where('filesId', $id)
            ->first();
    }

    /**
     * Retrieve the sum of the values of a given column.
     *
     * @param string $column column name
     * @param array  $wheres where clause
     * @return int
     */
    public function sum($column, array $wheres = [])
    {
        return $this->buildWhere($this->conn->table($this->table), $wheres)->sum($column);
    }

    /**
     * Retrieve the sum of the values of a given column by groupBy
     *
     * @param string $column  column for sum
     * @param string $groupBy groupBy column
     * @param array  $wheres  where clause
     * @return array groupBy => sumValue format
     */
    public function sumGroupBy($column, $groupBy, array $wheres = [])
    {
        $rows = $this->buildWhere($this->conn->table($this->table), $wheres)
            ->selectRaw("`{$groupBy}`, sum(`{$column}`) as amount")
            ->groupBy($groupBy)
            ->get();

        $array = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $array[$row[$groupBy]] = $row['amount'];
        }

        return $array;
    }

    /**
     * Retrieve the "count" result of the query.
     *
     * @param array $wheres where clause
     * @return int
     */
    public function count(array $wheres = [])
    {
        return $this->buildWhere($this->conn->table($this->table), $wheres)->count();
    }

    /**
     * Retrieve the "count" result of the query by groupBy
     *
     * @param string $groupBy groupBy column
     * @param array  $wheres  where clause
     * @return array groupBy => count format
     */
    public function countGroupBy($groupBy, array $wheres = [])
    {
        $rows = $this->buildWhere($this->conn->table($this->table), $wheres)
            ->selectRaw("`{$groupBy}`, count(*) as cnt")
            ->groupBy($groupBy)
            ->get();

        $array = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $array[$row[$groupBy]] = $row['cnt'];
        }

        return $array;
    }

    /**
     * create file object instance
     *
     * @param array $attributes instance attributes
     * @return File
     */
    private function createFile(array $attributes)
    {
        return new File($attributes);
    }
}

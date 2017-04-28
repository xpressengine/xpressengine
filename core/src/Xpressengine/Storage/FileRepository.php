<?php
/**
 * FileRepository.php
 *
 * PHP version 5
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Storage;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Expression;
use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * Class FileRepository
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class FileRepository
{
    use EloquentRepositoryTrait;

    /**
     * Save a new file model and return the instance.
     *
     * @param array       $data attributes
     * @param string|null $id   file id
     * @return File
     */
    public function create(array $data = [], $id = null)
    {
        $file = $this->createModel();
        $file->fill($data);

        if ($id) {
            $file->setAttribute($file->getKeyName(), $id);
        }

        $file->save();

        return $file;
    }

    /**
     * Get files by given ids
     *
     * @param array $ids     file ids
     * @param array $columns columns
     * @return Collection|File[]
     */
    public function fetchIn(array $ids, $columns = ['*'])
    {
        return $this->query()->whereIn('id', $ids)->get($columns);
    }

    /**
     * Get the files for fileable
     *
     * @param string $fileableId fileable identifier
     * @param array  $columns    columns
     * @return Collection|File[]
     */
    public function fetchByFileable($fileableId, $columns = ['*'])
    {
        /** @var File $model */
        $model = $this->createModel();

        return $this->query()
            ->rightJoin($model->getFileableTable(), $model->getTable().'.id', '=', $model->getFileableTable().'.fileId')
            ->where('fileableId', $fileableId)
            ->select(array_map(function ($column) use ($model) {
                return $model->getTable() . '.' . $column;
            }, $columns))
            ->get();
    }

    /**
     * mime 별 파일 용량 정보 반환
     *
     * @param callable $scope 검색 조건
     * @return array ex.) [mime => bytes]
     */
    public function bytesByMime(callable $scope = null)
    {
        $query = $this->query()->getQuery();

        if ($scope) {
            call_user_func($scope, $query);
        }

        $rows = $query->groupBy('mime')
            ->select(['mime', new Expression('sum(`size`) as amount')])
            ->get();

        $array = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $array[$row['mime']] = $row['amount'];
        }

        return $array;
    }

    /**
     * mime 별 파일 갯수 반환
     *
     * @param callable $scope 검색 조건
     * @return array ex.) [mime => count]
     */
    public function countByMime(callable $scope = null)
    {
        $query = $this->query()->getQuery();

        if ($scope) {
            call_user_func($scope, $query);
        }

        $rows = $query->groupBy('mime')
            ->select(['mime', new Expression('count(*) as cnt')])
            ->get();

        $array = [];
        foreach ($rows as $row) {
            $row = (array)$row;
            $array[$row['mime']] = $row['cnt'];
        }

        return $array;
    }
}

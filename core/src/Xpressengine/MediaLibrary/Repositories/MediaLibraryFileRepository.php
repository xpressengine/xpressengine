<?php

namespace Xpressengine\MediaLibrary\Repositories;

use Xpressengine\Support\EloquentRepositoryTrait;

class MediaLibraryFileRepository
{
    use EloquentRepositoryTrait;

    const ORDER_TYPE_UPDATED_DESC = 1;
    const ORDER_TYPE_CREATED_DESC = 2;
    const ORDER_TYPE_TITLE_ASC = 3;

    /**
     * @param array $attributes
     */
    public function getItems($attributes)
    {
        $query = $this->query();

        $query = $this->makeWhere($query, $attributes);
        $query = $this->makeOrder($query, $attributes);
        $items = $this->getPaginate($query, $attributes);

        return $items;
    }

    protected function makeWhere($query, $attributes)
    {
        if (isset($attributes['folder_id']) == true) {
            $query = $query->where('folder_id', $attributes['folder_id']);
        }

        if (isset($attributes['startDate']) == true) {
            $startDate = date('Y-m-d', strtotime($attributes['startDate']));

            $query = $query->where('updated_at', '>=', $startDate);
        }

        if (isset($attributes['endDate']) == true) {
            $endDate = date('Y-m-d', strtotime($attributes['endDate']));

            $query = $query->where('updated_at', '<=', $endDate);
        }

        if (isset($attributes['keyword']) == true) {
            $keyword = $attributes['keyword'];

            if (isset($attributes['target']) == false) {
                $query = $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('caption', 'like', '%' . $keyword . '%')
                        ->orWhere('alt_text', 'like', '%' . $keyword . '%')
                        ->orWhere('description', 'like', '%' . $keyword . '%');
                });
            } else {
                $query = $query->where($attributes['target'], 'like', '%' . $keyword . '%');
            }
        }

        if (isset($attributes['mime']) == true) {
            $query = $query->whereHas('file', function ($query) use ($attributes) {
                $query->where('mime', $attributes['mime']);
            });
        }

        return $query;
    }

    protected function makeOrder($query, $attributes)
    {
        $orderType = self::ORDER_TYPE_UPDATED_DESC;
        if (isset($attributes['orderType']) == true) {
            $orderType = $attributes['orderType'];
        }

        switch ($orderType) {
            case self::ORDER_TYPE_UPDATED_DESC:
                $query = $query->orderBy('updated_at', 'desc');
                break;

            case self::ORDER_TYPE_CREATED_DESC:
                $query = $query->orderBy('created_at', 'desc');
                break;

            case self::ORDER_TYPE_TITLE_ASC:
                $query = $query->orderBy('title', 'asc');
                break;
        }

        return $query;
    }

    protected function getPaginate($query, $attributes)
    {
        $perPageCount = 50;
        if (isset($attributes['per_page']) == true) {
            $perPageCount = $attributes['per_page'];
        }

        $items = $query->paginate($perPageCount, ['*'], 'file_page')->appends(array_forget($attributes, 'file_page'));

        return $items;
    }

    public function setCommonFileVisible($fileItem)
    {
        if ($fileItem->user != null) {
            $fileItem->user->setAttribute('profile_image_url', $fileItem->user->getProfileImage());
            $fileItem->user->addVisible(['profile_image_url']);
        }
        $fileItem->file->addVisible(['path', 'filename']);
    }
}

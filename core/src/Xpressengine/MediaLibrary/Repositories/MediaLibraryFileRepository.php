<?php
/**
 * MediaLibraryFileRepository.php
 *
 * PHP version 7
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\MediaLibrary\Repositories;

use Illuminate\Database\Eloquent\Model;
use Xpressengine\MediaLibrary\MediaLibraryHandler;
use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * Class MediaLibraryFileRepository
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaLibraryFileRepository
{
    use EloquentRepositoryTrait {
        delete as traitDelete;
        update as traitUpdate;
    }

    const ORDER_TYPE_UPDATED_DESC = 1;
    const ORDER_TYPE_CREATED_DESC = 2;
    const ORDER_TYPE_TITLE_ASC = 3;
    const ORDER_TYPE_FILE_SIZE_DESC = 4;
    const ORDER_TYPE_USER_NAME_ASC = 5;

    /**
     * @param array $attributes items attribute
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getItems($attributes)
    {
        $query = $this->query();

        $query = $this->makeWhere($query, $attributes);
        $query = $this->makeOrder($query, $attributes);
        $items = $this->getPaginate($query, $attributes);

        return $items;
    }

    /**
     * @param array $attribute new item attribute
     *
     * @return Model
     */
    public function storeItem($attribute)
    {
        $fileItem = $this->createModel();
        $fileItem->fill($attribute);
        $fileItem->save();

        $generateTitle = $this->getGenerateTitle($fileItem);
        if ($fileItem->title != $generateTitle) {
            $fileItem->title = $generateTitle;
            $fileItem->save();
        }

        return $fileItem;
    }

    /**
     * @param Model $item target item
     * @param array $data data
     *
     * @return Model
     */
    public function update(Model $item, array $data = [])
    {
        $this->traitUpdate($item, $data);

        $data['title'] = $this->getGenerateTitle($item);
        if ($item->title != $data['title']) {
            $item->title = $data['title'];
            $this->traitUpdate($item, $data);
        }

        return $item;
    }

    /**
     * @param Model $fileItem target item
     *
     * @return string
     */
    public function getGenerateTitle($fileItem)
    {
        if ($this->query()->where(
            [
                ['id', '<>', $fileItem->id],
                ['folder_id', $fileItem->folder_id],
                ['title', $fileItem->title]
            ]
        )->exists() == false) {
            return $fileItem->title;
        }

        $increment = 0;
        while ($this->checkExistTitle($fileItem, $increment) == true) {
            ++$increment;
        }

        return $this->attachTitleIncrement($fileItem->title, $increment);
    }

    /**
     * @param Model $fileItem  item
     * @param int   $increment increment count
     *
     * @return bool
     */
    private function checkExistTitle($fileItem, $increment)
    {
        return $this->query()->where(
            [
                ['id', '<>', $fileItem->id],
                ['folder_id', $fileItem->folder_id],
                ['title', $this->attachTitleIncrement($fileItem->title, $increment)]
            ]
        )->exists();
    }

    /**
     * @param string $title     title
     * @param int    $increment increment count
     *
     * @return string
     */
    private function attachTitleIncrement($title, $increment)
    {
        if ($increment > 0) {
            $title .= ' (' . $increment . ')';
        }

        return $title;
    }

    /**
     * @param Model $query      model
     * @param array $attributes attribute
     *
     * @return mixed
     */
    protected function makeWhere($query, $attributes)
    {
        if (isset($attributes['index_mode']) === false ||
            (int)$attributes['index_mode'] === MediaLibraryHandler::MODE_USER
        ) {
            $userId = auth()->user()->getId();
            $query = $query->where('user_id', $userId);
        }

        if (isset($attributes['folder_id']) === true) {
            $query = $query->where('folder_id', $attributes['folder_id']);
        }

        if (isset($attributes['startDate']) === true) {
            $startDate = date('Y-m-d', strtotime($attributes['startDate']));

            $query = $query->where('updated_at', '>=', $startDate);
        }

        if (isset($attributes['endDate']) === true) {
            $endDate = date('Y-m-d', strtotime($attributes['endDate']));

            $query = $query->where('updated_at', '<=', $endDate);
        }

        if (isset($attributes['keyword']) === true) {
            $keyword = $attributes['keyword'];

            if (isset($attributes['target']) === false) {
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

        if (isset($attributes['mime']) === true) {
            $query = $query->whereHas('file', function ($query) use ($attributes) {
                $query->where(function ($query) use ($attributes) {
                    foreach($attributes['mime'] as $attr) {
                        $query->orWhere('mime', 'like', $attr);
                    }
                });
            });
        }

        return $query;
    }

    /**
     * @param Model $query      model
     * @param array $attributes attribute
     *
     * @return mixed
     */
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

            case self::ORDER_TYPE_FILE_SIZE_DESC:
                $query = $query->with('file')->join('files', 'files.id', '=', 'media_library_files.file_id')
                    ->orderBy('files.size', 'desc');
                break;

            case self::ORDER_TYPE_USER_NAME_ASC:
                $query = $query->with('user')->join('user', 'user.id', '=', 'media_library_files.user_id')
                    ->orderBy('display_name', 'asc');
                break;
        }

        return $query;
    }

    /**
     * @param Model $query      model
     * @param array $attributes attribute
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function getPaginate($query, $attributes)
    {
        $perPageCount = 50;
        if (isset($attributes['per_page']) == true) {
            $perPageCount = $attributes['per_page'];
        }

        $items = $query->paginate($perPageCount, ['*'], 'file_page')->appends(array_forget($attributes, 'file_page'));

        return $items;
    }

    /**
     * @param Model $fileItem file item
     *
     * @return void
     */
    public function setCommonFileVisible($fileItem)
    {
        if ($fileItem->user != null) {
            $fileItem->user->setAttribute('profile_image_url', $fileItem->user->getProfileImage());
            $fileItem->user->addVisible(['profile_image_url']);
        }

        if (!empty($fileItem->file)) {
            if (\XeMedia::is($fileItem->file) == true) {
                $media = \XeMedia::getHandlerByFile($fileItem->file)->make($fileItem->file);

                $fileItem->file->setAttribute('url', $fileItem->file->url());
                $fileItem->file->setAttribute('width', $media['meta']['width']);
                $fileItem->file->setAttribute('height', $media['meta']['height']);
            }

            $fileItem->file->setAttribute('download_url', route('media_library.download_file', ['file_id' => $fileItem->id]));
            $fileItem->file->addVisible(['path', 'filename', 'url', 'download_url', 'width', 'height']);
        }
    }

    /**
     * @param Model $mediaLibraryFileItem item
     *
     * @return void
     * @throws \Exception
     */
    public function delete(Model $mediaLibraryFileItem)
    {
        \XeDB::beginTransaction();

        try {
            $file = $mediaLibraryFileItem->file;

            \XeStorage::unbind($mediaLibraryFileItem->id, $file, true);
            if ($originFile = $mediaLibraryFileItem->originFile) {
                \XeStorage::unBind($mediaLibraryFileItem->id, $originFile, true);
            }

            $this->traitDelete($mediaLibraryFileItem);
        } catch (\Exception $e) {
            \XeDB::rollback();

            throw $e;
        }

        \XeDB::commit();
    }
}

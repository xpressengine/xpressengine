<?php
/**
 * MediaLibraryFolderRepository.php
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
use Xpressengine\Http\Request;
use Xpressengine\MediaLibrary\Exceptions\NotExistRootFolderException;
use Xpressengine\Support\EloquentRepositoryTrait;

/**
 * Class MediaLibraryFolderRepository
 *
 * @category    MediaLibrary
 * @package     Xpressengine\MediaLibrary
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaLibraryFolderRepository
{
    use EloquentRepositoryTrait {
        update as traitUpdate;
    }

    /**
     * @param array $attribute attribute
     *
     * @return Model
     */
    public function storeItem($attribute)
    {
        $folderItem = $this->createModel();
        $folderItem->fill($attribute);
        $folderItem->save();

        $generateName = $this->getGenerateName($folderItem);
        if ($folderItem->name != $generateName) {
            $folderItem->name = $generateName;
            $folderItem->save();
        }

        return $folderItem;
    }

    /**
     * @param Model $item item
     * @param array $data data
     *
     * @return Model
     */
    public function update(Model $item, array $data = [])
    {
        $this->traitUpdate($item, $data);

        $data['name'] = $this->getGenerateName($item);
        if ($item->name != $data['name']) {
            $this->traitUpdate($item, $data);
        }

        return $item;
    }

    /**
     * @param Model $folderItem item
     *
     * @return string
     */
    public function getGenerateName($folderItem)
    {
        if ($this->query()->where(
            [
                ['id', '<>', $folderItem->id],
                ['parent_id', $folderItem->parent_id],
                ['name', $folderItem->name]
            ]
        )->exists() == false) {
            return $folderItem->name;
        }

        $increment = 0;
        while ($this->checkExistName($folderItem, $increment) == true) {
            ++$increment;
        }

        return $this->attachNameIncrement($folderItem->name, $increment);
    }

    /**
     * @param Model $folderItem item
     * @param int   $increment  increment count
     *
     * @return bool
     */
    private function checkExistName($folderItem, $increment)
    {
        return $this->query()->where(
            [
                ['id', '<>', $folderItem->id],
                ['parent_id', $folderItem->parent_id],
                ['name', $this->attachNameIncrement($folderItem->name, $increment)]
            ]
        )->exists();
    }

    /**
     * @param string $name      name
     * @param int    $increment increment count
     *
     * @return string
     */
    private function attachNameIncrement($name, $increment)
    {
        if ($increment > 0) {
            $name .= ' (' . $increment . ')';
        }

        return $name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null
     */
    public function getRootFolderItem()
    {
        $rootFolderItem = $this->query()->where([['parent_id', ''], ['name', '/']])->first();

        if ($rootFolderItem == null) {
            throw new NotExistRootFolderException();
        }

        return $rootFolderItem;
    }

    /**
     * @param Request $request request
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getFolderItems(Request $request)
    {
        $query = $this->query();

        if ($name = $request->get('keyword')) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        return $query->get();
    }
}

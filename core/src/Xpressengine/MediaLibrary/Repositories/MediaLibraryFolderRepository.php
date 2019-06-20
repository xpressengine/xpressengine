<?php

namespace Xpressengine\MediaLibrary\Repositories;

use Illuminate\Database\Eloquent\Model;
use Xpressengine\Http\Request;
use Xpressengine\MediaLibrary\Exceptions\NotExistRootFolderException;
use Xpressengine\Support\EloquentRepositoryTrait;

class MediaLibraryFolderRepository
{
    use EloquentRepositoryTrait {
        update as traitUpdate;
    }

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

    public function update(Model $item, array $data = [])
    {
        $this->traitUpdate($item, $data);

        $data['name'] = $this->getGenerateName($item);
        if ($item->name != $data['name']) {
            $this->traitUpdate($item, $data);
        }

        return $item;
    }

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

    private function attachNameIncrement($name, $increment)
    {
        if ($increment > 0) {
            $name .= ' (' . $increment . ')';
        }

        return $name;
    }

    public function getRootFolderItem()
    {
        $rootFolderItem = $this->query()->where([['parent_id', ''], ['name', '/']])->first();

        if ($rootFolderItem == null) {
            throw new NotExistRootFolderException();
        }

        return $rootFolderItem;
    }

    public function getFolderItems(Request $request)
    {
        $query = $this->query();

        if ($name = $request->get('keyword')) {
            $query = $query->where('name', 'like', '%' . $name . '%');
        }

        return $query->get();
    }
}

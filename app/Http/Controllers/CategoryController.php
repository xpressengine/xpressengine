<?php
namespace App\Http\Controllers;

use Input;
use DB;
use Exception;
use Presenter;
use Xpressengine\Category\CategoryHandler;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;

class CategoryController extends Controller
{
    // 별도로 전체를 관리하는 페이지는 없음
    // 게시판등에서 개별적으로 생성요청한 후 수정가능한 페이지로 접근
    public function show(CategoryHandler $handler, $id)
    {
        $category = $handler->get($id);

        if ($category === null) {
            throw new InvalidArgumentHttpException;
        }

        return Presenter::make('category.show', compact('category'));
    }

    public function storeItem(CategoryHandler $handler, $categoryId)
    {
        $category = $handler->get($categoryId);

        $inputs = Input::except('_token');

        $parent = null;
        if (isset($inputs['parentId'])) {
            if (empty($inputs['parentId']) === false) {
                $parent = $handler->getItem($inputs['parentId']);
            }

            unset($inputs['parentId']);
        }

        DB::beginTransaction();

        try {
            $item = $handler->createItem($category, $inputs, $parent);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();

        return Presenter::makeApi($item->toArray());
    }

    public function updateItem(CategoryHandler $handler, $categoryId)
    {
        $id = Input::get('id');
        $inputs = Input::except(['id', '_token']);

        if ($id === null || !$item = $handler->getItem($id)) {
            throw new InvalidArgumentHttpException;
        }

        foreach ($inputs as $key => $val) {
            $item->{$key} = $val;
        }

        $item = $handler->putItem($item);

        return Presenter::makeApi($item->toArray());
    }

    public function destroyItem(CategoryHandler $handler, $categoryId)
    {
        $id = Input::get('id');

        if ($id === null || !$item = $handler->getItem($id)) {
            throw new InvalidArgumentHttpException;
        }

        DB::beginTransaction();

        try {
            $handler->removeItem($item);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();

    }

    public function moveItem(CategoryHandler $handler, $categoryId)
    {
        $id = Input::get('id');
        $parentId = Input::get('parentId');
        $ordering = Input::get('ordering');

        if ($id === null || !$item = $handler->getItem($id)) {
            throw new InvalidArgumentHttpException;
        }

        $parent = empty($parentId) === false ? $handler->getItem($parentId) : null;

        DB::beginTransaction();

        try {
            $handler->moveTo($item, $parent);
            $handler->setOrder($item, $ordering);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();
    }

    public function children(CategoryHandler $handler, $categoryId)
    {
        $parentId = Input::get('id');

        if ($parentId === null) {
            $category = $handler->get($categoryId);
            $children = $handler->progenitors($category);
        } else {
            if (!$parent = $handler->getItem($parentId)) {
                throw new InvalidArgumentHttpException;
            }

            $children = $handler->children($parent);
        }

        return Presenter::makeApi($children);
    }
}

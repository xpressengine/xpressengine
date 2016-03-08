<?php
namespace App\Http\Controllers;

use DB;
use Exception;
use XePresenter;
use XeCategory;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Http\Request;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;

class CategoryController extends Controller
{
    public function show($id)
    {
        $category = Category::find($id);

        if ($category === null) {
            throw new InvalidArgumentHttpException;
        }

        return XePresenter::make('category.show', compact('category'));
    }

    public function storeItem(Request $request, $id)
    {
        /** @var Category $category */
        $category = Category::find($id);

        DB::beginTransaction();

        try {
            /** @var CategoryItem $item */
            $item = XeCategory::createItem($category, $request->all());
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();

        return XePresenter::makeApi($item->toArray());
    }

    public function updateItem(Request $request, $id)
    {
        /** @var CategoryItem $item */
        if (!$item = CategoryItem::find($request->get('id'))) {
            throw new InvalidArgumentHttpException;
        }

        foreach ($request->all() as $key => $val) {
            $item->{$key} = $val;
        }

        XeCategory::putItem($item);

        return XePresenter::makeApi($item->toArray());
    }

    public function destroyItem(Request $request, $id)
    {
        /** @var CategoryItem $item */
        if (!$item = CategoryItem::find($request->get('id'))) {
            throw new InvalidArgumentHttpException;
        }

        DB::beginTransaction();

        try {
            XeCategory::removeItem($item);

        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();
    }

    public function moveItem(Request $request, $id)
    {
        /** @var CategoryItem $item */
        if (!$item = CategoryItem::find($request->get('id'))) {
            throw new InvalidArgumentHttpException;
        }

        $parent = CategoryItem::find($request->get('parentId'));

        DB::beginTransaction();

        try {
            XeCategory::moveTo($item, $request->get('ordering', 0), $parent);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();
    }

    public function children(Request $request, $id)
    {
        if ($request->get('id') === null) {
            $children = Category::find($id)->getProgenitors();
        } else {
            /** @var CategoryItem $item */
            if (!$item = CategoryItem::find($request->get('id'))) {
                throw new InvalidArgumentHttpException;
            }

            $children = $item->getChildren();
        }

        return XePresenter::makeApi($children->toArray());
    }
}

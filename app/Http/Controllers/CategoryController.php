<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use DB;
use Exception;
use XePresenter;
use XeCategory;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Http\Request;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;
use Xpressengine\Translation\Translator;

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

    public function storeItem(Translator $translator, Request $request, $id)
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

        $multiLang = $translator->getPreprocessorValues($request->all(), session()->get('locale'));
        $item->readableWord = $multiLang['word'];

        return XePresenter::makeApi($item->toArray());
    }

    public function updateItem(Translator $translator, Request $request, $id)
    {
        /** @var CategoryItem $item */
        if (!$item = CategoryItem::find($request->get('id'))) {
            throw new InvalidArgumentHttpException;
        }

        $item->fill($request->all());

        XeCategory::putItem($item);

        $multiLang = $translator->getPreprocessorValues($request->all(), session()->get('locale'));
        $item->readableWord = $multiLang['word'];

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
            $item = XeCategory::moveTo($item, $parent);
            XeCategory::setOrder($item, $request->get('ordering', 0));
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

        foreach ($children as $child) {
            $child->readableWord = xe_trans($child->word);
        }

        return XePresenter::makeApi($children->toArray());
    }
}

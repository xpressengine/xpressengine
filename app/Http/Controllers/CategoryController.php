<?php
/**
 * CategoryController.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use DB;
use Exception;
use XeLang;
use XePresenter;
use XeCategory;
use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\Http\Request;
use Xpressengine\Support\Caster;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;

/**
 * Class CategoryController
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CategoryController extends Controller
{
    /**
     * Show category.
     *
     * @param string $id identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function show($id)
    {
        $category = XeCategory::cates()->find($id);

        if ($category === null) {
            throw new InvalidArgumentHttpException;
        }

        return XePresenter::make('category.show', compact('category'));
    }

    /**
     * Store a item of the category.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function storeItem(Request $request, $id)
    {
        /** @var Category $category */
        $category = XeCategory::cates()->find($id);

        DB::beginTransaction();

        try {
            /** @var CategoryItem $item */
            $item = XeCategory::createItem($category, $request->all());
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();

        $multiLang = XeLang::getPreprocessorValues($request->all(), session()->get('locale'));
        $item->readableWord = $multiLang['word'];

        return XePresenter::makeApi($item->toArray());
    }

    /**
     * Update a item of the category.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function updateItem(Request $request, $id)
    {
        /** @var CategoryItem $item */
        $item = XeCategory::items()->find($request->get('id'));
        if (!$item || $item->category->id !== Caster::cast($id)) {
            throw new InvalidArgumentHttpException;
        }

        XeCategory::updateItem($item, $request->all());

        $multiLang = XeLang::getPreprocessorValues($request->all(), session()->get('locale'));
        $item->readableWord = $multiLang['word'];

        return XePresenter::makeApi($item->toArray());
    }

    /**
     * Delete a item of the category.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @param bool    $force   하위카테고리 삭제 유무(true=>하위카테고리까지 삭제)
     * @return \Xpressengine\Presenter\Presentable
     * @throws Exception
     */
    public function destroyItem(Request $request, $id, $force = false)
    {
        /** @var CategoryItem $item */
        $item = XeCategory::items()->find($request->get('id'));
        if (!$item || $item->category->id !== Caster::cast($id)) {
            throw new InvalidArgumentHttpException;
        }

        DB::beginTransaction();

        try {
            XeCategory::deleteItem($item, $force);
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
        DB::commit();

        return XePresenter::makeApi([]);
    }

    /**
     * Move item to another position.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @return void
     * @throws Exception
     */
    public function moveItem(Request $request, $id)
    {
        /** @var CategoryItem $item */
        $item = XeCategory::items()->find($request->get('id'));
        if (!$item || $item->category->id !== Caster::cast($id)) {
            throw new InvalidArgumentHttpException;
        }

        $parent = XeCategory::items()->find($request->get('parent_id'));

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

    /**
     * Get children of a item.
     *
     * @param Request $request request
     * @param string  $id      identifier
     * @return \Xpressengine\Presenter\Presentable
     */
    public function children(Request $request, $id)
    {
        if ($request->get('id') === null) {
            $children = XeCategory::cates()->find($id)->getProgenitors();
        } else {
            /** @var CategoryItem $item */
            $item = XeCategory::items()->find($request->get('id'));
            if (!$item || $item->category->id !== Caster::cast($id)) {
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

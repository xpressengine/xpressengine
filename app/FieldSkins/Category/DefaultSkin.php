<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Category;

use Xpressengine\Category\Models\Category;
use Xpressengine\Category\Models\CategoryItem;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Config\ConfigEntity;
use View;
use XeCategory;

class DefaultSkin extends AbstractSkin
{
    protected static $id = 'FieldType/xpressengine@Category/FieldSkin/xpressengine@default';

    protected $name = 'category1 default';
    protected $description = '카테고리1의 기본 스킨';

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 정의
     *
     * @return void
     */
    public function setSettingsRules()
    {
        // TODO: Implement setSettingsRules() method.
    }

    /**
     * @param ConfigEntity|null $config
     * @param string $view
     * @return mixed
     */
    public function settings(ConfigEntity $config = null, $view = 'dynamicField/category/default/createSkin')
    {
        return View::make($view, ['config' => $config,])->render();
    }

    /**
     * @param array $inputs
     * @param string $view
     * @return mixed
     */
    public function create(array $inputs, $view = 'dynamicField/category/default/create')
    {
        $config = $this->config;
        $category = Category::find($config->get('categoryId'));
        $items = $category->items;

        return View::make($view, [
            'config' => $config,
            'items' => $items,
        ])->render();
    }

    /**
     * @param array $args
     * @param string $view
     * @return mixed
     */
    public function edit(array $args, $view = 'dynamicField/category/default/edit')
    {
        $config = $this->config;
        $category = Category::find($config->get('categoryId'));
        $items = $category->items;

        $itemId = '';
        $item = '';
        if (isset($args[$config->get('id') . 'ItemId'])) {
            $itemId = $args[$config->get('id') . 'ItemId'];
            $item = CategoryItem::find($itemId);
        }

        return View::make($view, [
            'config' => $config,
            'items' => $items,
            'itemId' => $itemId,
            'item' => $item,
        ])->render();
    }

    /**
     * @param array $args
     * @param string $view
     * @return mixed
     */
    public function show(array $args, $view = 'dynamicField/category/default/show')
    {
        $config = $this->config;
        $item = '';
        if (isset($args[$config->get('id') . 'ItemId'])) {
            $itemId = $args[$config->get('id') . 'ItemId'];
            $item = CategoryItem::find($itemId);
        }

        return View::make($view, [
            'config' => $config,
            'item' => $item,
        ])->render();
    }

    /**
     * get search
     *
     * @param array $inputs
     * @param string $view
     * @return string
     */
    public function search(array $inputs, $view = 'dynamicField/category/default/search')
    {
        $config = $this->config;
        if ($config->get('searchable') !== true) {
            return '';
        }

        $category = Category::find($config->get('categoryId'));
        $items = $category->items;

        $key = $config->get('id').'ItemId';

        $itemId = '';
        $item = '';
        if (isset($inputs[$key])) {
            $itemId = $inputs[$key];
            $item = CategoryItem::find($itemId);
        }

        return View::make($view, [
            'config' => $config,
            'items' => $items,
            'itemId' => $itemId,
            'item' => $item,
        ])->render();
    }

    /**
     * @param string $name
     * @param array $args
     */
    public function output($name, array $args)
    {
        $key = $name.'ItemId';
        if (isset($args[$key]) === false || $args[$key] == '') {
            return null;
        }

        return xe_trans(CategoryItem::find($args[$key])->word);
    }

    public static function getSettingsURI()
    {
    }

    public function getSettingRules()
    {
        return [
            'colorSet' => 'Required',
        ];
    }
}

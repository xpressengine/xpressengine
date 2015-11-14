<?php
namespace Xpressengine\FieldSkins\Category;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Category;
use View;

class AfterTitle extends AbstractSkin
{

    protected static $id = 'FieldType/xpressengine@Category/FieldSkin/xpressengine@afterTitle';
    protected $name = 'After title skin';
    protected $description = 'After title 스킨';

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 정의
     *
     * @return void
     */
    public function setSettingsRules()
    {
        // TODO: Implement setSettingsRules() method.
    }

    public function settings(ConfigEntity $config = null)
    {
        return View::make('dynamicField/category/afterTitle/createSkin', ['config' => $config,])->render();
    }

    public function create(array $inputs)
    {
        $config = $this->config;
        $category = Category::get($config->get('categoryId'));
        $items = Category::progenitors($category);

        return View::make('dynamicField/category/afterTitle/create', [
            'config' => $config,
            'items' => $items,
        ])->render();
    }

    public function edit(array $args)
    {
        $config = $this->config;
        $category = Category::get($config->get('categoryId'));
        $items = Category::progenitors($category);

        $itemId = '';
        if (isset($args[$config->get('id') . 'ItemId'])) {
            $itemId = $args[$config->get('id') . 'ItemId'];
        }

        return View::make('dynamicField/category/afterTitle/edit', [
            'config' => $config,
            'items' => $items,
            'itemId' => $itemId,
        ])->render();
    }

    public function show(array $args)
    {
        $config = $this->config;
        $item = '';
        if (isset($args[$config->get('id') . 'ItemId'])) {
            $itemId = $args[$config->get('id') . 'ItemId'];
            $item = Category::getItem($itemId);
        }

        return View::make('dynamicField/category/afterTitle/show', [
            'config' => $config,
            'item' => $item,
        ])->render();
    }

    public function search(array $inputs)
    {
        $config = $this->config;
        if ($config->get('searchable') !== true) {
            return '';
        }

        $category = Category::get($config->get('categoryId'));
        $items = Category::progenitors($category);

        $key = $config->get('id').'ItemId';
        $itemId = isset($inputs[$key]) ? $inputs[$key] : '';

        return View::make('dynamicField/category/afterTitle/search', [
            'config' => $config,
            'items' => $items,
            'itemId' => $itemId,
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

        return Category::getItem($args[$key])->word;
    }

    public static function getSettingsURI()
    {
    }
}


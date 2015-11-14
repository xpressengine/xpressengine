<?php
namespace Xpressengine\FieldSkins\Category;

use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\Config\ConfigEntity;
use Category;
use View;

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
        $category = Category::get($config->get('categoryId'));
        $items = Category::progenitors($category);

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
        $category = Category::get($config->get('categoryId'));
        $items = Category::progenitors($category);

        $itemId = '';
        $item = '';
        if (isset($args[$config->get('id') . 'ItemId'])) {
            $itemId = $args[$config->get('id') . 'ItemId'];
            $item = Category::getItem($itemId);
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
            $item = Category::getItem($itemId);
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

        $category = Category::get($config->get('categoryId'));
        $items = Category::progenitors($category);

        $key = $config->get('id').'ItemId';

        $itemId = '';
        $item = '';
        if (isset($inputs[$key])) {
            $itemId = $inputs[$key];
            $item = Category::getItem($itemId);
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

        return Category::getItem($args[$key])->word;
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

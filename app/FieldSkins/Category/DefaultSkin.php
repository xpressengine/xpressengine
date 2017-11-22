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

class DefaultSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Category/fieldSkin/xpressengine@default';

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Category1 default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/category/default';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }


    /**
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        if ($this->config->get('category_id') == null && $this->config->get('categoryId') != null) {
            $this->config->set('category_id', $this->config->get('categoryId'));
        }

        $category = Category::find($this->config->get('category_id'));
        $this->addMergeData(['categoryItems' => $category->items]);

        return parent::create($args);
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        if ($this->config->get('category_id') == null && $this->config->get('categoryId') != null) {
            $this->config->set('category_id', $this->config->get('categoryId'));
        }

        $category = Category::find($this->config->get('category_id'));

        $item = null;
        if (isset($args[$this->config->get('id') . 'ItemId'])) {
            $item = CategoryItem::itemFind($args[$this->config->get('id') . 'ItemId']);
        }

        $this->addMergeData([
            'categoryItems' => $category->items,
            'categoryItem' => $item,
        ]);

        return parent::edit($args);
    }

    /**
     * 조회할 때 사용 될 html 코드 반환
     * return html tag string
     *
     * @param array $args      arguments
     * @return \Illuminate\View\View
     */
    public function show(array $args)
    {
        $item = null;
        if (isset($args[$this->config->get('id') . 'ItemId'])) {
            $item = CategoryItem::itemFind($args[$this->config->get('id') . 'ItemId']);
        }

        $this->addMergeData([
            'categoryItem' => $item,
        ]);

        return parent::show($args);
    }

    /**
     * 리스트에서 검색할 때 검색 form 에 사용될 html 코드 반환
     * return html tag string
     *
     * @param array $args      arguments
     * @return string
     */
    public function search(array $args)
    {
        if ($this->config->get('category_id') == null && $this->config->get('categoryId') != null) {
            $this->config->set('category_id', $this->config->get('categoryId'));
        }

        $category = Category::find($this->config->get('category_id'));

        $item = null;

        if (isset($args[$this->config->get('id') . 'ItemId'])) {
            $item = CategoryItem::itemFind($args[$this->config->get('id') . 'ItemId']);
        }

        $this->addMergeData([
            'categoryItems' => $category->items,
            'categoryItem' => $item,
        ]);

        return parent::search($args);
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

        return xe_trans(CategoryItem::itemFind($args[$key])->word);
    }

}

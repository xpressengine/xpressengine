<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace App\FieldTypes;

use Xpressengine\Database\DynamicQuery;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\Config\ConfigEntity;
use Illuminate\Database\Query\Builder;
use Xpressengine\Category\Models\Category as CategoryModel;
use App\FieldSkins\Category\AfterTitle;
use App\FieldSkins\Category\BeforeTitle;
use App\FieldSkins\Category\DefaultSkin;
use XeFrontend;
use View;

/**
 * Class FieldType
 * @package App\FieldTypes\Category
 */
class Category extends AbstractType
{
    /**
     * @var string
     */
    protected static $id = 'fieldType/xpressengine@Category';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Category';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '1차 카테고리를 생성합니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'itemId' => (new ColumnEntity('itemId', ColumnDataType::STRING))->setParams([255]),
        ];
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        return ['itemId' => 'required'];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return ['categoryId' => 'required'];
    }

    /**
     * Dynamic Field 설정 페이지에서 각 fieldType 에 필요한 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getSettingsView(ConfigEntity $config = null)
    {
        $category = null;
        if ($config != null) {
            $category = CategoryModel::find($config->get('categoryId'));
        }

        XeFrontend::rule('dynamicFieldSection', $this->getSettingsRules());

        return View::make('dynamicField/category/createType', [
            'config' => $config,
            'category' => $category,
        ])->render();
    }
}

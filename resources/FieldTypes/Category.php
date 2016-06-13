<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\FieldTypes;

use Xpressengine\Database\DynamicQuery;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\Config\ConfigEntity;
use Illuminate\Database\Query\Builder;
use Xpressengine\Category\Models\Category as CategoryModel;
use Xpressengine\FieldSkins\Category\AfterTitle;
use Xpressengine\FieldSkins\Category\BeforeTitle;
use Xpressengine\FieldSkins\Category\DefaultSkin;
use XeFrontend;
use View;

/**
 * Class FieldType
 * @package Xpressengine\FieldTypes\Category
 */
class Category extends AbstractType
{
    /**
     * @var string
     */
    protected static $id = 'FieldType/xpressengine@Category';

    // 네임스페이스 이름..
    protected $name = 'Category';
    protected $description = '1차 카테고리를 생성합니다.';

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        app('xe.pluginRegister')->add(DefaultSkin::class);
        DefaultSkin::boot();
    }

    /**
     * 스키마 구성을 위한 database column 설정
     *
     * @return void
     */
    public function setColumns()
    {
        $this->columns['itemId'] = (new ColumnEntity('itemId', ColumnDataType::STRING))->setParams([255]);
    }

    /**
     * 사용자 페이지 입력할 때 적용될 rule 정의
     *
     * @return void
     */
    public function setRules()
    {
        $this->rules = ['itemId' => 'required'];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 정의
     *
     * @return void
     */
    public function setSettingsRules()
    {
        $this->settingsRules = ['categoryId' => 'required'];
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

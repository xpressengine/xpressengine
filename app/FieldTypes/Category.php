<?php
/**
 * Category.php
 *
 * PHP version 7
 *
 * @category    FieldTypes
 * @package     App\FieldTypes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\FieldTypes;

use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Category\Models\Category as CategoryModel;
use XeFrontend;
use View;

/**
 * Class Category
 *
 * @category    FieldTypes
 * @package     App\FieldTypes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
        return 'Category - 카테고리';
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
            'item_id' => (new ColumnEntity('item_id', ColumnDataType::STRING))->setParams([255]),
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return ['category_id' => 'required'];
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
            // for support version beta.26 before
            if ($config->get('category_id') == null && $config->get('categoryId') != null) {
                $config->set('category_id', $config->get('categoryId'));
            }
            $category = CategoryModel::find($config->get('category_id'));
        }

        XeFrontend::rule('dynamicFieldSection', $this->getSettingsRules());

        return View::make('dynamicField/category/createType', [
            'config' => $config,
            'category' => $category,
        ])->render();
    }
}

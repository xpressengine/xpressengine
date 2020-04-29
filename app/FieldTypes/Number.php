<?php
/**
 * Number.php
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
use XeRegister;
use Xpressengine\DynamicField\DynamicFieldHandler;
use App\FieldSkins\Number\DefaultSkin;
use View;

/**
 * Class Number
 *
 * @category    FieldTypes
 * @package     App\FieldTypes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Number extends AbstractType
{
    protected static $id = 'fieldType/xpressengine@Number';

    protected $rules = ['num' => 'numeric'];

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Number - 숫자';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '숫자를 등록합니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'num' => (new ColumnEntity('num', ColumnDataType::INTEGER)),
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
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
        return View::make('dynamicField/number/createType', ['config' => $config,])->render();
    }
}


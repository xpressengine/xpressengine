<?php
/**
 * CellPhoneNumber.php
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
use View;

/**
 * Class CellPhoneNumber
 *
 * @category    FieldTypes
 * @package     App\FieldTypes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CellPhoneNumber extends AbstractType
{
    /**
     * @var string
     */
    protected static $id = 'fieldType/xpressengine@CellPhoneNumber';

    protected $rules = ['cell_phone_number' => 'cell_phone'];

    /**
     * @var bool
     */
    protected static $loaded = false;

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Cell phone number - 휴대폰 번호';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '휴대폰 번호를 등록합니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'cell_phone_number' => (new ColumnEntity('cell_phone_number', ColumnDataType::STRING)),
        ];
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        if (static::$loaded === false) {
            static::$loaded = true;
            $this->registerValidator();
        }

        return parent::getRules();
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
        return View::make('dynamicField/cellPhoneNumber/createType', ['config' => $config,])->render();
    }

    /**
     * register phone number validator
     *
     * @return void
     */
    protected function registerValidator()
    {
        app('validator')->extend('cell_phone', function ($attribute, $value) {
            $value = str_replace(['-', ' '], '', $value);

            if (is_numeric($value) === false) {
                return false;
            }

            $len = strlen($value);
            if ($len != 10 && $len != 11) {
                return false;
            }

            $area = substr($value, 0, 3);
            $exchange = substr($value, 3, $len-7);
            $suffix = substr($value, -4);

            $areas = ['010', '011', '016', '017', '018', '019'];
            if (in_array($area, $areas) === false) {
                return false;
            }

            if (substr($exchange, 0, 1) == '0') {
                return false;
            }

            return true;
        }, xe_trans('xe::mngCellPhoneNumberValidate'));
    }
}

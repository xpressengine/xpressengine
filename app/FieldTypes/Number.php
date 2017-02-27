<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

class Number extends AbstractType
{
    protected static $id = 'fieldType/xpressengine@Number';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Number';
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
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        return ['num' => 'numeric'];
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


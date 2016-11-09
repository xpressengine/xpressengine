<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @see         https://ko.wikipedia.org/wiki/대한민국의_전화번호_체계
 */

namespace App\FieldTypes;

use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\Config\ConfigEntity;
use XeRegister;
use View;

class PhoneNumber extends AbstractType
{
    protected static $id = 'FieldType/xpressengine@PhoneNumber';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Phone Number';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '전화번호를 등록합니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'phoneNumber' => (new ColumnEntity('phoneNumber', ColumnDataType::STRING, 30)),
            'entities' => (new ColumnEntity('entities', ColumnDataType::TEXT)),
        ];
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        // register phoneNumber rule
        return ['phoneNumber' => 'phoneNumber'];
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
        return View::make('dynamicField/phoneNumber/createType', ['config' => $config,])->render();
    }
}


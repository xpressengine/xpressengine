<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\FieldTypes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;
use App\FieldSkins\Text\DefaultSkin;
use View;

class Email extends AbstractType
{
    protected static $id = 'fieldType/xpressengine@Email';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Email';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '이메일을 등록합니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'email' => (new ColumnEntity('email', ColumnDataType::STRING)),
        ];
    }

    /**
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        $required = '';
        if ($this->config->get('required') === true) {
            $required = '|required';
        }

        return ['email' => 'email' . $required];
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
        return View::make('dynamicField/email/createType', ['config' => $config])->render();
    }

}
<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @deprecated
 */

namespace Xpressengine\FieldTypes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\FieldSkins\Boolean\DefaultSkin;
use View;

class Boolean extends AbstractType
{
    protected static $id = 'FieldType/xpressengine@Boolean';

    // 네임스페이스 이름..
    protected $name = 'Boolean';
    protected $description = 'true or false 값을 등록합니다.';

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
        $this->columns['boolean'] = (new ColumnEntity('boolean', ColumnDataType::BOOLEAN));
    }

    /**
     * 사용자 페이지 입력할 때 적용될 rule 정의
     *
     * @return void
     */
    public function setRules()
    {
        //
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 정의
     *
     * @return void
     */
    public function setSettingsRules()
    {
        //
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
        return View::make('dynamicField/boolean/createType', ['config' => $config])->render();
    }
}
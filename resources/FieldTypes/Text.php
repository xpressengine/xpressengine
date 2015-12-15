<?php
namespace Xpressengine\FieldTypes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\FieldSkins\Text\DefaultSkin;
use View;

class Text extends AbstractType
{
    protected static $id = 'FieldType/xpressengine@Text';

    // 네임스페이스 이름..
    protected $name = 'Text';
    protected $description = '문자열을 등록합니다.';

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
        $this->columns['text'] = (new ColumnEntity('text', ColumnDataType::STRING));
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
        return View::make('dynamicField/text/createType', ['config' => $config])->render();
    }
}
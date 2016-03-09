<?php
namespace Xpressengine\FieldTypes;

use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnEntity;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\Config\ConfigEntity;
use XeRegister;
use Xpressengine\DynamicField\DynamicFieldHandler;
use Xpressengine\FieldSkins\Number\DefaultSkin;
use View;

class Number extends AbstractType
{
    protected static $id = 'FieldType/xpressengine@Number';

    // 네임스페이스 이름..
    protected $name = 'Number';
    protected $description = '숫자를 등록합니다.';

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
        $this->columns['num'] = (new ColumnEntity('num', ColumnDataType::INTEGER));
    }

    /**
     * 사용자 페이지 입력할 때 적용될 rule 정의
     *
     * @return void
     */
    public function setRules()
    {
        $this->rules = ['num' => 'digits'];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 정의
     *
     * @return void
     */
    public function setSettingsRules()
    {
        // TODO: Implement setSettingsRules() method.
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

    /**
     * @param array $args
     */
    public function insert(array $args)
    {
        $config = $this->config;
        $key = $config->get('dynamicFieldName').'Num';
        if (isset($args[$key]) && $args[$key] !== '') {
            // 숫자만 입력 가능 하요~
            if (is_numeric($args[$key]) === false) {
                throw new \Exception;
            }
        }

        parent::insert($args);
    }

    /**
     * @param ConfigEntity $config
     * @param DynamicFieldHandler $handler
     * @param array $args
     * @param array $wheres
     * @throws \Exception
     */
    public function update(array $args, array $wheres) {
        $config = $this->config;

        $key = $config->get('dynamicFieldName').'Num';
        if (isset($args[$key]) && $args[$key] !== '') {
            // 숫자만 입력 가능 하요~
            if (is_numeric($args[$key]) === false) {
                throw new \Exception;
            }
        }

        parent::update($args, $wheres);

    }

    public static function getSettingsURI()
    {

    }
}


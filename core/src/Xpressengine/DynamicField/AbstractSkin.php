<?php
/**
 * AbstractSkin
 *
 * PHP version 5
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Plugin\ComponentInterface;

/**
 * AbstractSkin
 *
 * * Type 에서 출력할 때 사용할 스킨 필요
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractSkin implements ComponentInterface
{

    use ComponentTrait;

    /**
     * @var DynamicFieldHandler
     */
    protected $handler;

    /**
     * skin name
     *
     * @var string
     */
    protected $name;

    /**
     * @var ConfigEntity
     */
    protected $config;

    /**
     * validation settings rules
     *
     * @var array
     */
    protected $settingsRules = [];

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 정의
     *
     * @return void
     */
    abstract public function setSettingsRules();

    /**
     * Dynamic Field 설정 페이지에서 skin 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return string
     */
    abstract public function settings(ConfigEntity $config = null);

    /**
     * 등록 form 에 추가될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    abstract public function create(array $inputs);

    /**
     * 수정 form 에 추가될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    abstract public function edit(array $inputs);

    /**
     * 조회 시 사용 될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    abstract public function show(array $inputs);

    /**
     * 리스트에서 검색 시 검색 form 에 사용될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    abstract public function search(array $inputs);

    /**
     * 데이터 출력
     *
     * @param string $name dynamic field name
     * @param array  $args 데이터
     * @return mixed
     */
    abstract public function output($name, array $args);

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
    }

    /**
     * create instance
     *
     * @param DynamicFieldHandler $handler dynamic field handler
     */
    public function __construct(DynamicFieldHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * get widget name
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * set config
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return void
     */
    public function setConfig(ConfigEntity $config)
    {
        $this->config = $config;
    }

    /**
     * Dynamic Field 에 데이터 입력
     *
     * @param array $args parameters
     * @return void
     */
    public function insert(array $args)
    {
    }

    /**
     * Dynamic Field 에 데이터 수정
     *
     * @param array $args   parameters
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function update(array $args, array $wheres)
    {
    }

    /**
     * Dynamic Field 에 데이터 삭제
     *
     * @param array $wheres \Illuminate\Database\Query\Builder's wheres attribute
     * @return void
     */
    public function delete(array $wheres)
    {
    }

    /**
     * get setting rules
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return $this->settingsRules;
    }
}

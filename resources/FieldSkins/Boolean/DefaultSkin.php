<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\FieldSkins\Boolean;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use View;

class DefaultSkin extends AbstractSkin
{
    protected static $id = 'FieldType/xpressengine@Boolean/FieldSkin/xpressengine@BooleanDefault';
    protected $name = 'Boolean default';
    protected $description = 'true or false 디폴트 스킨';
    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 정의
     *
     * @return void
     */
    public function setSettingsRules()
    {
        // TODO: Implement setSettingsRules() method.
    }

    /**
     * Dynamic Field 설정 페이지에서 skin 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config dynamic field config entity
     * @return string
     */
    public function settings(ConfigEntity $config = null)
    {
        return View::make('dynamicField/boolean/default/createSkin', ['config' => $config])->render();
    }

    /**
     * 등록 form 에 추가될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function create(array $inputs)
    {
        $config = $this->config;
        return View::make('dynamicField/boolean/default/create', [
            'config' => $config,
        ])->render();
    }

    /**
     * 수정 form 에 추가될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function edit(array $inputs)
    {
        $config = $this->config;
        $boolean = '';
        if (isset($args[$config->get('id') . 'Boolean'])) {
            $boolean = $args[$config->get('id') . 'Boolean'];
        }

        return View::make('dynamicField/boolean/default/edit', [
            'config' => $config,
            'boolean' => $boolean,
        ])->render();
    }

    /**
     * 조회 시 사용 될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function show(array $inputs)
    {
        $config = $this->config;
        $boolean = '';
        if (isset($args[$config->get('id') . 'Boolean'])) {
            $boolean = $args[$config->get('id') . 'Boolean'];
        }

        return View::make('dynamicField/boolean/default/show', [
            'config' => $config,
            'boolean' => $boolean,
        ])->render();
    }

    /**
     * 리스트에서 검색 시 검색 form 에 사용될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function search(array $inputs)
    {
        $config = $this->config;
        if ($config->get('searchable') !== true) {
            return '';
        }

        $key = $config->get('id').'Boolean';
        $boolean = isset($inputs[$key]) ? $inputs[$key] : '';

        return View::make('dynamicField/boolean/default/search', [
            'config' => $config,
            'boolean' => $boolean,
        ])->render();
    }

    /**
     * 데이터 출력
     *
     * @param string $name dynamic field name
     * @param array $args 데이터
     * @return mixed
     */
    public function output($name, array $args)
    {
        $key = $name.'Boolean';
        if (isset($args[$key]) === false || $args[$key] == '') {
            return null;
        }

        return $args[$key];
    }
}

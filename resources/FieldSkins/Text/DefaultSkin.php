<?php
namespace Xpressengine\FieldSkins\Text;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use View;

class DefaultSkin extends AbstractSkin
{
    protected static $id = 'FieldType/xpressengine@Text/FieldSkin/xpressengine@TextDefault';
    protected $name = 'Text default';
    protected $description = '문자열 디폴트 스킨';

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
        return View::make('dynamicField/text/default/createSkin', ['config' => $config])->render();
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
        return View::make('dynamicField/text/default/create', [
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
        $text = '';
        if (isset($args[$config->get('id') . 'Text'])) {
            $text = $args[$config->get('id') . 'Text'];
        }

        return View::make('dynamicField/text/default/edit', [
            'config' => $config,
            'text' => $text,
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
        $text = '';
        if (isset($args[$config->get('id') . 'Text'])) {
            $text = $args[$config->get('id') . 'Text'];
        }

        return View::make('dynamicField/text/default/show', [
            'config' => $config,
            'text' => $text,
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

        $key = $config->get('id').'Text';
        $text = isset($inputs[$key]) ? $inputs[$key] : '';

        return View::make('dynamicField/text/default/search', [
            'config' => $config,
            'text' => $text,
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
        $key = $name.'Text';
        if (isset($args[$key]) === false || $args[$key] == '') {
            return null;
        }

        return $args[$key];
    }
}
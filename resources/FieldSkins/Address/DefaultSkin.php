<?php
namespace Xpressengine\FieldSkins\Address;

use View;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\DynamicField\DynamicFieldHandler;

class DefaultSkin extends AbstractSkin
{
    protected static $loaded = false;

    protected static $id = 'FieldType/xpressengine@Address/FieldSkin/xpressengine@default';

    protected $name = 'Address default skin';
    protected $description = '';

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 정의
     *
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
    public function settings(ConfigEntity $config = null, $view = 'dynamicField/address/default/createSkin')
    {
        return View::make($view, ['config' => $config,])->render();
    }

    /**
     * 등록 form 에 추가될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function create(array $inputs, $view = 'dynamicField/address/default/create')
    {
        $loaded = self::$loaded;
        if (self::$loaded === false) {
            self::$loaded = true;
        }

        $config = $this->config;

        return View::make($view, [
            'config' => $config,
            'inputs' => $inputs,
            'loaded' => $loaded,
        ])->render();
    }

    /**
     * 수정 form 에 추가될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function edit(array $inputs, $view = 'dynamicField/address/default/edit')
    {
        $loaded = self::$loaded;
        if (self::$loaded === false) {
            self::$loaded = true;
        }

        $config = $this->config;
        
        return View::make($view, [
            'config' => $config,
            'inputs' => $inputs,
            'loaded' => $loaded,
        ])->render();
    }

    /**
     * 조회 시 사용 될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function show(array $inputs, $view = 'dynamicField/address/default/show')
    {
        $config = $this->config;

        // TODO: Implement show() method.
        return View::make($view, [
            'config' => $config,
            'inputs' => $inputs,
        ])->render();
    }

    /**
     * 리스트에서 검색 시 검색 form 에 사용될 html 코드 리턴
     * return html tag string
     *
     * @param array $inputs parameters
     * @return string
     */
    public function search(array $inputs, $view = 'dynamicField/address/default/search')
    {
        $config = $this->config;

        if ($config->get('searchable') !== true) {
            return '';
        }

        $current = '';
        if (isset($inputs[$config->get('id') . 'Address1'])) {
            $current = $inputs[$config->get('id') . 'Address1'];
        }

        return View::make($view, [
            'config' => $config,
            'inputs' => $inputs,
            'current' => $current,
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
        $config = $this->config;

        return sprintf(
            '%s %s',
            $args[$config->get('id') . 'Address1'],
            $args[$config->get('id') . 'Address2']
        );
    }
}

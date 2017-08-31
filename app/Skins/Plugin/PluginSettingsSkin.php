<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     App\Skins\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Skins\Plugin;

use Xpressengine\Skin\GenericSkin;

/**
 * @category    Plugin
 * @package     App\Skins\Plugin
 */
class PluginSettingsSkin extends GenericSkin
{

    protected static $id = 'plugins/settingsSkin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 플러그인 설정스킨',
        'description' => 'Xpressengine의 기본 플러그인 설정페이지 스킨입니다'
    ];

    /**
     * @var array
     */
    protected static $info = [];

    /**
     * @var string
     */
    protected static $path = 'plugin.skins.default';

    /**
     * @var string
     */
    protected static $viewDir = '';

    /**
     * 스킨을 출력한다.
     * 만약 view 이름과 동일한 메소드명이 존재하면 그 메소드를 호출한다.
     *
     * @return string
     */
    public function render()
    {
        $this->loadDefault();
        return parent::render();
    }

    protected function indexFetched()
    {
        return $this->index();
    }

    protected function indexSelfInstalled()
    {
        return $this->index();
    }

    /**
     * listView
     *
     * @return \Illuminate\View\View
     */
    protected function index()
    {
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load();
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load();
        app('xe.frontend')->js('assets/core/plugin/js/plugin-index.js')->before(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();

        return $this->renderBlade();
    }

    /**
     * listView
     *
     * @return \Illuminate\View\View
     */
    protected function show()
    {
        app('xe.frontend')->js([
           'assets/vendor/swiper2/idangerous.swiper.js',
           'assets/core/plugin/js/plugin.js'
        ])->appendTo('head')->load();
        app('xe.frontend')->css('assets/vendor/swiper2/idangerous.swiper.css')
            ->before('assets/core/settings/css/admin.css')->load();

        return $this->renderBlade();
    }

    protected function installIndex()
    {
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load();
        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-page.js')->load();
        app('xe.frontend')->js('assets/core/plugin/js/plugin-install.js')->before(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();
        return $this->renderBlade();
    }

    protected function loadDefault()
    {
        app('xe.frontend')->html('plugins.loadTooltip')->content("<script>
            $(function () {
              $('[data-toggle=tooltip]').tooltip()
            })
        </script>")->load();

        array_set($this->data, 'color', [
            'theme' => 'success',
            'skin' => 'info',
            'settingsSkin' => 'warning',
            'settingsTheme' => 'warning',
            'widget' => 'danger',
            'module' => 'danger',
            'uiobject' => 'primary',
            'editor' => 'primary',
            'editortool' => 'primary',
            'FieldType' => 'default',
            'FieldSkin' => 'default',
            'toggleMenu' => 'default',
        ]);
    }

}

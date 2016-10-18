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
     * listView
     *
     * @return \Illuminate\View\View
     */
    protected function index()
    {
        $this->loadDefault();

        app('xe.frontend')->js('assets/core/xe-ui-component/js/xe-form.js')->load();

        app('xe.frontend')->html('plugins.updateList')->content("
        <script>
            $(function (){
                $('.__xe_btn-show-update').click(function(){
                    $(this).toggleClass('btn-primary');
                    $('ul.list-plugin li.list-group-item.__xe_no-update').toggleClass('hidden');
                })
            });
        </script>")->load();

        return $this->renderBlade();
    }

    /**
     * listView
     *
     * @return \Illuminate\View\View
     */
    protected function show()
    {
        $this->loadDefault();

        app('xe.frontend')->js([
           'assets/vendor/swiper2/idangerous.swiper.js',
           'assets/core/plugin/js/plugin.js'
        ])->appendTo('head')->load();
        app('xe.frontend')->css('assets/vendor/swiper2/idangerous.swiper.css')
            ->before('assets/core/settings/css/admin.css')->load();

        return $this->renderBlade();
    }

    protected function loadDefault()
    {
        app('xe.frontend')->html('plugins.loadTooltip')->content("<script>
            $(function () {
              $('[data-toggle=tooltip]').tooltip()
            })
        </script>")->load();

        app('xe.frontend')->html('plugins.updatePlugin')->content("<script>
            $(function () {
              $('.__xe_btn-update-plugin').click(function(){
                var url = $(this).data('url');
                $.ajax({
                  type : 'put',
                  url : url,
                  dataType: 'json',
                  success : function (data) {
                    location.reload();
                  },
                  error : function(data) {
                    XE.toast(data.type, data.message);
                  }
                });
                return false;
              })
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
            'FieldType' => 'default',
            'FieldSkin' => 'default',
        ]);
    }

}

<?php
/**
 * DefaultSkin.php
 *
 * PHP version 7
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Address
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Address;

use View;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractSkin;
use Xpressengine\DynamicField\DynamicFieldHandler;
use XeFrontend;

/**
 * Class DefaultSkin
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Address
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DefaultSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Address/fieldSkin/xpressengine@default';

    protected static $loaded = false;

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Address default skin';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/address/default';
    }

    protected function appendScript()
    {
        XeFrontend::js([
            'https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js?autoload=false',
            asset('assets/core/dynamic_fields/address/address.js')
        ])->location('body.prepend')->loadAsync()->load();
    }

    /**
     * 등록 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function create(array $args)
    {
        if (self::$loaded === false) {
            self::$loaded = true;
            $this->appendScript();
        }

        return parent::create($args);
    }

    /**
     * 수정 form 에 추가될 html 코드 반환
     * return html tag string
     *
     * @param array $args parameters
     * @return \Illuminate\View\View
     */
    public function edit(array $args)
    {
        if (self::$loaded === false) {
            self::$loaded = true;
            $this->appendScript();
        }

        return parent::edit($args);
    }

    /**
     * 데이터 출력
     *
     * @param string $name dynamic field name
     * @param array  $args 데이터
     * @return mixed
     */
    public function output($name, array $args)
    {
        $config = $this->config;

        return sprintf(
            '%s %s',
            $args[$config->get('id') . '_address1'],
            $args[$config->get('id') . '_address2']
        );
    }
}

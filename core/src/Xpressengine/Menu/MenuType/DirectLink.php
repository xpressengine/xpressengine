<?php
/**
 * Class DirectLink
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Menu\MenuType;

use Xpressengine\Menu\AbstractModule;
use Xpressengine\Menu\Exceptions\InvalidArgumentException;
use Illuminate\Contracts\Validation\Factory as FactoryContract;

/**
 * DirectLink
 *
 * DirectLink Menu Type
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

class DirectLink extends AbstractModule
{

    /**
     * @var string $id id of menuType
     */
    public static $id = "module/xpressengine@directLink";

    public static $componentInfo = [
        'name' => 'Direct Link',
        'description' => 'user custom link',
        'screenshot' => [],
    ];

    /**
     * @var FactoryContract $validation FactoryContract instance
     */
    protected static $validation;

    /**
     * 생성 폼 처리
     * @return string
     */
    public function createMenuForm()
    {
        return '';
    }

    /**
     * 실제로 생성할 때 처리하는 영역. (저장) - insert
     *
     * @param string $instanceId     menu item unique id
     * @param array  $menuTypeParams for menu type handler to store param array
     * @param array  $itemParams     for menu to create item param array
     *
     * @return mixed
     *
     */
    public function storeMenu($instanceId, $menuTypeParams, $itemParams)
    {
        $this->checkValid($itemParams);
    }

    /**
     * 수정 폼
     *
     * @param string $instanceId menu item unique id
     *
     * @return mixed|string
     */
    public function editMenuForm($instanceId)
    {
        // nothing
        return '';
    }

    /**
     * 수정 처리 ( update )
     *
     * @param string $instanceId     menu item unique id
     * @param array  $menuTypeParams for menu type handler to update param array
     * @param array  $itemParams     for menu to create item param array
     *
     * @return mixed|void
     *
     */
    public function updateMenu($instanceId, $menuTypeParams, $itemParams)
    {
        $this->checkValid($itemParams);
    }

    /**
     * 삭제 처리 (delete)
     *
     * @param string $instanceId menu item unique id
     *
     * @return mixed|void
     */
    public function deleteMenu($instanceId)
    {
        // nothing
    }


    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        // nothing to do
    }

    /**
     * getSettingsURI
     *
     * @return null
     */
    public static function getSettingsURI()
    {
        return null;
    }

    /**
     * summary
     *
     * @param string $instanceId menu item unique id
     *
     * @return mixed
     */
    public function summary($instanceId)
    {
        return '이 메뉴는 특별하게 사용하는 테이블과 document 가 없습니다.';
    }

    /**
     * Return this module is route able or unable
     * isRouteAble
     *
     * @return bool
     */
    public static function isRouteAble()
    {
        return false;
    }

    /**
     * Return URL about module's detail setting
     * getInstanceSettingURI
     *
     * @param string $instanceId menu item unique id
     *
     * @return mixed
     */
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }

    /**
     * Get menu type's item object
     *
     * @param string $id item id of menu type
     * @return mixed
     */
    public function getTypeItem($id)
    {
        return null;
    }

    /**
     * Determine if the given parameters is valid
     *
     * @param array $params parameters
     * @return void
     */
    protected function checkValid($params)
    {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = static::$validation->make($params, ['url' => 'url']);

        if ($validator->fails()) {
            $e = new InvalidArgumentException();
            $e->setMessage($validator->errors()->first());

            throw $e;
        }
    }

    /**
     * Set validation factory
     *
     * @param FactoryContract $validation validation factory instance
     * @return void
     */
    public static function setValidation(FactoryContract $validation)
    {
        static::$validation = $validation;
    }

    /**
     * Return validation factory
     *
     * @return FactoryContract
     */
    public static function getValidation()
    {
        return static::$validation;
    }
}

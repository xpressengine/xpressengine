<?php
/**
 * ManageItem.php
 *
 * PHP version 7
 *
 * @category    ToggleMenus
 * @package     App\ToggleMenus\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\ToggleMenus\User;

/**
 * Class ManageItem
 *
 * @category    ToggleMenus
 * @package     App\ToggleMenus\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ManageItem extends UserToggleMenu
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'user/toggleMenu/xpressengine@manage';

    /**
     * The information for component
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => '회원정보관리',
        'description' => '회원의 관리 페이지로 이동합니다.'
    ];

    /**
     * Returns the text for the item.
     *
     * @return string
     */
    public function getText()
    {
        return '회원정보 관리';
    }

    /**
     * Returns the type of the item.
     *
     * @return string
     */
    public function getType()
    {
        return static::MENUTYPE_LINK;
    }

    /**
     * Returns the action of the item.
     *
     * @return string
     */
    public function getAction()
    {
        return route('settings.user.edit', ['id' => $this->identifier]);
    }

    /**
     * Returns the script of the item.
     *
     * @return string|null
     */
    public function getScript()
    {
        return null;
    }

    /**
     * Determine if this item allows to current user.
     *
     * @return bool
     */
    public function allows()
    {
        return auth()->user()->isAdmin();
    }
}

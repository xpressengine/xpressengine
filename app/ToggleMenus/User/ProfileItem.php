<?php
/**
 * ProfileItem.php
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
 * Class ProfileItem
 *
 * @category    ToggleMenus
 * @package     App\ToggleMenus\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ProfileItem extends UserToggleMenu
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'user/toggleMenu/xpressengine@profile';

    /**
     * The information for component
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => '프로필',
        'description' => '회원의 프로필 페이지로 이동합니다.'
    ];

    /**
     * Returns the text for the item.
     *
     * @return string
     */
    public function getText()
    {
        return '프로필보기';
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
        return route('user.profile', $this->identifier);
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
}

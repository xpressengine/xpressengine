<?php
/**
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Models;

use Illuminate\Database\Eloquent\Collection;
use Xpressengine\User\Exceptions\UnsupportedOperationForGuestOrUnknownException;
use Xpressengine\User\Rating;
use Xpressengine\User\UserInterface;

/**
 * 데이터베이스에서 회원정보를 찾을 수 없는 상태의 회원을 위한 객체 클래스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UnknownUser implements UserInterface
{
    /**
     * getDisplayName()메소드가 호출될 때, 반환될 이름
     *
     * @var string
     */
    protected static $name = '';

    /**
     * @var string getProfileImage() 메소드가 호출될 때, 반환될 프로필이미지의 주소
     */
    protected static $profileImage = '';

    protected $attributes;

    /**
     * UnknownUser constructor.
     *
     * @param array $attributes unknown user's initial information
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
    }

    /**
     * Get the unique identifier
     *
     * @return string
     */
    public function getId()
    {
        return array_get($this->attributes, 'id');
    }

    /**
     * Get DisplayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return array_get($this->attributes, 'display_name', self::$name);
    }

    /**
     * 회원등급을 반환한다.
     *
     * @return string
     */
    public function getRating()
    {
        return Rating::GUEST;
    }

    /**
     * Unknown 회원이 사용할 DisplayName을 지정한다.
     *
     * @param string $name name that represents the guest
     *
     * @return void
     */
    public static function setName($name)
    {
        self::$name = $name;
    }

    /**
     * Set a guest profile image
     *
     * @param string $img url of image that represents the guest
     *
     * @return void
     */
    public static function setDefaultProfileImage($img)
    {
        self::$profileImage = $img;
    }

    /**
     * Get profile image URL
     *
     * @return string
     */
    public function getProfileImage()
    {
        return asset(array_get($this->attributes, 'profileImage', static::$profileImage));
    }

    /**
     * Get groups a user belongs
     *
     * @return array
     */
    public function getGroups()
    {
        return [];
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return User::STATUS_DENIED;
    }

    /**
     * Get pending email
     *
     * @return null
     */
    public function getPendingEmail()
    {
        return null;
    }

    /**
     * 회원이 소유한 계정 중에 주어진 provider를 가진 계정을 반환한다.
     *
     * @param  string  $provider provider
     *
     * @return null
     */
    public function getAccountByProvider(string $provider)
    {
        return null;
    }

    /**
     * Finds whether user has super rating.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return false;
    }

    /**
     * Finds whether user has manager or super rating.
     *
     * @return boolean
     */
    public function isManager()
    {
        return false;
    }


    /**
     * add this user to groups
     *
     * @param mixed $groups groups
     *
     * @return static
     */
    public function joinGroups($groups)
    {
        $this->throwNotSupportedException();
    }

    /**
     * leave groups
     *
     * @param array $groups groups
     *
     * @return static
     */
    public function leaveGroups(array $groups)
    {
        $this->throwNotSupportedException();
    }

    /**
     * throw NotSupportedException
     *
     * @return void
     */
    private function throwNotSupportedException()
    {
        throw new UnsupportedOperationForGuestOrUnknownException();
    }

    /**
     * Get Terms a user agreed
     *
     * @return Collection
     */
    public function getAgreedTerms()
    {
        return new Collection();
    }
}

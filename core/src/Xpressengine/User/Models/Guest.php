<?php
/**
 * This file is guest member
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User\Models;

use Xpressengine\User\Exceptions\UnsupportedOperationByGuestMemberException;
use Xpressengine\User\Rating;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserInterface;

/**
 * 비로그인 상태의 회원 객체 클래스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Guest implements UserInterface
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

    /**
     * Get the unique identifier
     *
     * @return string
     */
    public function getId()
    {
    }

    /**
     * Get DisplayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return self::$name;
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
     * Guest 회원이 사용할 DisplayName을 지정한다.
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
        self::$profileImage= $img;
    }

    /**
     * Get profile image URL
     *
     * @return string
     */
    public function getProfileImage()
    {
        return asset(static::$profileImage);
    }

    /**
     * Get groups a member belongs
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
        return UserHandler::STATUS_ACTIVATED;
    }

    /**
     * Get the unique identifier for the member.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        $this->throwNotSupportedException();
    }

    /**
     * Get the password for the member.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        $this->throwNotSupportedException();
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        $this->throwNotSupportedException();
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value token value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->throwNotSupportedException();
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        $this->throwNotSupportedException();
    }

    /**
     * setEmailForPasswordReset() 메소드에서 반환할 email 정보를 지정한다.
     *
     * @param string $email 지정할 email주소
     *
     * @return void
     */
    public function setEmailForPasswordReset($email)
    {
        $this->throwNotSupportedException();
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
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
        throw new UnsupportedOperationByGuestMemberException();
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
     * @param string $provider provider
     *
     * @return AccountEntity
     */
    public function getAccountByProvider($provider)
    {
        return null;
    }

    /**
     * Finds whether member has super rating.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return false;
    }

    /**
     * Finds whether member has manager or super rating.
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
     * @param array $groups
     *
     * @return static
     */
    public function joinGroups(array $groups)
    {
        throw new UnsupportedOperationByGuestMemberException();
    }

    /**
     * leave groups
     *
     * @param array $groups
     *
     * @return static
     */
    public function leaveGroups(array $groups)
    {
        throw new UnsupportedOperationByGuestMemberException();
    }
}

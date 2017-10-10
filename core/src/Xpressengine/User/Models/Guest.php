<?php
/**
 * This file is guest user
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Models;

use Xpressengine\User\Exceptions\UnsupportedOperationForGuestOrUnknownException;
use Xpressengine\User\Rating;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserInterface;

/**
 * 비로그인 상태의 회원 객체 클래스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
        return null;
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
        self::$profileImage = $img;
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
        return UserHandler::STATUS_ACTIVATED;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return null;
    }

    /**
     * Get the password for the user.
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
        throw new UnsupportedOperationForGuestOrUnknownException();
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
     * 최종 로그인 시간을 기록한다.
     *
     * @param mixed $time 로그인 시간
     *
     * @return void
     */
    public function setLoginTime($time = null)
    {
        $this->throwNotSupportedException();
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return null;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string $token token for password reset
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->throwNotSupportedException();
    }
}

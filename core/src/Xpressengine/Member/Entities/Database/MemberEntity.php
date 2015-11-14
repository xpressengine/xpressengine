<?php
/**
 *  This file is part of the Xpressengine package.
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
namespace Xpressengine\Member\Entities\Database;

use Closure;
use Xpressengine\Member\Entities\Entity;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Entities\PendingMailEntityInterface;
use Xpressengine\Member\Rating;

/**
 * 회원 정보를 저장하는 클래스
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MemberEntity extends Entity implements MemberEntityInterface
{

    /**
     * @var string getDisplayName()메소드가 실행될 때 사용할 필드
     */
    public static $displayField = 'displayName';

    /**
     * @var \Closure 회원의 프로필 이미지 Resolver. 프로필 이미지 아이디에 해당하는 프로필 이미지 URL을 반환한다.
     */
    protected static $profileImageResolver;

    /**
     * @var string[] 회원 관련 정보
     */
    protected static $relationFields = ['groups', 'mails', 'pending_mails', 'accounts'];

    /**
     * @var string[] 비밀번호는 toArray시 출력되지 않게 한다.
     */
    protected $hidden = ['password'];

    /**
     * @var string 비밀번호 초기화 요청을 처리할 때, 입력된 이메일을 저장함
     */
    protected $emailForPasswordReset;

    /**
     * date 형식의 attribute의 key 리스트. 지정된 attribute는 출력될 때 Carbon 클래스의 object로 변환되어 출력된다.
     *
     * @var string[]
     */
    protected $dates = ['createdAt', 'updatedAt', 'passwordUpdatedAt'];

    /**
     * 생성자
     *
     * @param array $attributes 회원정보
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
    }

    /**
     * setProfileImageResolver
     *
     * @param Closure $callback 회원의 프로필 이미지를 처리하기 위한 resolver
     *
     * @return void
     */
    public static function setProfileImageResolver(Closure $callback)
    {
        static::$profileImageResolver = $callback;
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifier()
    {
        return $this->getAttribute('id');
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->getAttribute('password');
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->getAttribute($this->getRememberTokenName());
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value token
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->setAttribute($this->getRememberTokenName(), $value);
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'rememberToken';
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        // 만약 로그인시 사용된 이메일이 따로 지정돼 있을 경우 그 이메일을 사용한다.
        return isset($this->emailForPasswordReset) ? $this->emailForPasswordReset : $this->email;
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
        $this->emailForPasswordReset = $email;
    }

    /**
     * Get the unique identifier
     *
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * Get the name for display
     *
     * @return string
     */
    public function getDisplayName()
    {
        $field = static::$displayField;
        return $this->getAttribute($field);
    }

    /**
     * Get the rating of member
     *
     * @return string
     */
    public function getRating()
    {
        return $this->getAttribute('rating');
    }

    /**
     * Get the status of member
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getAttribute('status');
    }

    /**
     * Get profile image URL of member
     *
     * @return string
     */
    public function getProfileImage()
    {
        $resolver = static::$profileImageResolver;
        return $resolver($this->profileImageId);
    }

    /**
     * Get groups a user belongs
     *
     * @return array
     */
    public function getGroups()
    {
        return $this->getAttribute('groups') ?: [];
    }

    /**
     * Get Pending Email of current member
     *
     * @return PendingMailEntityInterface
     */
    public function getPendingEmail()
    {
        $mails = $this->getAttribute('pending_mails');
        if ($mails === null) {
            return null;
        }
        if (is_array($mails) && !empty($mails)) {
            return reset($mails);
        }
    }

    /**
     * 회원이 소유한 계정중에 주어진 provider를 가진 계정을 반환한다.
     *
     * @param string $provider provider
     *
     * @return AccountEntity
     */
    public function getAccountByProvider($provider)
    {
        foreach ($this->accounts as $account) {
            if ($account->provider === $provider) {
                return $account;
            }
        }

        return null;
    }

    /**
     * Finds whether member has super rating.
     *
     * @return boolean
     */
    public function isSuperAdmin()
    {
        return $this->getRating() === Rating::SUPER;
    }

    /**
     * Finds whether member has manager or super rating.
     *
     * @return boolean
     */
    public function isManager()
    {
        return Rating::compare($this->getRating(), Rating::MANAGER) >= 0;
    }
}

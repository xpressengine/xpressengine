<?php
/**
 * This file is member interface
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
namespace Xpressengine\Member\Entities;

use Illuminate\Contracts\Auth\CanResetPassword;
use Xpressengine\Member\Authenticatable;
use Xpressengine\Member\Entities\Database\AccountEntity;

/**
 * 회원 정보를 저장하는 클래스가 구현해야 하는 인터페이스
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface MemberEntityInterface extends Authenticatable, CanResetPassword
{
    /**
     * Get the unique identifier
     *
     * @return string
     */
    public function getId();

    /**
     * Get the name for display
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Get the rating of member
     *
     * @return string
     */
    public function getRating();

    /**
     * Finds whether member has super rating.
     *
     * @return boolean
     */
    public function isAdmin();

    /**
     * Finds whether member has manager or super rating.
     *
     * @return boolean
     */
    public function isManager();

    /**
     * Get the status of member
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get profile image URL of member
     *
     * @return string
     */
    public function getProfileImage();

    /**
     * Get groups a user belongs
     *
     * @return array
     */
    public function getGroups();

    /**
     * Get Pending Email of current member
     *
     * @return PendingMailEntityInterface
     */
    public function getPendingEmail();

    /**
     * 회원이 소유한 계정 중에 주어진 provider를 가진 계정을 반환한다.
     *
     * @param string $provider provider
     *
     * @return AccountEntity
     */
    public function getAccountByProvider($provider);
}

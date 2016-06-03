<?php
/**
 * This file is user interface
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User;

use Illuminate\Contracts\Auth\CanResetPassword;

/**
 * 회원 정보를 저장하는 클래스가 구현해야 하는 인터페이스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface UserInterface extends Authenticatable, CanResetPassword
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
     * Get the rating of user
     *
     * @return string
     */
    public function getRating();

    /**
     * Finds whether user has super rating.
     *
     * @return boolean
     */
    public function isAdmin();

    /**
     * Finds whether user has manager or super rating.
     *
     * @return boolean
     */
    public function isManager();

    /**
     * Get the status of user
     *
     * @return string
     */
    public function getStatus();

    /**
     * Get profile image URL of user
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
     * Get Pending Email of current user
     *
     * @return EmailInterface
     */
    public function getPendingEmail();

    /**
     * 회원이 소유한 계정 중에 주어진 provider를 가진 계정을 반환한다.
     *
     * @param string $provider provider
     *
     * @return AccountInterface
     */
    public function getAccountByProvider($provider);

    /**
     * add this user to groups
     *
     * @param array $groups group names
     *
     * @return static
     */
    public function joinGroups(array $groups);

    /**
     * leave groups
     *
     * @param array $groups group names
     *
     * @return static
     */
    public function leaveGroups(array $groups);
}

<?php
/**
 * This file is user interface
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User;

use Illuminate\Database\Eloquent\Collection;

/**
 * 회원 정보를 저장하는 클래스가 구현해야 하는 인터페이스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface UserInterface
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
    public function getAccountByProvider(string $provider);

    /**
     * add this user to groups
     *
     * @param mixed $groups groups
     *
     * @return static
     */
    public function joinGroups($groups);

    /**
     * leave groups
     *
     * @param array $groups group names
     *
     * @return static
     */
    public function leaveGroups(array $groups);

    /**
     * Get Terms a user agreed
     *
     * @return Collection
     */
    public function getAgreedTerms();
}

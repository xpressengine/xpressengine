<?php
/**
 * This file is account interface
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

/**
 * 회원 계정 정보를 저장하는 클래스가 구현해야 하는 인터페이스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface AccountInterface
{
    /**
     * 계정을 소유한 회원의 아이디를 반환한다.
     *
     * @return string
     */
    public function getUserId();

    /**
     * 계정의 밴더를 반환한다.
     *
     * @return string
     */
    public function getProvider();

    /**
     * 계정에 할당된 이메일 주소를 반환한다.
     *
     * @return string|null
     */
    public function getEmailAddress();
}

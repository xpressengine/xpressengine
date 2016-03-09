<?php
/**
 * This file is account interface
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User;

/**
 * 회원 계정 정보를 저장하는 클래스가 구현해야 하는 인터페이스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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

<?php
/**
 * This file is account interface
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

namespace Xpressengine\User;

/**
 * 회원 그룹 정보를 저장하는 클래스가 구현해야 하는 인터페이스
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface GroupInterface
{

    /**
     * add User to this group
     *
     * @param UserInterface $user user
     *
     * @return static
     */
    public function addUser(UserInterface $user);

    /**
     * except User
     *
     * @param UserInterface $user user
     *
     * @return static
     */
    public function exceptUser(UserInterface $user);
}

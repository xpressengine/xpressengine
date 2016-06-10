<?php
/**
 *  This file is part of the Xpressengine package.
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

namespace Xpressengine\User\Repositories;

use Xpressengine\User\GroupInterface;
use Xpressengine\User\UserInterface;

/**
 * 이 인터페이스는 그룹정보 저장소가 구현해야 하는 인터페이스이다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface UserGroupRepositoryInterface
{
    /**
     * 주어진 그룹에 주어진 회원을 추가한다.
     *
     * @param GroupInterface $group 대상 그룹
     * @param UserInterface  $user  추가할 회원
     *
     * @return mixed
     */
    public function addUser($group, $user);

    /**
     * 주어진 회원을 그룹에서 제외시킨다.
     *
     * @param GroupInterface $group 대상 그룹
     * @param UserInterface  $user  제외시킬 회원
     *
     * @return void
     */
    public function exceptUser($group, $user);
}

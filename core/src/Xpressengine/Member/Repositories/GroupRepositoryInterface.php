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
namespace Xpressengine\Member\Repositories;

use Xpressengine\Member\Entities\GroupEntityInterface;
use Xpressengine\Member\Entities\MemberEntityInterface;

/**
 * 이 인터페이스는 그룹정보 저장소가 구현해야 하는 인터페이스이다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface GroupRepositoryInterface
{

    /**
     * 주어진 그룹에 주어진 회원을 추가한다.
     *
     * @param GroupEntityInterface           $group 대상 그룹
     * @param MemberEntityInterface $user  추가할 회원
     *
     * @return mixed
     */
    public function addUser(GroupEntityInterface $group, MemberEntityInterface $user);

    /**
     * 주어진 회원을 그룹에서 제외시킨다.
     *
     * @param GroupEntityInterface  $group 대상 그룹
     * @param MemberEntityInterface $user  제외시킬 회원
     *
     * @return void
     */
    public function exceptUser(GroupEntityInterface $group, MemberEntityInterface $user);
}

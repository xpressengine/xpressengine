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

use Xpressengine\Member\Entities\Database\GroupEntity;
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
interface GroupRepositoryInterface extends RepositoryInterface
{

    /**
     * 주어진 회원이 소속된 그룹 목록을 반환한다.
     *
     * @param MemberEntityInterface $member 조회할 회원
     * @param string[]|null         $with   함께 반환할 relation 정보
     *
     * @return mixed
     */
    public function fetchAllByMember(MemberEntityInterface $member, $with = null);

    /**
     * 주어진 그룹에 주어진 회원을 추가한다.
     *
     * @param GroupEntity           $group  대상 그룹
     * @param MemberEntityInterface $member 추가할 회원
     *
     * @return mixed
     */
    public function addMember(GroupEntity $group, MemberEntityInterface $member);

    /**
     * 주어진 회원을 그룹에서 제외시킨다.
     *
     * @param GroupEntity           $group  대상 그룹
     * @param MemberEntityInterface $member 제외시킬 회원
     *
     * @return void
     */
    public function exceptMember(GroupEntity $group, MemberEntityInterface $member);
}

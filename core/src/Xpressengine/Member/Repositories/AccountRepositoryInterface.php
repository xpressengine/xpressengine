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

/**
 * 회원 계정 정보 저장소(AccountRepository)가 구현해야 하는 인터페이스
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
interface AccountRepositoryInterface
{

    /**
     * 회원 아이디로 계정정보를 조회한다.
     *
     * @param string $userId member id
     *
     * @return array
     */
    public function fetchAllByMember($userId);

    /**
     * 회원 아이디에 해당하는 계정정보를 모두 삭제한다.
     *
     * @param array $userIds 회원 아이디 목록
     *
     * @return mixed
     */
    public function deleteByUserIds($userIds);
}

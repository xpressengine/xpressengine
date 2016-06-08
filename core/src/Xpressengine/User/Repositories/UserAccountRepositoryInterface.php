<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Repositories;

/**
 * 회원 계정 정보 저장소(AccountRepository)가 구현해야 하는 인터페이스
 *
 * @category    User
 * @package     Xpressengine\User
 */
interface UserAccountRepositoryInterface
{

    /**
     * 회원 아이디로 계정정보를 조회한다.
     *
     * @param string $userId user id
     *
     * @return array
     */
    public function findByUserId($userId);

    /**
     * 회원 아이디에 해당하는 계정정보를 모두 삭제한다.
     *
     * @param array $userIds 회원 아이디 목록
     *
     * @return int
     */
    public function deleteByUserIds($userIds);
}

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

use Xpressengine\User\EmailInterface;
use Xpressengine\User\UserInterface;

/**
 * 이 인터페이스는 회원의 이메일정보 저장소가 구현해야 하는 인터페이스이다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 * @method      create(UserInterface $user, array $data)
 * @method      update(EmailInterface $item, array $data = [])
 * @method      delete(EmailInterface $item)
 * @method      query()
 */
interface UserEmailRepositoryInterface
{
    /**
     * 이메일 주소로 이메일 정보를 조회한다.
     *
     * @param string $address 조회할 이메일 주소
     *
     * @return EmailInterface
     */
    public function findByAddress($address);

    /**
     * 회원 아이디로 이메일을 조회하여 반환한다.
     *
     * @param string $userId user id
     *
     * @return EmailInterface[]
     */
    public function findByUserId($userId);

    /**
     * 주어진 회원이 소유한 이메일을 삭제한다.
     *
     * @param string $userIds 삭제할 이메일을 소유한 회원의 id
     *
     * @return integer
     */
    public function deleteByUserIds($userIds);
}

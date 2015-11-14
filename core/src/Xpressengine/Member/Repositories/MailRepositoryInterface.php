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

use Xpressengine\Member\Entities\MailEntityInterface;
use Xpressengine\Member\Mail;

/**
 * 이 인터페이스는 회원의 이메일정보 저장소가 구현해야 하는 인터페이스이다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface MailRepositoryInterface extends RepositoryInterface
{


    /**
     * 이메일 주소로 이메일 정보를 조회한다.
     *
     * @param string        $address 조회할 이메일 주소
     * @param string[]|null $with    entity와 함께 반환할 relation 정보
     *
     * @return MailEntityInterface
     */
    public function findByAddress($address, $with = null);

    /**
     * 주어진 회원이 소유한 이메일 목록을 조회한다.
     *
     * @param string        $memberId member id
     * @param string[]|null $with     entity와 함께 반환할 relation 정보
     *
     * @return MailEntityInterface[]
     */
    public function fetchAllByMember($memberId, $with = null);

    /**
     * 주어진 회원이 소유한 이메일을 삭제한다.
     *
     * @param string $memberIds 삭제할 이메일을 소유한 회원의 id
     *
     * @return integer
     */
    public function deleteByMemberIds($memberIds);
}

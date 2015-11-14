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
namespace Xpressengine\Member;

use Xpressengine\Member\Entities\MemberEntityInterface;

/**
 * 이 인터페이스는 특정 회원과 연관된 정보(entity)들이 구현해야 하는 인터페이스이다.
 * 이 인터페이스를 구현한 entity를 MemberHandler의 associate 또는 associates 메소드의 인자로 사용하여 호출하면,
 * MemberHandler는 연관된 회원정보를 조회하여 entity에 지정해준다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface AssociateInterface
{
    /**
     * get member's origin id
     *
     * @return mixed
     */
    public function getMemberOriginId();

    /**
     * set member entity
     *
     * @param MemberEntityInterface $entity member entity
     *
     * @return void
     */
    public function setMemberEntity(MemberEntityInterface $entity);
}

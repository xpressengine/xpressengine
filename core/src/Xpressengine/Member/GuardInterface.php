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

use Illuminate\Contracts\Auth\Guard as GuardContract;
use Xpressengine\Member\Entities\Guest;

/**
 * 이 인터페이스는 Xpressengine의 인증클래스가 구현해야 하는 인터페이스이다.
 * Laravel의 기본 인터페이스에 makeGuest가 추가되었다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
interface GuardInterface extends GuardContract
{
    /**
     * Guest 회원 인스턴스를 생성하여 반환한다.
     *
     * @return Guest
     */
    public function makeGuest();
}

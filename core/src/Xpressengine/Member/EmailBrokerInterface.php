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

use Closure;
use Xpressengine\Member\Entities\PendingMailEntityInterface;

/**
 * 이 인터페이스는 이메일 인증 처리 클래스가 구현해야 하는 인터페이스이다.
 * 이 인터페이스는 인증 요청 메일 전송, 인증메일의 인증처리, 인증메일의 인증여부를 체크하는 메소드로 구성된다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
interface EmailBrokerInterface
{
    /**
     * 이메일 인증 요청 메일을 전송한다.
     *
     * @param PendingMailEntityInterface $mail     전송할 이메일 정보
     * @param null|Closure               $callback 이메일 전송할 때 처리할 로직
     *
     * @return void
     */
    public function sendEmailForConfirmation($mail, $callback = null);

    /**
     * 이메일을 인증처리한다.
     *
     * @param string $email 인증할 이메일
     * @param string $code  인증코드
     *
     * @return bool 주어진 이메일의 인증처리가 성공하면 true를 반환한다.
     */
    public function confirmEmail($email, $code);

    /**
     * 이메일 인증 상태를 반환한다.
     *
     * @param string $email 체크할 이메일 주소
     *
     * @return boolean 이메일 인증 여부
     */
    public function checkEmailConfirmation($email);
}

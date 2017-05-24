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

namespace Xpressengine\User;

use Closure;

/**
 * 이 인터페이스는 이메일 인증 처리 클래스가 구현해야 하는 인터페이스이다.
 * 이 인터페이스는 인증 요청 메일 전송, 인증메일의 인증처리,
 * 인증메일의 인증여부를 체크하는 메소드로 구성된다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface EmailBrokerInterface
{
    /**
     * 회원가입시 이메일 인증을 위한 이메일을 전송한다.
     *
     * @param EmailInterface $mail     전송할 이메일 정보
     * @param string         $token    회원가입 토큰 id
     * @param string         $view     이메일 전송시 사용할 템플릿
     * @param null|Closure   $callback 이메일 전송할 때 처리할 로직
     *
     * @return void
     */
    public function sendEmailForRegister(EmailInterface $mail, $token, $view, $callback = null);

    /**
     * 기존 회원이 이메일 추가시 이메일 인증을 위한 이메일을 전송한다.
     *
     * @param EmailInterface $mail     전송할 이메일 정보
     * @param string         $view     이메일 전송시 사용할 템플릿
     * @param null|Closure   $callback 이메일 전송할 때 처리할 로직
     *
     * @return void
     */
    public function sendEmailForAddingEmail(EmailInterface $mail, $view, $callback = null);

    /**
     * 주어진 이메일의 인증코드를 검사한다.
     *
     * @param EmailInterface $mail 인증할 이메일 정보
     * @param string         $code 인증코드
     *
     * @return bool 주어진 이메일에 등록된 인증코드가 일치할 경우 true, 일치하지 않으면 false를 반환한다.
     */
    public function validateConfirmCode(EmailInterface $mail, $code);

    /**
     * 이메일을 인증처리 한다.
     *
     * @param EmailInterface $email 인증할 이메일
     * @param string         $code  인증코드
     *
     * @return bool 주어진 이메일의 인증처리가 성공하면 true를 반환한다.
     */
    public function confirmEmail(EmailInterface $email, $code);
}

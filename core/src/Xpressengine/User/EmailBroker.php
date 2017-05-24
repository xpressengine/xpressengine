<?php
/**
 * EmailBroker class. This file is part of the Xpressengine package.
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
use Illuminate\Contracts\Mail\Mailer;
use Xpressengine\User\Exceptions\InvalidConfirmationCodeException;

/**
 * 이 클래스는 Xpressengine에서 이메일 인증 처리를 수행하는 클래스이다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class EmailBroker implements EmailBrokerInterface
{

    /**
     * 이메일 전송기
     *
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var UserHandler
     */
    private $handler;

    /**
     * 생성자.
     *
     * @param UserHandler $handler handler
     * @param Mailer      $mailer  mail sender
     */
    public function __construct(
        UserHandler $handler,
        Mailer $mailer
    ) {
        $this->mailer = $mailer;
        $this->handler = $handler;
    }

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
    public function sendEmailForRegister(EmailInterface $mail, $token, $view, $callback = null)
    {
        $this->mailer->send(
            $view,
            compact('mail', 'token'),
            function ($m) use ($mail, $callback) {
                $m->to($mail->getAddress());

                if (!is_null($callback)) {
                    call_user_func($callback, $m, $mail);
                }
            }
        );
    }

    /**
     * 기존 회원이 이메일 추가시 이메일 인증을 위한 이메일을 전송한다.
     *
     * @param EmailInterface $mail     전송할 이메일 정보
     * @param string         $view     이메일 전송시 사용할 템플릿
     * @param null|Closure   $callback 이메일 전송할 때 처리할 로직
     *
     * @return void
     */
    public function sendEmailForAddingEmail(EmailInterface $mail, $view, $callback = null)
    {
        $this->mailer->send(
            $view,
            compact('mail'),
            function ($m) use ($mail, $callback) {
                $m->to($mail->getAddress());

                if (!is_null($callback)) {
                    call_user_func($callback, $m, $mail);
                }
            }
        );
    }


    /**
     * 주어진 이메일의 인증코드를 검사한다.
     *
     * @param EmailInterface $mail 인증할 이메일 정보
     * @param string         $code 인증코드
     *
     * @return bool 주어진 이메일에 등록된 인증코드가 일치할 경우 true, 일치하지 않으면 false를 반환한다.
     */
    public function validateConfirmCode(EmailInterface $mail, $code)
    {
        return $mail->getConfirmationCode() === $code;
    }

    /**
     * 주어진 이메일을 인증처리 한다.
     * 주어진 등록 대기 이메일의 인증코드가 주어진 인증코드와 동일하면
     * 해당 이메일을 해당회원의 실제 이메일로 등록하고, 본 등록대기 이메일은 삭제한다.
     *
     * @param EmailInterface $email 인증할 이메일
     * @param string         $code  인증코드
     *
     * @return bool 주어진 이메일의 인증처리가 성공하면 true를 반환한다.
     * @throws \Exception
     */
    public function confirmEmail(EmailInterface $email, $code)
    {
        if ($this->validateConfirmCode($email, $code) === false) {
            throw new InvalidConfirmationCodeException();
        }

        $info = [
            'address' => $email->getAddress(),
        ];

        // remove pending email & create confirmed email
        $this->handler->createEmail($email->user, $info, true);
        $this->handler->deleteEmail($email);
        return true;
    }
}

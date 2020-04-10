<?php
/**
 * EmailBroker class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User;

use Illuminate\Notifications\Notifiable;
use Xpressengine\User\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\User\Notifications\AddEmail;
use Xpressengine\User\Notifications\RegisterEmailApprove;
use Xpressengine\User\Notifications\RegisterConfirm;

/**
 * 이 클래스는 Xpressengine에서 이메일 인증 처리를 수행하는 클래스이다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class EmailBroker
{
    /**
     * @var UserHandler
     */
    private $handler;

    /**
     * 생성자.
     *
     * @param UserHandler $handler handler
     */
    public function __construct(UserHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * 회원가입 전에 이메일 인증을 위한 이메일을 전송한다.
     *
     * @param EmailInterface $mail  전송할 이메일 정보
     * @param string         $token 회원가입 토큰 id
     *
     * @return void
     * @deprecated since 3.0.8 회원가입 전 이메일 인증 기능 삭제
     */
    public function sendEmailForRegister(EmailInterface $mail, $token)
    {
        (new class($mail) {
            use Notifiable;

            protected $mail;

            /**
             * constructor.
             *
             * @param EmailInterface $mail mail instance
             */
            public function __construct(EmailInterface $mail)
            {
                $this->mail = $mail;
            }

            /**
             * Invoke the instance
             *
             * @param mixed $token confirm token
             * @return void
             */
            public function __invoke($token)
            {
                $this->notify(new RegisterConfirm($this->mail, $token));
            }

            /**
             * Get the notification routing information for the given driver.
             *
             * @param string $driver driver
             * @return mixed
             */
            public function routeNotificationFor($driver)
            {
                return $this->mail->getAddress();
            }
        })($token);
    }

    /**
     * @param EmailInterface $mail
     */
    public function sendEmailForRegisterApprove(EmailInterface $mail, $token)
    {
        (new class($mail) {
            use Notifiable;

            protected $mail;

            /**
             * constructor.
             *
             * @param EmailInterface $mail mail instance
             */
            public function __construct(EmailInterface $mail)
            {
                $this->mail = $mail;
            }

            /**
             * Invoke the instance
             *
             * @return void
             */
            public function __invoke($token)
            {
                $this->notify(new RegisterEmailApprove($this->mail, $token));
            }

            /**
             * Get the notification routing information for the given driver.
             *
             * @param string $driver driver
             * @return mixed
             */
            public function routeNotificationFor($driver)
            {
                return $this->mail->getAddress();
            }
        })($token);
    }

    /**
     * 기존 회원이 이메일 추가시 이메일 인증을 위한 이메일을 전송한다.
     *
     * @param EmailInterface $mail 전송할 이메일 정보
     *
     * @return void
     */
    public function sendEmailForAddingEmail(EmailInterface $mail)
    {
        (new class($mail) {
            use Notifiable;

            protected $mail;

            /**
             * constructor.
             *
             * @param EmailInterface $mail mail instance
             */
            public function __construct(EmailInterface $mail)
            {
                $this->mail = $mail;
            }

            /**
             * Invoke the instance
             *
             * @return void
             */
            public function __invoke()
            {
                $this->notify(new AddEmail($this->mail));
            }

            /**
             * Get the notification routing information for the given driver.
             *
             * @param string $driver driver
             * @return mixed
             */
            public function routeNotificationFor($driver)
            {
                return $this->mail->getAddress();
            }
        })();
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

    /**
     * 이메일 인증 후 가입 옵션을 사용할 때 메일 인증 처리
     *
     * @param EmailInterface $email 인증할 이메일
     * @param string         $code  인증코드
     *
     * @return bool
     */
    public function approvalEmail(EmailInterface $email, $code)
    {
        if ($this->validateConfirmCode($email, $code) === false) {
            throw new InvalidConfirmationCodeException();
        }

        $this->handler->deleteEmail($email);
        return true;
    }
}

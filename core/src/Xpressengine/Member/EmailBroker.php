<?php
/**
 * EmailBroker class. This file is part of the Xpressengine package.
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
use Illuminate\Contracts\Mail\Mailer;
use Xpressengine\Member\Entities\Database\MailEntity;
use Xpressengine\Member\Entities\PendingMailEntityInterface;
use Xpressengine\Member\Exceptions\InvalidConfirmationCodeException;
use Xpressengine\Member\Exceptions\EmailNotFoundException;
use Xpressengine\Member\Exceptions\PendingEmailNotExistsException;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\Member\Repositories\PendingMailRepositoryInterface;

/**
 * 이 클래스는 Xpressengine에서 이메일 인증 처리를 수행하는 클래스이다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class EmailBroker implements EmailBrokerInterface
{

    /**
     * 회원 이메일 저장소
     *
     * @var MailRepositoryInterface
     */
    protected $mails;

    /**
     * 회원 등록대기 이메일
     *
     * @var PendingMailRepositoryInterface
     */
    protected $pendingMails;

    /**
     * 이메일 전송기
     *
     * @var Mailer
     */
    protected $mailer;

    /**
     * 이메일 인증 메일을 전송할 때 사용할 view id
     *
     * @var string
     */
    protected $view;

    /**
     * 생성자.
     *
     * @param MailRepositoryInterface        $mails        mail repository
     * @param PendingMailRepositoryInterface $pendingMails pending mail repository
     * @param Mailer                         $mailer       mail sender
     * @param string                         $view         mail 전송시 사용할 view 파일
     */
    public function __construct(
        MailRepositoryInterface $mails,
        PendingMailRepositoryInterface $pendingMails,
        Mailer $mailer,
        $view
    ) {
        $this->mails = $mails;
        $this->mailer = $mailer;
        $this->view = $view;
        $this->pendingMails = $pendingMails;
    }

    /**
     * 이메일 인증을 위한 이메일을 전송한다.
     *
     * @param PendingMailEntityInterface $mail     전송할 이메일 정보
     * @param null|Closure               $callback 이메일 전송할 때 처리할 로직
     *
     * @return void
     */
    public function sendEmailForConfirmation($mail, $callback = null)
    {
        $this->mailer->send(
            $this->view,
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
     * @param PendingMailEntityInterface $mail 인증할 이메일 정보
     * @param string                     $code 인증코드
     *
     * @return bool 주어진 이메일에 등록된 인증코드가 일치할 경우 true, 일치하지 않으면 false를 반환한다.
     */
    protected function validateConfirmCode(PendingMailEntityInterface $mail, $code)
    {
        return $mail->getConfirmationCode() === $code;
    }

    /**
     * 주어진 이메일을 인증처리 한다.
     * 주어진 등록 대기 이메일의 인증코드가 주어진 인증코드와 동일하면 해당 이메일을 해당회원의 실제 이메일로 등록하고, 본 등록대기 이메일은 삭제한다.
     *
     * @param string $email 인증할 이메일
     * @param string $code  인증코드
     *
     * @return bool 주어진 이메일의 인증처리가 성공하면 true를 반환한다.
     * @throws \Exception
     */
    public function confirmEmail($email, $code)
    {
        $pendingMail = $this->pendingMails->findByAddress($email);

        if ($pendingMail === null) {
            throw new PendingEmailNotExistsException();
        }
        if ($this->validateConfirmCode($pendingMail, $code) === false) {
            throw new InvalidConfirmationCodeException();
        }

        $info = [
            'address' => $pendingMail->getAddress(),
            'memberId' => $pendingMail->getUserId()
        ];

        $mail = new MailEntity($info);

        try {
            $this->mails->insert($mail);
            $this->pendingMails->delete($pendingMail);
        } catch (\Exception $e) {
            throw $e;
        }
        return true;
    }


    /**
     * 이메일의 인증여부를 체크한다.
     * 주어진 이메일 주소가 등록대기 이메일 목록에 있는지 실제 이메일 목록에 있는지 체크한 후 반환한다.
     *
     * @param string $email 체크할 이메일 주소
     *
     * @return boolean 이메일 인증 여부
     */
    public function checkEmailConfirmation($email)
    {
        $mail = $this->pendingMails->findByAddress($email);

        if ($mail !== null) {
            return false;
        }

        $mail = $this->mails->findByAddress($email);

        if ($mail === null) {
            throw new EmailNotFoundException();
        }

        return true;
    }
}

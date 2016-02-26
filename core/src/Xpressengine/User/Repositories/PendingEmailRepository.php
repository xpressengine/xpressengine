<?php
/**
 * This file is user pending email repository.
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User\Repositories;

use Xpressengine\Member\Exceptions\CannotDeleteMainEmailOfMemberException;
use Xpressengine\User\EmailInterface;
use Xpressengine\User\UserInterface;

/**
 * 회원의 등록 대기 이메일 정보를 저장하는 Repository
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PendingEmailRepository implements UserEmailRepositoryInterface
{
    use RepositoryTrait;

    /**
     * PendingEmailRepository constructor.
     *
     * @param $model
     */
    public function __construct($model)
    {
        $this->setModel($model);
    }

    /**
     * create
     *
     * @param UserInterface $user
     * @param array         $data
     *
     * @return EmailInterface
     */
    public function create(UserInterface $user, array $data)
    {
        if (empty($data['confirmationCode'])) {
            $data['confirmationCode'] = str_random();
        }
        $email = $this->newModel()->create($data);
        $user->pendingEmail()->save($email);
        return $email;
    }


    /**
     * delete
     *
     * @param EmailInterface $email
     *
     * @return mixed
     * @throws CannotDeleteMainEmailOfMemberException
     */
    public function delete(EmailInterface $email)
    {
        $user = $email->user;
        return $email->delete();
    }


    /**
     * 이메일 주소로 등록대기 이메일 정보를 조회한다.
     *
     * @param string        $address 조회할 이메일 주소
     *
     * @return EmailInterface
     */
    public function findByAddress($address)
    {
        $email = $this->query()->where('address', $address)->first();
        return $email;
    }

    /**
     * 회원 아이디로 이메일을 조회하여 반환한다.
     *
     * @param $userId
     *
     * @return mixed
     */
    public function findByUserId($userId)
    {
        $emails = $this->query()->where('userId', $userId)->get();
        return $emails;
    }

    /**
     * 주어진 회원이 소유한 등록대기 이메일을 삭제한다.
     *
     * @param string $userIds 삭제할 이메일을 소유한 회원의 id
     *
     * @return integer
     */
    public function deleteByUserIds($userIds)
    {
        return $this->query()->whereIn('userId', (array) $userIds)->delete();
    }

    /**
     * 주어진 회원이 소유한 등록대기 이메일의 인증 코드를 반환한다.
     *
     * @param string        $userId user id
     * @param string        $code   mail confirmation code
     *
     * @return EmailInterface
     */
    public function findByConfirmationCode($userId, $code)
    {
        $email = $this->query()->where('userId', $userId)->where('confirmationCode', $code)->first();
        return $email;
    }
}

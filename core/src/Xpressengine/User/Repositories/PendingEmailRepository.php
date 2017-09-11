<?php
/**
 * This file is user pending email repository.
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
use Xpressengine\User\Exceptions\CannotDeleteMainEmailOfUserException;
use Xpressengine\User\UserInterface;

/**
 * 회원의 등록 대기 이메일 정보를 저장하는 Repository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PendingEmailRepository implements PendingEmailRepositoryInterface
{
    use RepositoryTrait;

    /**
     * create
     *
     * @param UserInterface $user user
     * @param array         $data data
     *
     * @return EmailInterface
     */
    public function create(UserInterface $user, array $data)
    {
        if (empty($data['confirmation_code'])) {
            $data['confirmation_code'] = str_random();
        }
        $email = $this->createModel()->create($data);
        $user->pendingEmail()->save($email);
        return $email;
    }


    /**
     * delete
     *
     * @param EmailInterface $email email
     *
     * @return mixed
     * @throws CannotDeleteMainEmailOfUserException
     */
    public function delete(EmailInterface $email)
    {
        return $email->delete();
    }


    /**
     * 이메일 주소로 등록대기 이메일 정보를 조회한다.
     *
     * @param string $address 조회할 이메일 주소
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
     * @param string $userId user id
     *
     * @return EmailInterface
     */
    public function findByUserId($userId)
    {
        $email = $this->query()->where('user_id', $userId)->first();
        return $email;
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
        return $this->query()->whereIn('user_id', (array) $userIds)->delete();
    }

    /**
     * 주어진 회원이 소유한 등록대기 이메일의 인증 코드를 반환한다.
     *
     * @param string $userId user id
     * @param string $code   mail confirmation code
     *
     * @return EmailInterface
     */
    public function findByConfirmationCode($userId, $code)
    {
        $email = $this->query()->where('user_id', $userId)->where('confirmation_code', $code)->first();
        return $email;
    }
}

<?php
/**
 * This file is user mail repository.
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

use Xpressengine\Member\Entities\MailEntityInterface;
use Xpressengine\Member\Exceptions\CannotDeleteMainEmailOfMemberException;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\User\EmailInterface;
use Xpressengine\User\Models\UserEmail;
use Xpressengine\User\Repositories\RepositoryTrait;
use Xpressengine\User\UserInterface;

/**
 * 회원의 이메일 정보를 저장하는 Repository
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserEmailRepository implements MailRepositoryInterface
{
    use RepositoryTrait;

    /**
     * UserEmailRepository constructor.
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
     * @return UserEmail
     */
    public function create(UserInterface $user, array $data)
    {
        $email = $this->newModel()->create($data);
        $user->emails()->save($email);
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
        if($user->email === $email->getAddress()) {
            throw new CannotDeleteMainEmailOfMemberException();
        }
        return $email->delete();
    }

    /**
     * 이메일 주소로 이메일 정보를 조회한다.
     *
     * @param string        $address 조회할 이메일 주소
     *
     * @return MailEntityInterface
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
     * 주어진 회원이 소유한 이메일을 삭제한다.
     *
     * @param string $userIds 삭제할 이메일을 소유한 회원의 id
     *
     * @return integer
     */
    public function deleteByUserIds($userIds)
    {
        return $this->query()->whereIn('userId', (array) $userIds)->delete();
    }
}

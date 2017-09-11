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

namespace Xpressengine\User\Repositories;

use Xpressengine\User\UserInterface;

/**
 * 회원정보를 저장하는 Repository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class UserRepository implements UserRepositoryInterface
{
    use RepositoryTrait;

    /**
     * create
     *
     * @param array $data data
     *
     * @return UserInterface
     */
    public function create(array $data)
    {
        $model = $this->createModel();
        if (array_has($data, 'password')) {
            $data['password_updated_at'] = $model->freshTimestamp();
        }
        $user = $model->create($data);
        return $user;
    }

    /**
     * update
     *
     * @param UserInterface $user user
     * @param array         $data data
     *
     * @return UserInterface
     */
    public function update(UserInterface $user, array $data = [])
    {

        if ($user->isDirty('password') || (!empty($data['password']) && $user->password !== $data['password'])) {
            $model = $this->createModel();
            $data['password_updated_at'] = $model->freshTimestamp();
        }

        $user->update($data);

        return $user;
    }

    /**
     * 이메일 주소를 소유한 회원을 조회한다.
     *
     * @param string $address 이메일 주소
     *
     * @return UserInterface
     */
    public function findByEmail($address)
    {
        $user = $this->query()->whereHas(
            'emails',
            function ($q) use ($address) {
                $q->where('address', $address);
            }
        )->first();

        return $user;
    }

    /**
     * 이메일의 이름 영역을 사용하여 회원을 조회한다.
     *
     * @param string $emailPrefix 조회할 이메일의 이름영역
     *
     * @return UserInterface[]
     */
    public function searchByEmailPrefix($emailPrefix)
    {
        $users = $this->query()->whereHas(
            'emails',
            function ($q) use ($emailPrefix) {
                $q->where('address', 'like', $emailPrefix.'@%');
            }
        )->get();

        return $users;
    }
}

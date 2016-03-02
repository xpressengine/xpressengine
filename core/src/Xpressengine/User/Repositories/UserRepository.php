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
namespace Xpressengine\User\Repositories;

use Xpressengine\User\UserInterface;

/**
 * 회원정보를 저장하는 Repository
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserRepository implements UserRepositoryInterface
{
    use RepositoryTrait;

    /**
     * UserRepository constructor.
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
     * @param array $data
     *
     * @return UserInterface
     */
    public function create(array $data)
    {
        $model = $this->newModel();
        if (array_has($data, 'password')) {
            $data['passwordUpdatedAt'] = $model->freshTimestamp();
        }
        $user = $model->create($data);
        return $user;
    }

    /**
     * update
     *
     * @param UserInterface $user
     * @param array         $data
     *
     * @return UserInterface
     */
    public function update(UserInterface $user, array $data = [])
    {

        if ($user->isDirty('password') || (!empty($data['password']) && $user->password !== $data['password'])) {
            $model = $this->newModel();
            $data['passwordUpdatedAt'] = $model->freshTimestamp();
        }

        $user->update($data);

        return $user;
    }

    /**
     * 이메일 주소를 소유한 회원을 조회한다.
     *
     * @param string        $address 이메일 주소
     * @param string[]|null $with    함께 반환할 relation 정보
     *
     * @return UserInterface
     */
    public function findByEmail($address, $with = null)
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
     * @param string        $emailPrefix 조회할 이메일의 이름영역
     * @param string[]|null $with        함께 반환할 relation 정보
     *
     * @return UserInterface[]
     */
    public function searchByEmailPrefix($emailPrefix, $with = null)
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

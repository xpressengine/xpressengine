<?php
/**
 * This file is user email repository.
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

use Xpressengine\User\AccountInterface;
use Xpressengine\User\UserInterface;

/**
 * 회원의 계정 정보를 저장하는 Repository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class UserAccountRepository implements UserAccountRepositoryInterface
{
    use RepositoryTrait;

    /**
     * UserAccountRepository constructor.
     *
     * @param mixed $model model
     */
    public function __construct($model)
    {
        $this->setModel($model);
    }

    /**
     * create
     *
     * @param UserInterface $user user
     * @param array         $data data
     *
     * @return AccountInterface
     */
    public function create(UserInterface $user, array $data)
    {
        $account = $this->createModel()->create($data);
        $user->accounts()->save($account);
        return $account;
    }

    /**
     * 회원 아이디로 계정정보를 조회한다.
     *
     * @param string $userId user id
     *
     * @return array
     */
    public function findByUserId($userId)
    {
        $accounts = $this->query()->where('user_id', $userId)->get();
        return $accounts;
    }

    /**
     * 회원 아이디에 해당하는 계정정보를 모두 삭제한다.
     *
     * @param array $userIds 회원 아이디 목록
     *
     * @return int
     */
    public function deleteByUserIds($userIds)
    {
        return $this->query()->whereIn('user_id', (array) $userIds)->delete();
    }
}

<?php
/**
 * This file is user email repository.
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

namespace Xpressengine\User\Repositories;

use Xpressengine\Support\EloquentRepositoryTrait;
use Xpressengine\User\AccountInterface;
use Xpressengine\User\UserInterface;

/**
 * 회원의 계정 정보를 저장하는 Repository
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserAccountRepository implements UserAccountRepositoryInterface
{
    use EloquentRepositoryTrait;

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

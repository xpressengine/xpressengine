<?php
/**
 * This file is member mail repository.
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
namespace Xpressengine\Member\Repositories\Database;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Member\Entities\Database\AccountEntity;
use Xpressengine\Member\Repositories\AccountRepositoryInterface;
use Xpressengine\Member\Repositories\DatabaseRepositoryTrait;

/**
 * 회원의 계정 정보를 저장하는 Repository
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AccountRepository implements AccountRepositoryInterface
{
    use DatabaseRepositoryTrait;

    /**
     * AccountRepository constructor.
     *
     * @param VirtualConnectionInterface $connection db connection
     * @param Keygen                     $generator  key generator
     */
    public function __construct(VirtualConnectionInterface $connection, Keygen $generator)
    {
        $this->connection = $connection;
        $this->generator = $generator;
        $this->mainTable = $mainTable = 'user_account';
        $this->entityClass = AccountEntity::class;
    }

    /**
     * 회원 아이디로 계정정보를 조회한다.
     *
     * @param string $userId member id
     *
     * @return array
     */
    public function fetchAllByMember($userId)
    {
        $query = $this->table()->whereIn('userId', (array) $userId);
        return $this->getEntities($query);
    }

    /**
     * 회원 아이디에 해당하는 계정정보를 모두 삭제한다.
     *
     * @param array $userIds 회원 아이디 목록
     *
     * @return mixed
     */
    public function deleteByUserIds($userIds)
    {
        return $this->table()->whereIn('userId', (array) $userIds)->delete();
    }
}

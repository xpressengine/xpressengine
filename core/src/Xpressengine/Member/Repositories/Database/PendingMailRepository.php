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
use Xpressengine\Member\Entities\Database\PendingMailEntity;
use Xpressengine\Member\Entities\PendingMailEntityInterface;
use Xpressengine\Member\Repositories\DatabaseRepositoryTrait;
use Xpressengine\Member\Repositories\PendingMailRepositoryInterface;

/**
 * 회원의 등록 대기 이메일 정보를 저장하는 Repository
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
class PendingMailRepository implements PendingMailRepositoryInterface
{
    use DatabaseRepositoryTrait;

    /**
     * constructor.
     *
     * @param VirtualConnectionInterface $connection db connection
     */
    public function __construct(VirtualConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->isDynamic = false;
        $this->mainTable = $mainTable = 'user_pending_email';
        $this->entityClass = PendingMailEntity::class;
    }

    /**
     * 주어진 entity 정보를 저장소에 추가한다.
     *
     * @param PendingMailEntityInterface $entity 삽입할 정보
     *
     * @return PendingMailEntityInterface
     */
    public function insert($entity)
    {
        $now = $this->getCurrentTime();
        $entity->createdAt = $entity->updatedAt = $now;
        $entity->confirmationCode = str_random();

        $id = $this->table()->insertGetId($entity->getAttributes());
        $entity->id = $id;

        return $entity;
    }

    /**
     * 이메일 주소로 등록대기 이메일 정보를 조회한다.
     *
     * @param string        $address 조회할 이메일 주소
     * @param string[]|null $with    entity와 함께 반환할 relation 정보
     *
     * @return PendingMailEntityInterface
     */
    public function findByAddress($address, $with = null)
    {
        $query = $this->table()->where('address', $address);
        return $this->getEntity($query, $with);
    }

    /**
     * 주어진 회원이 소유한 등록대기 이메일의 인증 코드를 반환한다.
     *
     * @param string        $memberId member id
     * @param string        $code     mail confirmation code
     * @param string[]|null $with     entity와 함께 반환할 relation 정보
     *
     * @return PendingMailEntityInterface
     */
    public function findByConfirmationCode($memberId, $code, $with = null)
    {
        $query = $this->table()->where('userId', $memberId)->where('confirmationCode', $code);
        $entities = $this->getEntities($query, $with);
        return current($entities);
    }

    /**
     * 주어진 회원이 소유한 이메일 목록을 조회한다.
     *
     * @param string        $memberId member id
     * @param string[]|null $with     entity와 함께 반환할 relation 정보
     *
     * @return PendingMailEntityInterface[]
     */
    public function findByUserId($memberId, $with = null)
    {
        $query = $this->table()->whereIn('userId', (array) $memberId);
        $entities = $this->getEntities($query, $with);
        return $entities;
    }

    /**
     * 주어진 회원이 소유한 등록대기 이메일을 삭제한다.
     *
     * @param string $memberIds 삭제할 이메일을 소유한 회원의 id
     *
     * @return integer
     */
    public function deleteByUserIds($memberIds)
    {
        return $this->table()->whereIn('userId', (array) $memberIds)->delete();
    }
}

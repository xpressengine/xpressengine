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
use Xpressengine\Member\Entities\Database\MailEntity;
use Xpressengine\Member\Entities\MailEntityInterface;
use Xpressengine\Member\Repositories\DatabaseRepositoryTrait;
use Xpressengine\Member\Repositories\MailRepositoryInterface;

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
class MailRepository implements MailRepositoryInterface
{
    use DatabaseRepositoryTrait;

    /**
     * MailRepository constructor.
     *
     * @param VirtualConnectionInterface $connection db connection
     */
    public function __construct(VirtualConnectionInterface $connection)
    {
        $this->connection = $connection;
        $this->isDynamic = false;
        $this->mainTable = $mainTable = 'member_mails';
        $this->entityClass = MailEntity::class;
    }

    /**
     * 주어진 entity 정보를 저장소에 추가한다.
     *
     * @param MailEntityInterface $entity 삽입할 정보
     *
     * @return MailEntityInterface
     */
    public function insert($entity)
    {
        $now = $this->getCurrentTime();
        $entity->createdAt = $entity->updatedAt = $now;

        $id = $this->table()->insertGetId($entity->getAttributes());
        $entity->id = $id;

        return $entity;
    }

    /**
     * 이메일 주소로 이메일 정보를 조회한다.
     *
     * @param string        $address 조회할 이메일 주소
     * @param string[]|null $with    entity와 함께 반환할 relation 정보
     *
     * @return MailEntityInterface
     */
    public function findByAddress($address, $with = null)
    {
        $query = $this->table()->where('address', $address);
        return $this->getEntity($query, $with);
    }

    /**
     * 주어진 회원이 소유한 이메일 목록을 조회한다.
     *
     * @param string        $memberId member id
     * @param string[]|null $with     entity와 함께 반환할 relation 정보
     *
     * @return MailEntityInterface[]
     */
    public function fetchAllByMember($memberId, $with = null)
    {
        $query = $this->table()->whereIn('memberId', (array) $memberId);
        $entities = $this->getEntities($query, $with);
        return $entities;
    }

    /**
     * 주어진 회원이 소유한 이메일을 삭제한다.
     *
     * @param string $memberIds 삭제할 이메일을 소유한 회원의 id
     *
     * @return integer
     */
    public function deleteByMemberIds($memberIds)
    {
        return $this->table()->whereIn('memberId', (array) $memberIds)->delete();
    }
}

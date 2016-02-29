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
namespace Xpressengine\Member\Repositories\Database;

use Member;
use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Member\Entities\Database\AccountEntity;
use Xpressengine\Member\Entities\Database\GroupEntity;
use Xpressengine\Member\Entities\Database\MailEntity;
use Xpressengine\Member\Entities\Database\MemberEntity;
use Xpressengine\Member\Entities\Database\PendingMailEntity;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Repositories\DatabaseRepositoryTrait;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;

/**
 * 회원정보를 저장하는 Repository
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
class MemberRepository implements MemberRepositoryInterface
{
    use DatabaseRepositoryTrait {
        insert as traitInsert;
        update as traitUpdate;
    }

    /**
     * MemberRepository constructor.
     *
     * @param VirtualConnectionInterface $connection db connection
     * @param Keygen                     $generator  key generator
     */
    public function __construct(VirtualConnectionInterface $connection, Keygen $generator)
    {
        // Dependency Injection
        $this->connection = $connection;
        $this->generator = $generator;

        // Repository Configuration
        $this->isDynamic = true;
        $this->mainTable = $mainTable = 'user';
        $this->entityClass = MemberEntity::class;
        $this->defaultSort = 'createdAt';
        $this->defaultOrder = 'desc';
        $this->defaultPerPage = 20;

        $this->relations['groups'] = [
            'select' => function ($memberIds) {
                return $this->mapGroups($memberIds);
            },
            'where' => function ($query, $groupIds) {
                $members = $this->table('user_group_user', false)->whereIn('groupId', (array) $groupIds)->get(
                    ['userId']
                );
                $memberIds = array_pluck($members, 'userId');
                return $query->whereIn('id', $memberIds);
            }
        ];
        $this->relations['mails'] = [
            'select' => function ($memberIds) {
                return $this->mapMails($memberIds);
            },
            'where' => function ($query, $mailIds) {
                $members = $this->table('member_mails', false)->whereIn('map.id', (array) $mailIds)->get(['userId']);
                $memberIds = array_pluck($members, 'userId');
                return $query->whereIn('id', $memberIds);
            }
        ];
        $this->relations['pending_mails'] = [
            'select' => function ($memberIds) {
                return $this->mapPendingMails($memberIds);
            },
            'where' => function ($query, $mailIds) {
                $members = $this->table('member_pending_mails', false)->whereIn('map.id', (array) $mailIds)->get(
                    ['userId']
                );
                $memberIds = array_pluck($members, 'userId');
                return $query->whereIn('id', $memberIds);
            }
        ];
        $this->relations['accounts'] = [
            'select' => function ($memberIds) {
                return $this->mapAccounts($memberIds);
            },
            'where' => function ($query, $accountIds) {
                return $query->leftJoin('member_account as map', 'map.userId', '=', 'member.id')->whereIn(
                    'map.accountId',
                    (array) $accountIds
                );
            }
        ];
    }

    /**
     * 주어진 entity 정보를 저장소에 추가한다.
     *
     * @param MemberEntityInterface $entity 삽입할 정보
     *
     * @return MemberEntityInterface
     */
    public function insert($entity)
    {
        $data = $entity->getAttributes();

        if (array_has($data, 'password')) {
            $entity->passwordUpdatedAt = $this->getCurrentTime();
        }
        return $this->traitInsert($entity);
    }


    /**
     * 주어진 entity 정보를 저장소에 업데이트한다.
     *
     * @param MemberEntityInterface $entity 업데이트할 정보
     *
     * @return MemberEntityInterface
     */
    public function update($entity)
    {
        $data = $entity->diff();

        if (array_has($data, 'password')) {
            $entity->passwordUpdatedAt = $this->getCurrentTime();
        }

        return $this->traitUpdate($entity);
    }


    /**
     * map groups relation
     *
     * @param string[] $memberIds member id list
     *
     * @return array
     */
    private function mapGroups($memberIds)
    {
        $rows = $this->table('user_group_user as map', false)->leftJoin(
            'user_group as g',
            'map.groupId',
            '=',
            'g.id'
        )->whereIn('map.userId', $memberIds)->get(['map.userId', 'g.*']);

        $members = [];

        foreach ($memberIds as $id) {
            $members[$id] = [];
        }

        $groupEntities = [];

        foreach ($rows as $group) {
            $memberId = $group['userId'];
            $groupId = $group['id'];
            if (!isset($groupEntities[$groupId])) {
                $groupEntities[$groupId] = new GroupEntity($group);
            }
            $members = array_add($members, $memberId.'.'.$group['id'], $groupEntities[$groupId]);
        }
        return $members;
    }

    /**
     * map mails relation
     *
     * @param string[] $memberIds member id list
     *
     * @return array
     */
    private function mapMails($memberIds)
    {
        $rows = $this->table('member_mails', false)->whereIn('userId', $memberIds)->get();

        $members = [];

        foreach ($memberIds as $id) {
            $members[$id] = [];
        }

        $mailEntities = [];
        foreach ($rows as $mail) {
            $memberId = $mail['userId'];
            $mailId = $mail['id'];
            if (!isset($mailEntities[$mailId])) {
                $mailEntities[$mailId] = new MailEntity($mail);
            }
            $members = array_add($members, $memberId.'.'.$mail['id'], $mailEntities[$mailId]);
        }
        return $members;
    }

    /**
     * map pending mails relation
     *
     * @param string[] $memberIds member id list
     *
     * @return array
     */
    private function mapPendingMails($memberIds)
    {
        $rows = $this->table('member_pending_mails', false)->whereIn('userId', $memberIds)->get();

        $members = [];

        foreach ($memberIds as $id) {
            $members[$id] = [];
        }

        $mailEntities = [];
        foreach ($rows as $mail) {
            $memberId = $mail['userId'];
            $mailId = $mail['id'];
            if (!isset($mailEntities[$mailId])) {
                $mailEntities[$mailId] = new PendingMailEntity($mail);
            }
            $members = array_add($members, $memberId.'.'.$mail['id'], $mailEntities[$mailId]);
        }
        return $members;
    }

    /**
     * map accounts relation
     *
     * @param string[] $memberIds member id list
     *
     * @return array
     */
    private function mapAccounts($memberIds)
    {
        $rows = $this->table('member_account', false)->whereIn('userId', $memberIds)->get();

        $members = [];

        foreach ($memberIds as $id) {
            $members[$id] = [];
        }

        $accountEntities = [];

        foreach ($rows as $account) {
            $memberId = $account['userId'];
            $accountId = $account['id'];
            if (!isset($accountEntities[$accountId])) {
                $accountEntities[$accountId] = new AccountEntity($account);
            }
            $members = array_add($members, $memberId.'.'.$accountId, $accountEntities[$accountId]);
        }
        return $members;
    }

    /**
     * 이메일 주소를 소유한 회원을 조회한다.
     *
     * @param string        $address 이메일 주소
     * @param string[]|null $with    함께 반환할 relation 정보
     *
     * @return MemberEntityInterface
     */
    public function findByEmail($address, $with = null)
    {
        $mail = $this->table('member_mails', false)->where('address', $address)->first(['userId']);
        if ($mail === null) {
            return null;
        }
        return $this->find($mail['userId'], $with);
    }

    /**
     * 주어진 아이디와 프로바이더에 해당하는 계정을 소유한 회원을 조회한다.
     *
     * @param string        $accountId 계정 아이디
     * @param string        $provider  계정의 프로바이더
     * @param string[]|null $with      함께 반환할 relation 정보
     *
     * @return MemberEntityInterface
     */
    public function findByAccountIdAndProvider($accountId, $provider, $with = null)
    {
        $account = $this->table('member_account', false)->where('accountId', $accountId)->where(
            'accounts.default',
            Member::PROVIDER_DEFAULT
        )->first(['userId']);
        return $this->find($account->memberId, $with);
    }

    /**
     * 이메일의 이름 영역을 사용하여 회원을 조회한다.
     *
     * @param string        $emailPrefix 조회할 이메일의 이름영역
     * @param string[]|null $with        함께 반환할 relation 정보
     *
     * @return MemberEntityInterface
     */
    public function searchByEmailPrefix($emailPrefix, $with = null)
    {
        $members = $this->table('member_mails', false)->where('address', 'like', $emailPrefix.'@%')->get(['userId']);
        $memberIds = array_pluck($members, 'userId');

        $query = $this->table('member')->whereIn('id', $memberIds);
        return $this->getEntities($query, $with);
    }
}

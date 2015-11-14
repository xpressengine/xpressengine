<?php
namespace Xpressengine\Tests\Member;

use Mockery;
use Xpressengine\Member\Entities\Database\MemberEntity;
use Xpressengine\Member\Repositories\Database\GroupRepository as TargetGroupRepository;

class GroupRepositoryTest extends \PHPUnit_Framework_TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var GroupRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();
        $this->assertInstanceOf('Xpressengine\Member\Repositories\Database\GroupRepository', $repo);
    }

    public function testFetchByMember()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var GroupRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('table')->withArgs(['member_group'])->andReturn($query);
        $query->shouldReceive('leftJoin')->withArgs(['member_group_member as map', 'member_group.id', '=', 'map.groupId'])->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['map.memberId', [1]])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs(['*'])->andReturn(['a']);

        $member = Mockery::mock('\Xpressengine\Member\Entities\MemberEntityInterface');
        $member->id = 1;

        $members = $repo->fetchAllByMember($member);
        $this->assertCount(1, $members);
        $this->assertEquals('a', $members[0]->attr);
    }

    public function testFetchByMemberReturnEmptyIfNoMemberFound()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var GroupRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('table')->withArgs(['member_group'])->andReturn($query);
        $query->shouldReceive('leftJoin')->withArgs(['member_group_member as map', 'member_group.id', '=', 'map.groupId'])->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['map.memberId', [1]])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs(['*'])->andReturn([]);

        $member = Mockery::mock('\Xpressengine\Member\Entities\MemberEntityInterface');
        $member->id = 1;

        $members = $repo->fetchAllByMember($member);
        $this->assertEquals([], $members);
    }

    public function testAddMember()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var GroupRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('table')->withArgs(['member_group'])->andReturn($query);
        $query->shouldReceive('where')->with('id', 1)->andReturn($query);
        $query->shouldReceive('increment')->with('count')->andReturn(1);

        $query1 = $this->makeQuery();
        $conn->shouldReceive('table')->withArgs(['member_group_member'])->andReturn($query1);
        $query1->shouldReceive('insert')->withArgs([
            [
                'groupId' => 1,
                'memberId' => 1,
                'createdAt' => 'now'
            ]
        ])->andReturn(true);

        $member = Mockery::mock('\Xpressengine\Member\Entities\MemberEntityInterface');
        $member->id = 1;

        $group = Mockery::mock('\Xpressengine\Member\Entities\Database\GroupEntity');
        $group->shouldReceive('getAttribute')->andReturn(1);

        $repo->addMember($group, $member);
    }



    private function makeConnection()
    {
        return Mockery::mock('\Xpressengine\Database\VirtualConnectionInterface');
    }

    private function makeQuery()
    {
        return Mockery::mock('\Xpressengine\Database\DynamicQuery');
    }

    private function makeGenerator()
    {
        return Mockery::mock('\Xpressengine\Keygen\Keygen', [
            'generate' => 1
        ]);
    }

    protected function getRepository()
    {
        $query = $this->makeQuery();
        $conn                    = $this->makeConnection();
        $gen                     = $this->makeGenerator();
        $repo              = new GroupRepository($conn, $gen);
        $repo->entityClass = TestEntity::class;

        return [$conn, $query, $gen, $repo];
    }
}


class GroupRepository extends TargetGroupRepository
{
    protected function getCurrentTime(){
        return 'now';
    }
}


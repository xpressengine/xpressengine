<?php
namespace Xpressengine\Tests\Member;

require_once('TestEntity.php');

use Mockery;
use Xpressengine\Member\Repositories\Database\MemberRepository as TargetMemberRepository;

class MemberRepositoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var MemberRepository
     */
    protected $repo;

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
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();
        $this->assertInstanceOf('Xpressengine\Member\Repositories\Database\MemberRepository', $repo);
    }

    public function testFind()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['id', 1])->andReturn($query);
        $query->shouldReceive('first')->withAnyArgs(['*'])->andReturn('a');

        $this->assertEquals('a', $repo->find(1)->attr);
    }

    public function testFindWithRelation()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['id', 1])->andReturn($query);
        $query->shouldReceive('first')->withAnyArgs(['*'])->andReturn(['id' => 1, 'displayName' => 'khongchi']);

        $query2 = $this->makeQuery();
        $conn->shouldReceive('table')->withArgs(['member_mails'])->andReturn($query2);
        $query2->shouldReceive('whereIn')->withArgs(['memberId', [1]])->andReturn($query2);
        $query2->shouldReceive('get')->withNoArgs()->andReturn(
            [
                ['id' => 1, 'address' => 'sungbum00@gmail.com', 'memberId' => 1],
                ['id' => 2, 'address' => 'khongchi@xpressengine.com', 'memberId' => 1]
            ]
        );

        $query3 = $this->makeQuery();
        $conn->shouldReceive('table')->withArgs(['member_group_member as map'])->andReturn($query3);
        $query3->shouldReceive('whereIn')->withArgs(['map.memberId', [1]])->andReturn($query3);
        $query3->shouldReceive('leftJoin')->withArgs(['member_group as g', 'map.groupId', '=', 'g.id'])->andReturn(
            $query3
        );
        $query3->shouldReceive('get')->withArgs([['map.memberId', 'g.*']])->andReturn(
            [
                ['id' => 1, 'memberId' => 1],
                ['id' => 2, 'memberId' => 1],
                ['id' => 3, 'memberId' => 1]
            ]
        );

        $query4 = $this->makeQuery();
        $conn->shouldReceive('table')->withArgs(['member_account'])->andReturn($query4);
        $query4->shouldReceive('whereIn')->withArgs(['memberId', [1]])->andReturn($query4);
        $query4->shouldReceive('get')->withNoArgs()->andReturn([]);

        // TODO: remove dependency of MailEntity
        $entity = $repo->find(1, ['mails', 'groups', 'accounts']);
        $this->assertCount(2, $entity->mails);
        $this->assertCount(3, $entity->groups);
        $this->assertEmpty($entity->accounts);
    }

    public function testFindNull()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['id', 1])->andReturn($query);
        $query->shouldReceive('first')->withAnyArgs()->andReturnNull();

        $this->assertNull($repo->find(1));
    }

    public function testFindAll()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['id', [1, 2]])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs()->andReturn(['a']);

        $collection = $repo->findAll([1, 2]);
        $this->assertCount(1, $collection);
        $this->assertEquals('a', array_shift($collection)->attr);
    }

    public function testPaginate()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('paginate')->withAnyArgs(['*'])->andReturn(['a']);

        $result = $repo->paginate();
        $this->assertCount(1, $result);
        $this->assertEquals('a', array_shift($result)->attr);
    }

    public function testFetch()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['id', [1, 2]])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('paginate')->withAnyArgs(['*'])->andReturn(['a']);

        $where = [
            'id' => [1, 2]
        ];
        $result = $repo->fetch($where);
        $this->assertCount(1, $result);
        $this->assertEquals('a', array_shift($result)->attr);
    }

    public function testFetchWithSimpleNavigation()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['id', [1, 2]])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('forPage')->withArgs([2, 10])->andReturn(['a']);

        $where = [
            'id' => [1, 2]
        ];
        $result = $repo->fetch($where, null, [2, 10]);
        $this->assertCount(1, $result);
        $this->assertEquals('a', array_shift($result)->attr);
    }


    public function testFetchWithNavigation()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['id', [1, 2]])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['updatedAt', 'asc'])->andReturn($query);
        $query->shouldReceive('forPage')->withArgs([2, 10])->andReturn(['a']);

        $where = [
            'id' => [1, 2]
        ];

        $navi = new \stdClass();
        $navi->page = 2;
        $navi->perPage = 10;
        $navi->sort = 'updatedAt';
        $navi->order = 'asc';

        $result = $repo->fetch($where, null, $navi);
        $this->assertCount(1, $result);
        $this->assertEquals('a', array_shift($result)->attr);
    }

    public function testFetchOne()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['id', [1, 2]])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('first')->withAnyArgs(['*'])->andReturn('a');

        $where = ['id' => [1, 2]];
        $result = $repo->fetchOne($where);
        $this->assertEquals('a', $result->attr);
    }

    public function testFetchAll()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['id', [1, 2]])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs(['*'])->andReturn(['a']);

        $where = [
            'id' => [1, 2]
        ];
        $result = $repo->fetchAll($where);
        $this->assertCount(1, $result);
        $this->assertEquals('a', array_shift($result)->attr);
    }

    public function testAll()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs(['*'])->andReturn(['a']);

        $result = $repo->all();
        $this->assertCount(1, $result);
        $this->assertEquals('a', array_shift($result)->attr);
    }

    public function testSearch()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['a', 'like', '%a%'])->andReturn($query);
        $query->shouldReceive('where')->withArgs(['b', 'like', '%bc%'])->andReturn($query);
        $query->shouldReceive('orWhere')->withArgs(['c', 'like', '%bc%'])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('paginate')->withAnyArgs(['*'])->andReturn(['a']);

        $query->shouldReceive('where')->withArgs(['d', 'd'])->andReturn($query);

        $searches = [
            'a' => 'a',
            'b,c' => 'bc'
        ];

        $wheres = [
            'd' => 'd'
        ];

        $result = $repo->search($searches, $wheres);
        $this->assertCount(1, $result);
        $this->assertEquals('a', array_shift($result)->attr);
    }


    public function testSearchByEmailPrefix()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->withArgs(['member'])->andReturn($query);
        $query->shouldReceive('whereIn')->withArgs(['id', [1]])->andReturn($query);
        $query->shouldReceive('orderBy')->withArgs(['createdAt', 'desc'])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs()->andReturn(['a']);

        $query2 = $this->makeQuery();
        $conn->shouldReceive('table')->withArgs(['member_mails'])->andReturn($query2);
        $query2->shouldReceive('where')->withArgs(['address', 'like', 'sungbum00@%'])->andReturn($query2);
        $query2->shouldReceive('get')->withArgs([['memberId']])->andReturn([['memberId' => 1]]);

        $result = $repo->searchByEmailPrefix('sungbum00');
        $this->assertEquals('a', array_shift($result)->attr);
    }

    public function testHas()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['id', 1])->andReturn($query);
        $query->shouldReceive('count')->withAnyArgs()->andReturn(1);

        $this->assertEquals(1, $repo->has(1));
    }

    public function testInsert()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('insert')->withArgs(
            [
                ['id' => 1, 'a' => 'b', 'c' => 'd', 'createdAt' => 'now', 'updatedAt' => 'now']
            ]
        )->once()->andReturn(true);

        $entity = $repo->insert(new TestEntity(['a' => 'b', 'c' => 'd']));
        $this->assertEquals(1, $entity->attr['id']);
    }

    public function testUpdate()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['id', 2])->andReturn($query);
        $query->shouldReceive('update')->withArgs(
            [
                ['a' => 'b1', 'c' => 'd1', 'updatedAt' => 'now']
            ]
        )->once()->andReturn(true);

        $entity = $repo->update(new TestEntity(['id' => 2, 'a' => 'b', 'c' => 'd', 'e' => 'f']));
        $this->assertEquals(2, $entity->attr['id']);
    }

    public function testDelete()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['id', 2])->andReturn($query);
        $query->shouldReceive('delete')->withNoArgs()->once()->andReturn(1);

        $numOfRow = $repo->delete(new TestEntity(['id' => 2, 'a' => 'b', 'c' => 'd', 'e' => 'f']));
        $this->assertEquals(1, $numOfRow);
    }

    public function testFindByEmail()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('dynamic')->andReturn($query);
        $query->shouldReceive('where')->withArgs(['id', 1])->andReturn($query);
        $query->shouldReceive('first')->withNoArgs()->once()->andReturn('a');

        $query2 = $this->makeQuery();
        $conn->shouldReceive('table')->withArgs(['member_mails'])->andReturn($query2);
        $query2->shouldReceive('where')->withArgs(['address', 'sungbum00@gmail.com'])->andReturn($query2);
        $query2->shouldReceive('first')->withArgs([['memberId']])->andReturn(['memberId' => 1]);

        $result = $repo->findByEmail('sungbum00@gmail.com');

        $this->assertEquals('a', $result->attr);
    }

    public function testFindByNotExistEmail()
    {
        /** @var \Mockery\MockInterface $conn */
        /** @var \Mockery\MockInterface $query */
        /** @var \Mockery\MockInterface $gen */
        /** @var MemberRepository $repo */
        list($conn, $query, $gen, $repo) = $this->getRepository();

        $conn->shouldReceive('table')->withArgs(['member_mails'])->andReturn($query);
        $query->shouldReceive('where')->withArgs(['address', 'khongchi@gmail.com'])->andReturn($query);
        $query->shouldReceive('first')->withArgs([['memberId']])->andReturnNull();

        $result = $repo->findByEmail('khongchi@gmail.com');
        $this->assertNull($result);
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
        return Mockery::mock(
            '\Xpressengine\Keygen\Keygen',
            [
                'generate' => 1
            ]
        );
    }

    protected function getRepository()
    {
        $query = $this->makeQuery();
        $conn = $this->makeConnection();
        $gen = $this->makeGenerator();
        $repo = new MemberRepository($conn, $gen);
        $repo->entityClass = TestEntity::class;

        return [$conn, $query, $gen, $repo];
    }
}

class MemberRepository extends TargetMemberRepository
{
    protected function getCurrentTime()
    {
        return 'now';
    }
}


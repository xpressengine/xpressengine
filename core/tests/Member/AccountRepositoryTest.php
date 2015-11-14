<?php
namespace Xpressengine\Tests\Member;

use Mockery;
use Xpressengine\Member\Repositories\Database\AccountRepository as TargetAccountRepository;

class AccountRepositoryTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }


    public function testConstruct()
    {
        /** @var MemberRepository $repo */
        $repo = $this->getRepository();
        $this->assertInstanceOf('Xpressengine\Member\Repositories\Database\AccountRepository', $repo);
    }

    public function testFetchAllByMember()
    {

        $query = $this->makeQuery();

        $query->shouldReceive('whereIn')->withArgs(['memberId', [1]])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs(['*'])->andReturn(['a']);

        $conn = $this->makeConnection();
        $conn->shouldReceive('table')->andReturn($query);

        $repo = $this->getRepository($conn);

        $members = $repo->fetchAllByMember(1);
        $this->assertCount(1, $members);
        $this->assertEquals('a', $members[0]->attr);
    }

    public function testFetchAllByMemberReturnEmptyIfNoMemberFound()
    {

        $query = $this->makeQuery();
        $query->shouldReceive('whereIn')->withArgs(['memberId', [1]])->andReturn($query);
        $query->shouldReceive('get')->withAnyArgs(['*'])->andReturn([]);

        $conn = $this->makeConnection();
        $conn->shouldReceive('table')->andReturn($query);

        $repo = $this->getRepository($conn);

        $members = $repo->fetchAllByMember(1);
        $this->assertEquals([], $members);
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

    protected function getRepository($conn = null, $gen = null)
    {
        if ($conn === null) {
            $conn = $this->makeConnection();
        }
        if ($gen === null) {
            $gen = $this->makeGenerator();
        }
        $repo = new AccountRepository($conn, $gen);
        $repo->entityClass = TestEntity::class;

        return $repo;
    }
}


class AccountRepository extends TargetAccountRepository
{
    protected function getCurrentTime()
    {
        return 'now';
    }
}


<?php
namespace Xpressengine\Tests\Member;

use Mockery;
use Xpressengine\Member\Entities\MailEntityInterface;
use Xpressengine\Member\Repositories\Database\PendingMailRepository;
use Xpressengine\Member\Repositories\PendingMailRepositoryInterface;

class PendingMailRepositoryTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $conn = $this->makeConnection();

        $this->assertInstanceOf(PendingMailRepositoryInterface::class, new PendingMailRepository($conn));
    }

    public function testInsert()
    {

        $entity = Mockery::mock(MailEntityInterface::class);
        $entity->shouldReceive('getAttributes')->once()->andReturn(['id'=>'foo','address'=>'bar']);

        $query = $this->makeQuery();
        $query->shouldReceive('insertGetId')->with(Mockery::type('array'))->once()->andReturn('foo');

        $conn = $this->makeConnection();
        $conn->shouldReceive('table')->with('member_pending_mails')->once()->andReturn($query);

        $repo = $this->getRepository($conn);

        $mail = $repo->insert($entity);

        $this->assertInstanceOf(MailEntityInterface::class, $mail);
        $this->assertEquals($entity, $mail);
    }

    public function testFindByAddress()
    {
        $query = $this->makeQuery();
        $query->shouldReceive('where')->with('address', 'foo@gmail.com')->once()->andReturn($query);

        $query->shouldReceive('first')->once()->withNoArgs()->andReturn(
            ['id' => 1, 'address' => 'foo@gmail.com', 'memberId' => 'bar']
        );

        $conn = $this->makeConnection();
        $conn->shouldReceive('table')->with('member_pending_mails')->once()->andReturn($query);

        $repo = $this->getRepository($conn);

        $mail = $repo->findByAddress('foo@gmail.com');

        $this->assertInstanceOf(MailEntityInterface::class, $mail);
        $this->assertEquals(1, $mail->id);
    }

    private function makeQuery()
    {
        return Mockery::mock('\Xpressengine\Database\DynamicQuery');
    }

    private function makeConnection()
    {
        return Mockery::mock('\Xpressengine\Database\VirtualConnectionInterface');
    }

    protected function getRepository($conn = null)
    {
        if ($conn === null) {
            $conn = $this->makeConnection();
        }

        $repo = Mockery::mock(
            '\Xpressengine\Member\Repositories\Database\PendingMailRepository[getCurrentTime]',
            [$conn]
        )->shouldAllowMockingProtectedMethods();
        $repo->shouldReceive('getCurrentTime')->andReturn('now');

        return $repo;
    }
}

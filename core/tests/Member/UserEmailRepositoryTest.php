<?php
namespace Xpressengine\Tests\Member;

use Mockery;
use Xpressengine\User\Models\User;
use Xpressengine\User\Repositories\UserEmailRepository;

class UserEmailRepositoryTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        /** @var UserEmailRepository $repo */
        $repo = $this->makeRepository();
        $this->assertInstanceOf('Xpressengine\User\Repositories\UserEmailRepository', $repo);
    }

    public function testCreate()
    {
        $data = [
            'foo' => 'foo'
        ];

        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $email = $this->makeEmail();
        $email->shouldReceive('create')->withArgs([$data])->once()->andReturnSelf();

        $emails = Mockery::mock('\Illuminate\Database\Eloquent\Relations\HasOne');
        $emails->shouldReceive('save')->with($email)->andReturnNull();

        $user->shouldReceive('emails')->once()->andReturn($emails);

        $repo->shouldReceive('createModel')->andReturn($email);

        /** @var UserEmailRepository $repo */
        /** @var User $user */
        $this->assertEquals($email, $repo->create($user, $data));
    }

    public function testFindByUserId()
    {
        $userId = '123';
        $emails = ['foo'];
        $repo = $this->makeRepository();

        $email = $this->makeEmail();
        $email->shouldReceive('newQuery')->once()->andReturnSelf();
        $email->shouldReceive('where')->once()->with('userId', $userId)->andReturnSelf();
        $email->shouldReceive('get')->once()->withNoArgs()->andReturn($emails);

        $repo->shouldReceive('createModel')->andReturn($email);

        /** @var UserEmailRepository $repo */
        /** @var User $user */
        $this->assertEquals($emails, $repo->findByUserId($userId));
    }

    public function testFindByAddress()
    {
        $address = 'email@address.com';
        $expected = 'foo';
        $repo = $this->makeRepository();

        $email = $this->makeEmail();
        $email->shouldReceive('newQuery')->once()->andReturnSelf();
        $email->shouldReceive('where')->once()->with('address', $address)->andReturnSelf();
        $email->shouldReceive('first')->once()->withNoArgs()->andReturn($expected);

        $repo->shouldReceive('createModel')->andReturn($email);

        /** @var UserEmailRepository $repo */
        /** @var User $user */
        $this->assertEquals($expected, $repo->findByAddress($address));
    }

    public function testDeleteByUserIds()
    {
        $userId = '123';
        $repo = $this->makeRepository();

        $email = $this->makeEmail();
        $email->shouldReceive('newQuery')->once()->andReturnSelf();
        $email->shouldReceive('whereIn')->once()->with('userId', ['123'])->andReturnSelf();
        $email->shouldReceive('delete')->once()->withNoArgs()->andReturn(2);

        $repo->shouldReceive('createModel')->andReturn($email);

        /** @var UserEmailRepository $repo */
        /** @var User $user */
        $this->assertEquals(2, $repo->deleteByUserIds($userId));
    }

    /**
     * getRepository
     *
     * @param null $model
     *
     * @return Mockery\MockInterface
     */
    protected function makeRepository()
    {
        $repo = Mockery::mock('\Xpressengine\User\Repositories\UserEmailRepository')->makePartial();
        return $repo;
    }

    /**
     * makeUser
     *
     * @return Mockery\MockInterface
     */
    private function makeUser()
    {
        return Mockery::mock('\Xpressengine\User\Models\User');
    }

    /**
     * makeEmail
     *
     * @return Mockery\MockInterface
     */
    private function makeEmail()
    {
        return Mockery::mock('\Xpressengine\User\Models\UserEmail');
    }


}


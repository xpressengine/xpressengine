<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Mockery;
use Xpressengine\User\Models\User;
use Xpressengine\User\Repositories\UserEmailRepository;

class UserEmailRepositoryTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        /** @var UserEmailRepository $repo */
        $repo = new UserEmailRepository('foo');
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
        $email->shouldReceive('where')->once()->with('user_id', $userId)->andReturnSelf();
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

    /**
     * testDeleteWhenEmailIsMainEmail
     *
     * @expectedException \Xpressengine\User\Exceptions\CannotDeleteMainEmailOfUserException
     */
    public function testDeleteWhenEmailIsMainEmail()
    {
        $user = $this->makeUser();
        $user->shouldReceive('hasMacro')->andReturn(false);
        $user->shouldReceive('getAttribute')->with('email')->once()->andReturn('foo@email.com');

        $repo = $this->makeRepository();

        $email = $this->makeEmail();
        $email->shouldReceive('hasMacro')->andReturn(false);
        $email->shouldReceive('getAttribute')->with('user')->once()->andReturn($user);
        //$email->shouldReceive('delete')->once()->withNoArgs()->andReturn(2);
        $email->shouldReceive('getAddress')->once()->withNoArgs()->andReturn('foo@email.com');

        /** @var UserEmailRepository $repo */
        $repo->delete($email);
    }

    public function testDelete()
    {
        $user = $this->makeUser();
        $user->shouldReceive('hasMacro')->andReturn(false);
        $user->shouldReceive('getAttribute')->with('email')->once()->andReturn('foo@email.com');

        $repo = $this->makeRepository();

        $email = $this->makeEmail();
        $email->shouldReceive('hasMacro')->andReturn(false);
        $email->shouldReceive('getAttribute')->with('user')->once()->andReturn($user);
        $email->shouldReceive('delete')->once()->withNoArgs()->andReturn(2);
        $email->shouldReceive('getAddress')->once()->withNoArgs()->andReturn('bar@email.com');

        /** @var UserEmailRepository $repo */
        $repo->delete($email);
    }

    public function testDeleteByUserIds()
    {
        $userId = '123';
        $repo = $this->makeRepository();

        $email = $this->makeEmail();
        $email->shouldReceive('newQuery')->once()->andReturnSelf();
        $email->shouldReceive('whereIn')->once()->with('user_id', ['123'])->andReturnSelf();
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


<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Mockery;
use Xpressengine\User\Models\User;
use Xpressengine\User\Repositories\UserRepository;

class UserRepositoryTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testCreateWithPassword()
    {
        $data = [
            'foo' => 'foo',
            'password' => 'secret'
        ];

        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $user->shouldReceive('freshTimestamp')->once()->andReturn('timestamp');

        $data2 = [
            'foo' => 'foo',
            'password' => 'secret',
            'password_updated_at' => 'timestamp'
        ];

        $user->shouldReceive('create')->once()->with($data2)->andReturnSelf();

        $repo->shouldReceive('createModel')->andReturn($user);

        /** @var User $user */
        /** @var UserRepository $repo */
        $this->assertEquals($user, $repo->create($data));

    }

    public function testCreateWithoutPassword()
    {
        $data = [
            'foo' => 'foo'
        ];

        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $user->shouldReceive('create')->once()->with($data)->andReturnSelf();

        $repo->shouldReceive('createModel')->andReturn($user);

        /** @var User $user */
        /** @var UserRepository $repo */
        $this->assertEquals($user, $repo->create($data));
    }

    public function testUpdateWithoutPassword()
    {
        $data = [
            'foo' => 'foo'
        ];

        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $user->shouldReceive('isDirty')->once()->with('password')->andReturn(false);
        $user->shouldReceive('update')->once()->with($data)->andReturn(false);

        $repo->shouldReceive('createModel')->andReturn($user);

        /** @var User $user */
        /** @var UserRepository $repo */
        $this->assertEquals($user, $repo->update($user, $data));
    }

    public function testUpdateWithSamePassword()
    {
        $data = [
            'foo' => 'foo',
            'password' => 'secret'
        ];

        $repo = $this->makeRepository();

        $user = $this->makeUser();
        $user->shouldReceive('hasMacro')->andReturn(false);
        $user->shouldReceive('getAttribute')->with('password')->once()->andReturn('secret');

        $user->shouldReceive('isDirty')->once()->with('password')->andReturn(false);
        $user->shouldReceive('update')->once()->with($data)->andReturnSelf();

        $repo->shouldReceive('createModel')->andReturn($user);

        /** @var User $user */
        /** @var UserRepository $repo */
        $this->assertEquals($user, $repo->update($user, $data));
    }

    public function testUpdateWithDifferentPassword()
    {
        $data = [
            'foo' => 'foo',
            'password' => 'secret'
        ];

        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $user->shouldReceive('hasMacro')->andReturn(false);
        $user->shouldReceive('getAttribute')->once()->andReturn('secret2');

        $user->shouldReceive('isDirty')->once()->with('password')->andReturn(false);

        $data2 = [
            'foo' => 'foo',
            'password' => 'secret',
            'password_updated_at' => 'timestamp'
        ];
        $user->shouldReceive('freshTimestamp')->once()->andReturn('timestamp');
        $user->shouldReceive('update')->once()->with($data2)->andReturnSelf();

        $repo->shouldReceive('createModel')->andReturn($user);

        /** @var User $user */
        /** @var UserRepository $repo */
        $this->assertEquals($user, $repo->update($user, $data));
    }

    public function testFindByEmail()
    {
        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $query = $this->makeQuery();

        $validator = function($callable) use ($query) {
            $callable($query);
            return true;
        };

        $query->shouldReceive('whereHas')->with('emails', \Mockery::on($validator))->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn($user);
        $query->shouldReceive('where')->once()->with('address', 'foo@email.com')->andReturnSelf();

        $user->shouldReceive('newQuery')->once()->andReturn($query);

        $repo->shouldReceive('createModel')->andReturn($user);

        $this->assertEquals($user, $repo->findByEmail('foo@email.com'));
    }

    public function testSearchByEmailPrefix()
    {
        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $query = $this->makeQuery();

        $validator = function($callable) use ($query) {
            $callable($query);
            return true;
        };

        $query->shouldReceive('whereHas')->with('emails', \Mockery::on($validator))->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn($user);
        $query->shouldReceive('where')->once()->with('address', 'like', 'foo@%')->andReturnSelf();

        $user->shouldReceive('newQuery')->once()->andReturn($query);

        $repo->shouldReceive('createModel')->andReturn($user);

        $this->assertEquals($user, $repo->searchByEmailPrefix('foo'));
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
        $repo = Mockery::mock('\Xpressengine\User\Repositories\UserRepository')->makePartial();
        return $repo;
    }

    /**
     * makeUser
     *
     * @return Mockery\MockInterface
     */
    private function makeUser()
    {
        return Mockery::mock(\Xpressengine\User\Models\User::class);
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

    /**
     * makeQuery
     *
     * @return Mockery\MockInterface
     */
    private function makeQuery()
    {
        return Mockery::mock('\Illuminate\Database\Eloquent\Builder');
    }

}

<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\Eloquent\Collection;
use Mockery as m;
use Xpressengine\User\UserInterface;
use Xpressengine\User\UserProvider;

class UserProviderTest extends \PHPUnit\Framework\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testRetrieveByCredentialsReturnsUser()
    {

        $user = $this->getUser();
        $query = $this->makeQuery();

        $query->shouldReceive('where')->once()->with('id', 1)->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn($user);

        $user->shouldReceive('newQuery')->once()->andReturn($query);
        $user->id = 1;

        $credentials = [
            'id' => 1,
            'password' => 'foo'
        ];

        $provider = $this->getProvider();
        $provider->shouldReceive('createModel')->andReturn($user);

        $provider->dispatcher->shouldReceive('dispatch')->once();
        $this->assertEquals($user, $provider->retrieveByCredentials($credentials));
    }

    public function testRetrieveByCredentialsWithEmailReturnsUser()
    {
        $email = 'foo@xpressengine.com';
        $user = $this->getUser();
        $query = $this->makeQuery();

        $validator = function($callback) use($query, $email) {
            $query->shouldReceive('where')->once()->with('address', $email)->andReturnSelf();
            $callback($query);
            return true;
        };

        $query->shouldReceive('whereHas')->once()->with('emails', m::on($validator))->andReturnSelf();
        $query->shouldReceive('first')->once()->andReturn($user);

        $user->shouldReceive('newQuery')->once()->andReturn($query);
        $user->id = 1;

        $credentials = [
        'email' => $email,
        'id' => 1,
        'password' => 'foo'
        ];

        $provider = $this->getProvider();
        $provider->shouldReceive('createModel')->andReturn($user);

        $provider->dispatcher->shouldReceive('dispatch')->once();
        $this->assertEquals($user, $provider->retrieveByCredentials($credentials));
    }

    public function testRetrieveByCredentialsWithEmailPrefixReturnsUser()
    {
        $user = $this->getUser();
        $query = $this->makeQuery();

        $validator = function($callback) use($query) {
            $query->shouldReceive('where')->once()->with('address', 'like', 'foo@%')->andReturnSelf();
            $callback($query);
            return true;
        };

        $query->shouldReceive('whereHas')->once()->with('emails', m::on($validator))->andReturnSelf();
        $query->shouldReceive('get')->once()->andReturn(new Collection([$user]));

        $user->shouldReceive('newQuery')->once()->andReturn($query);
        $user->id = 1;

        $credentials = [
            'email' => 'foo',
            'id' => 1,
            'password' => 'foo'
        ];

        $provider = $this->getProvider();
        $provider->shouldReceive('createModel')->andReturn($user);

        $provider->dispatcher->shouldReceive('dispatch')->once();
        $this->assertEquals($user, $provider->retrieveByCredentials($credentials));
    }

    protected function getProvider($model = 'UserModel', $hasher = null, $dispatcher = null)
    {
        if ($hasher === null) {
            $hasher = $this->getHasher();
        }

        if ($dispatcher === null) {
            $dispatcher = m::mock('Illuminate\Contracts\Events\Dispatcher');
        }

        /** @var Hasher $hasher */
        return m::mock(UserProvider::class, [$hasher, $model, $dispatcher])->makePartial();
    }

    /**
     * getHasher
     *
     * @return m\MockInterface
     */
    protected function getHasher()
    {
        return m::mock('Illuminate\Contracts\Hashing\Hasher');
    }

    /**
     * getRepo
     *
     * @return m\MockInterface
     */
    protected function getRepo()
    {
        return m::mock('\Xpressengine\User\Repositories\UserRepositoryInterface');
    }

    private function getUser()
    {
        return m::mock(UserInterface::class);
    }


    /**
     * makeQuery
     *
     * @return m\MockInterface
     */
    private function makeQuery()
    {
        return m::mock('\Illuminate\Database\Eloquent\Builder');
    }
}

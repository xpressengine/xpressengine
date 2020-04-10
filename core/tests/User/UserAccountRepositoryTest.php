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
use Xpressengine\User\Repositories\UserAccountRepository;

class UserAccountRepositoryTest extends \PHPUnit\Framework\TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        /** @var UserAccountRepository $repo */
        $repo = new UserAccountRepository('foo');
        $this->assertInstanceOf('Xpressengine\User\Repositories\UserAccountRepository', $repo);
    }

    public function testCreate()
    {
        $data = [
            'foo' => 'foo'
        ];

        $repo = $this->makeRepository();

        $user = $this->makeUser();

        $account = $this->makeAccount();
        $account->shouldReceive('create')->withArgs([$data])->once()->andReturn($account);

        $accounts = Mockery::mock('\Illuminate\Database\Eloquent\Relations\HasOne');
        $accounts->shouldReceive('save')->with($account)->andReturn($user);

        $user->shouldReceive('accounts')->once()->andReturn($accounts);

        $repo->shouldReceive('createModel')->andReturn($account);

        /** @var UserAccountRepository $repo */
        /** @var User $user */
        $this->assertEquals($account, $repo->create($user, $data));

    }

    public function testFindByUserId()
    {
        $userId = '123';
        $accounts = ['foo'];
        $repo = $this->makeRepository();

        $account = $this->makeAccount();
        $account->shouldReceive('newQuery')->once()->andReturnSelf();
        $account->shouldReceive('where')->once()->with('user_id', $userId)->andReturnSelf();
        $account->shouldReceive('get')->once()->withNoArgs()->andReturn($accounts);

        $repo->shouldReceive('createModel')->andReturn($account);

        /** @var UserAccountRepository $repo */
        /** @var User $user */
        $this->assertEquals($accounts, $repo->findByUserId($userId));
    }

    public function testDeleteByUserIds()
    {
        $userId = '123';
        $repo = $this->makeRepository();

        $account = $this->makeAccount();
        $account->shouldReceive('newQuery')->once()->andReturnSelf();
        $account->shouldReceive('whereIn')->once()->with('user_id', ['123'])->andReturnSelf();
        $account->shouldReceive('delete')->once()->withNoArgs()->andReturn(1);

        $repo->shouldReceive('createModel')->andReturn($account);

        /** @var UserAccountRepository $repo */
        /** @var User $user */
        $this->assertEquals(1, $repo->deleteByUserIds($userId));
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
        $repo = Mockery::mock('\Xpressengine\User\Repositories\UserAccountRepository')->makePartial();
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
     * makeAccount
     *
     * @return Mockery\MockInterface
     */
    private function makeAccount()
    {
        return Mockery::mock('\Xpressengine\User\Models\UserAccount');
    }


}


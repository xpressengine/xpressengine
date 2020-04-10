<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Mockery;

class UserGroupRepositoryTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testDelete()
    {
        $repo = $this->makeRepository();

        $group = $this->makeGroup();
        $group->exists = false;

        $group->shouldReceive('delete')->once()->andReturn(true);

        $this->assertTrue($repo->delete($group));
    }

    public function testDeleteWhenGroupIsNotSaved()
    {
        $repo = $this->makeRepository();

        $group = $this->makeGroup();
        $group->exists = true;
        $group->shouldReceive('users->detach')->andReturnNull();
        $group->shouldReceive('delete')->once()->andReturn(true);

        $this->assertTrue($repo->delete($group));
    }

    public function testAddUser()
    {
        $repo = $this->makeRepository();

        $user = $this->makeUser();
        $group = $this->makeGroup();
        $group->shouldReceive('addUser')->once()->andReturnSelf();

        $this->assertEquals($group, $repo->addUser($group, $user));
    }

    public function testExceptUser()
    {
        $repo = $this->makeRepository();

        $user = $this->makeUser();
        $group = $this->makeGroup();
        $group->shouldReceive('exceptUser')->once()->andReturnSelf();

        $this->assertEquals($group, $repo->exceptUser($group, $user));
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
        $repo = Mockery::mock(\Xpressengine\User\Repositories\UserGroupRepository::class)->makePartial();
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
     * makeGroup
     *
     * @return Mockery\MockInterface
     */
    private function makeGroup()
    {
        return Mockery::mock(\Xpressengine\User\Models\UserGroup::class);
    }

    /**
     * makeQuery
     *
     * @return Mockery\MockInterface
     */
    private function makeQuery()
    {
        return Mockery::mock(\Illuminate\Database\Eloquent\Builder::class);
    }

}

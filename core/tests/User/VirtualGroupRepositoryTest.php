<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\User;

use Mockery;
use Xpressengine\User\Repositories\VirtualGroupRepository;

class VirtualGroupRepositoryTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $repo = $this->makeRepository();
        $this->assertInstanceOf(\Xpressengine\User\Repositories\VirtualGroupRepository::class, $repo);
    }

    public function testFind()
    {
        $repo = $this->makeRepository();
        $group = $repo->find('facebook');
        $this->assertEquals('fb_group', $group['title']);
    }

    public function testFindByTitle()
    {
        $repo = $this->makeRepository();
        $group = $repo->findByTitle('fb_group');
        $this->assertEquals('fb_group', $group['title']);
    }

    public function testFindByUserId()
    {
        $users = $this->makeUsers();
        $user = $this->makeUser();
        $user->shouldReceive('getAccountByProvider')->times(3)->andReturn(true, false, false);

        $users->shouldReceive('find')->once()->with('user123')->andReturn($user);

        $repo = $this->makeRepository($users);
        $groups = $repo->findByUserId('user123');

        $this->assertCount(1, $groups);
        foreach ($groups as $group) {
            $this->assertInstanceOf(\Xpressengine\User\Models\UserVirtualGroup::class, $group);
        }
    }

    public function testAll()
    {
        $repo = $this->makeRepository();

        $groups = $repo->all();
        $this->assertCount(3, $groups);
        foreach ($groups as $group) {
            $this->assertInstanceOf(\Xpressengine\User\Models\UserVirtualGroup::class, $group);
        }
    }

    public function testHas()
    {
        $repo = $this->makeRepository();

        $this->assertTrue($repo->has('naver'));
        $this->assertFalse($repo->has('naver2'));
    }



    /**
     * getRepository
     *
     * @param null $model
     *
     * @return VirtualGroupRepository
     */
    protected function makeRepository($users = null, $vGroups = null, $getter = null)
    {

        $vGroups = $vGroups?:[
            'facebook' => [
                'title' => 'fb_group'
            ],
            'naver' => [
                'title' => 'naver_group'
            ],
            'github' => [
                'title' => 'github_group'
            ],
        ];
        $getter = $getter?:function ($user) {
            $providers = [];
            if ($user->getAccountByProvider('facebook')) {
                $providers[] = 'facebook';
            }
            if ($user->getAccountByProvider('naver')) {
                $providers[] = 'naver';
            }
            if ($user->getAccountByProvider('github')) {
                $providers[] = 'github';
            }
            return $providers;
        };

        $users = $users?:$this->makeUsers();

        return new VirtualGroupRepository($users, $vGroups, $getter);
    }


    /**
     * getRepository
     *
     * @param null $model
     *
     * @return Mockery\MockInterface
     */
    protected function makeUsers()
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

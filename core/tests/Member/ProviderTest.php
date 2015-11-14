<?php
namespace Xpressengine\Tests\Member;

use Mockery as m;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Provider;

class ProviderTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testRetrieveByIDReturnsUser()
    {
        $member = $this->getMember();
        $member->id = 1;
        $repo = $this->getRepo();
        $repo->shouldReceive('find')->with(1, \Mockery::type('array'))->andReturn($member);
        $provider = $this->getProvider($repo);

        $user = $provider->retrieveById(1);
        $this->assertEquals(1, $user->id);
    }

    public function testRetrieveByCredentialsReturnsUser()
    {
        $member = $this->getMember();
        $member->id = 1;

        $credentials = [
            'id' => 1,
            'password' => 'foo'
        ];

        $repo = $this->getRepo();
        $repo->shouldReceive('fetchOne')->with(['id'=>1], \Mockery::type('array'))->once()->andReturn($member);
        $provider = $this->getProvider($repo);

        $user = $provider->retrieveByCredentials($credentials);
        $this->assertEquals(1, $user->id);
    }

    public function testRetrieveByCredentialsWithEmailReturnsUser()
    {
        $member = $this->getMember();
        $member->id = 1;
        $member->shouldReceive('setEmailForPasswordReset')->once()->andReturnNull();

        $credentials = [
            'email' => 'foo@xpressengine.com',
            'password' => 'foo'
        ];

        $repo = $this->getRepo();
        $repo->shouldReceive('findByEmail')->with('foo@xpressengine.com', \Mockery::type('array'))->andReturn($member);
        $provider = $this->getProvider($repo);

        $user = $provider->retrieveByCredentials($credentials);
        $this->assertEquals(1, $user->id);
    }

    public function testRetrieveByCredentialsWithEmailPrefixReturnsUser()
    {
        $member = $this->getMember();
        $member->id = 1;

        $credentials = [
            'email' => 'foo',
            'password' => 'foo'
        ];

        $repo = $this->getRepo();
        $repo->shouldReceive('searchByEmailPrefix')->with('foo', \Mockery::type('array'))->andReturn([$member]);
        $provider = $this->getProvider($repo);

        $user = $provider->retrieveByCredentials($credentials);
        $this->assertEquals(1, $user->id);
    }

    protected function getProvider($repo = null, $hasher = null)
    {
        if ($repo === null) {
            $repo = $this->getRepo();
        }
        if ($hasher === null) {
            $hasher = $this->getHasher();
        }
        return new Provider($repo, $hasher);
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
        return m::mock('\Xpressengine\Member\Repositories\MemberRepositoryInterface');
    }

    private function getMember()
    {
        return m::mock(MemberEntityInterface::class);
    }
}

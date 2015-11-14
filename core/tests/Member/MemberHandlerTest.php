<?php
namespace Xpressengine\Tests\Member;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Mockery;
use Xpressengine\Member\AssociateInterface;
use Xpressengine\Member\Entities\Guest;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Member\Rating;
use Xpressengine\Member\Repositories\AccountRepositoryInterface;
use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;
use Xpressengine\Member\Repositories\PendingMailRepositoryInterface;
use Xpressengine\Member\Repositories\VirtualGroupRepositoryInterface;
use Xpressengine\Register\Container;

class MemberHandlerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tears down the fixture, for example, close a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }


    public function testAssociates()
    {
        $member1 = Mockery::mock(
            MemberEntityInterface::class,
            [
                'getId' => 1
            ]
        );
        $member2 = Mockery::mock(
            MemberEntityInterface::class,
            [
                'getId' => 2
            ]
        );

        $handler = $this->getHandler();

        $members = $handler->getMemberRepository();
        $members->shouldReceive('findAll')->with([1, 2])->andReturn([$member1, $member2]);
        $members->shouldReceive('findAll')->with([1])->andReturn([$member1]);

        $entity1 = Mockery::mock(AssociateInterface::class);
        $entity1->shouldReceive('getMemberOriginId')->andReturn(1);
        $entity1->shouldReceive('setMemberEntity')->once()->withArgs([$member1])->andReturnNull();

        $entity2 = Mockery::mock(AssociateInterface::class);
        $entity2->shouldReceive('getMemberOriginId')->andReturn(2);
        $entity2->shouldReceive('setMemberEntity')->once()->withArgs([$member2])->andReturnNull();

        $entities = [$entity1, $entity2];
        $handler->associates($entities);
    }

    public function testAssociatesNullMember()
    {
        $member1 = Mockery::mock(
            MemberEntityInterface::class,
            [
                'getId' => 1
            ]
        );

        $handler = $this->getHandler();

        $members = $handler->getMemberRepository();
        $members->shouldReceive('findAll')->with([1])->andReturn([$member1]);

        $entity1 = Mockery::mock(AssociateInterface::class);
        $entity1->shouldReceive('getMemberOriginId')->andReturn(1);
        $entity1->shouldReceive('setMemberEntity')->once()->withArgs([$member1])->andReturnNull();

        $entity2 = Mockery::mock(AssociateInterface::class);
        $entity2->shouldReceive('getMemberOriginId')->andReturnNull();
        $entity2->shouldReceive('setMemberEntity')->once()->with(Mockery::type(Guest::class))->andReturnNull();

        $entities = [$entity1, $entity2];
        $handler->associates($entities);
    }

    /**
     * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
     */
    public function testValidateForCreateFail()
    {
        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo'
        ];
        $handler = $this->getHandler();
        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
     */
    public function testValidateForCreateWithoutEmailAndAccount()
    {
        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => MemberHandler::STATUS_ACTIVATED
        ];
        $handler = $this->getHandler();
        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Member\Exceptions\MailAlreadyExistsException
     */
    public function testValidateForCreateWithExistingEmail()
    {
        $members = $this->getMembers();
        $accounts = $this->getAccounts();
        $groups = $this->getGroups();
        $vgroups = $this->getVgroups();
        $mails = $this->getMails();
        $pendingMails = $this->getPendingMails();
        $hasher = $this->getHasher();
        $validator = $this->getValidator();
        $container = $this->getContainer();
        $handler = Mockery::mock(
            '\Xpressengine\Member\MemberHandler[findMailByAddress]',
            [
                $members,
                $accounts,
                $groups,
                $vgroups,
                $mails,
                $pendingMails,
                $hasher,
                $validator,
                $container,
                true
            ]
        );
        $handler->shouldReceive('findMailByAddress')->once()->andReturn('foo');

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => MemberHandler::STATUS_ACTIVATED,
            'email' => 'foo@xpressengine.com'
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
     */
    public function testValidateForCreateWithEmptyDisplayName()
    {
        $members = $this->getMembers();
        $accounts = $this->getAccounts();
        $groups = $this->getGroups();
        $vgroups = $this->getVgroups();
        $mails = $this->getMails();
        $pendingMails = $this->getPendingMails();
        $hasher = $this->getHasher();
        $validator = $this->getValidator();
        $container = $this->getContainer();
        $handler = Mockery::mock(
            '\Xpressengine\Member\MemberHandler[findMailByAddress]',
            [
                $members,
                $accounts,
                $groups,
                $vgroups,
                $mails,
                $pendingMails,
                $hasher,
                $validator,
                $container,
                true
            ]
        );
        $handler->shouldReceive('findMailByAddress')->once()->andReturnNull();

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => '',
            'status' => MemberHandler::STATUS_ACTIVATED,
            'email' => 'foo@xpressengine.com'
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Member\Exceptions\DuplicateDisplayNameException
     */
    public function testValidateForCreateWithExistingDisplayName()
    {
        $members = $this->getMembers();
        $members->shouldReceive('fetchOne')->with(['displayName' => 'foo'])->once()->andReturn('foo');

        $accounts = $this->getAccounts();
        $groups = $this->getGroups();
        $vgroups = $this->getVgroups();
        $mails = $this->getMails();
        $pendingMails = $this->getPendingMails();
        $hasher = $this->getHasher();


        $validate = Mockery::mock(
            Validator::class, [
            'fails' => false
        ]);

        $validator = $this->getValidator();
        $validator->shouldReceive('make')->once()->andReturn($validate);

        $container = $this->getContainer();
        $handler = Mockery::mock(
            '\Xpressengine\Member\MemberHandler[findMailByAddress]',
            [
                $members,
                $accounts,
                $groups,
                $vgroups,
                $mails,
                $pendingMails,
                $hasher,
                $validator,
                $container,
                true
            ]
        );
        $handler->shouldReceive('findMailByAddress')->once()->andReturnNull();

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => MemberHandler::STATUS_ACTIVATED,
            'email' => 'foo@xpressengine.com'
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
     */
    public function testValidateForCreateWithInvalidAccount()
    {
        $members = $this->getMembers();
        $members->shouldReceive('fetchOne')->with(['displayName' => 'foo'])->once()->andReturnNull();
        $accounts = $this->getAccounts();
        $groups = $this->getGroups();
        $vgroups = $this->getVgroups();
        $mails = $this->getMails();
        $pendingMails = $this->getPendingMails();
        $hasher = $this->getHasher();

        $validate = Mockery::mock(
            Validator::class, [
            'fails' => false
        ]);

        $validator = $this->getValidator();
        $validator->shouldReceive('make')->once()->andReturn($validate);

        $container = $this->getContainer();
        $handler = Mockery::mock(
            '\Xpressengine\Member\MemberHandler[findMailByAddress]',
            [
                $members,
                $accounts,
                $groups,
                $vgroups,
                $mails,
                $pendingMails,
                $hasher,
                $validator,
                $container,
                true
            ]
        );
        $handler->shouldReceive('findMailByAddress')->once()->andReturnNull();

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => MemberHandler::STATUS_ACTIVATED,
            'email' => 'foo@xpressengine.com',
            'account' => []
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Member\Exceptions\AccountAlreadyExistsException
     */
    public function _testValidateForCreateWithExistingAccount()
    {
        $members = $this->getMembers();
        $accounts = $this->getAccounts();
        $groups = $this->getGroups();
        $vgroups = $this->getVgroups();
        $mails = $this->getMails();
        $pendingMails = $this->getPendingMails();
        $hasher = $this->getHasher();
        $validator = $this->getValidator();
        $container = $this->getContainer();
        $handler = Mockery::mock(
            '\Xpressengine\Member\MemberHandler',
            [
                $members,
                $accounts,
                $groups,
                $vgroups,
                $mails,
                $pendingMails,
                $hasher,
                $validator,
                $container,
                true
            ]
        )->makePartial();
        $handler->shouldReceive('findMailByAddress')->once()->andReturnNull();
        $handler->shouldReceive('fetchOne')->with(['displayName' => 'foo'])->once()->andReturnNull();
        $handler->shouldReceive('fetchOneAccount')
            ->with(['accountId' => 'foo', 'provider' => 'foo'])
            ->once()
            ->andReturn('foo');

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => MemberHandler::STATUS_ACTIVATED,
            'email' => 'foo@xpressengine.com',
            'account' => [
                'accountId' => 'foo',
                'provider' => 'foo',
                'data' => 'foo',
                'token' => 'foo',
            ]
        ];

        $handler->validateForCreate($data);
    }

    public function testCallMagicMethodForFind()
    {
        $members = $this->getMembers();
        $members->shouldReceive('find')->with(1)->once()->andReturn('foo');

        $handler = $this->getHandler(
            $members,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertEquals('foo', $handler->findMember(1));

    }

    public function testCallMagicMethodForFindAll()
    {
        $members = $this->getMembers();
        $members->shouldReceive('findAll')->with(1)->once()->andReturn('foo');

        $handler = $this->getHandler(
            $members,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertEquals('foo', $handler->findAll(1));
    }

    public function testCallMagicMethodForFindAllAccount()
    {
        $accounts = $this->getAccounts();
        $accounts->shouldReceive('findAll')->with(1)->once()->andReturn('foo');

        $handler = $this->getHandler(
            null,
            $accounts,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $this->assertEquals('foo', $handler->findAllAccount(1));
    }

    /**
     * testCallMagicMethodForInvalidMethod
     *
     * @expectedException \BadMethodCallException
     */
    public function testCallMagicMethodForInvalidMethod()
    {
        $handler = $this->getHandler(
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null,
            null
        );

        $handler->findGroupAll(1);
    }

    /**
     * createMembers
     *
     * @return \Xpressengine\Member\MemberHandler
     */
    private function getHandler(
        $members = null,
        $accounts = null,
        $groups = null,
        $vgroups = null,
        $mails = null,
        $pendingMails = null,
        $hasher = null,
        $validator = null,
        $container = null
    ) {
        if ($members === null) {
            $members = $this->getMembers();
        }
        if ($accounts === null) {
            $accounts = $this->getAccounts();
        }
        if ($groups === null) {
            $groups = $this->getGroups();
        }
        if ($vgroups === null) {
            $vgroups = $this->getVgroups();
        }
        if ($mails === null) {
            $mails = $this->getMails();
        }
        if ($pendingMails === null) {
            $pendingMails = $this->getPendingMails();
        }
        if ($hasher === null) {
            $hasher = $this->getHasher();
        }
        if ($validator === null) {
            $validator = $this->getValidator();
        }
        if ($container === null) {
            $container = $this->getContainer();
        }

        $handler = new MemberHandler(
            $members,
            $accounts,
            $groups,
            $vgroups,
            $mails,
            $pendingMails,
            $hasher,
            $validator,
            $container,
            true
        );
        return $handler;
    }

    protected function getMembers()
    {
        return Mockery::mock(MemberRepositoryInterface::class);
    }

    protected function getAccounts()
    {
        return Mockery::mock(AccountRepositoryInterface::class);
    }

    protected function getGroups()
    {
        return Mockery::mock(GroupRepositoryInterface::class);
    }

    protected function getVgroups()
    {
        return Mockery::mock(VirtualGroupRepositoryInterface::class);
    }

    protected function getMails()
    {
        return Mockery::mock(MailRepositoryInterface::class);
    }

    protected function getPendingMails()
    {
        return Mockery::mock(PendingMailRepositoryInterface::class);
    }

    protected function getHasher()
    {
        return Mockery::mock(Hasher::class);
    }

    protected function getValidator()
    {
        return Mockery::mock(Factory::class);
    }

    protected function getContainer()
    {
        return Mockery::mock(Container::class);
    }

}

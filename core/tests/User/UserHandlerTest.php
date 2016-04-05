<?php
namespace Xpressengine\Tests\User;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Mockery;
use Xpressengine\Register\Container;
use Xpressengine\User\Rating;
use Xpressengine\User\Repositories\PendingEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserAccountRepositoryInterface;
use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;
use Xpressengine\User\Repositories\UserRepositoryInterface;
use Xpressengine\User\Repositories\VirtualGroupRepositoryInterface;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserImageHandler;

class UserHandlerTest extends \PHPUnit_Framework_TestCase
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

    public function testCreate()
    {
        /** @var Mockery\MockInterface $hasher */
        $hasher = $this->getHasher();
        $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');
        /** @var Mockery\MockInterface $handler */
        $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher);
        $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

        $data = [
            'displayName' => 'foo',
            'password' => 'secret',
        ];

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $user = $this->makeUser();
        $users->shouldReceive('create')
            ->once()
            ->with(['displayName' => 'foo', 'password' => 'encrypted'])
            ->andReturn($user);

        $this->assertEquals($user, $handler->create($data));
    }

    public function testCreateWithEmail()
    {
        /** @var Mockery\MockInterface $hasher */
        $hasher = $this->getHasher();
        $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');
        /** @var Mockery\MockInterface $handler */
        $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher);
        $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

        $data = [
            'displayName' => 'foo',
            'password' => 'secret',
            'email' => 'foo@bar.com',
            'emailConfirmed' => true,
        ];

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $user = $this->makeUser();
        $user->shouldReceive('getAttribute')->once()->with('email')->andReturn('foo@bar.com');
        $user->shouldReceive('getAttribute')->once()->with('id')->andReturn('baz');

        $users->shouldReceive('create')
            ->once()
            ->with(['displayName' => 'foo', 'password' => 'encrypted', 'email'=>'foo@bar.com'])
            ->andReturn($user);

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->emails();
        $email = $this->makeEmail();
        $emails->shouldReceive('create')
            ->once()
            ->with($user, ['userId' => 'baz', 'address' => 'foo@bar.com'])
            ->andReturn($email);

        $this->assertEquals($user, $handler->create($data));
    }

    public function testCreateWithPendingEmail()
    {
        /** @var Mockery\MockInterface $hasher */
        $hasher = $this->getHasher();
        $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');
        /** @var Mockery\MockInterface $handler */
        $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher);
        $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

        $data = [
            'displayName' => 'foo',
            'password' => 'secret',
            'email' => 'foo@bar.com',
            'emailConfirmed' => false,
        ];

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $user = $this->makeUser();
        $user->shouldReceive('getAttribute')->once()->with('email')->andReturn('foo@bar.com');
        $user->shouldReceive('getAttribute')->once()->with('id')->andReturn('baz');

        $users->shouldReceive('create')
            ->once()
            ->with(['displayName' => 'foo', 'password' => 'encrypted', 'email'=>'foo@bar.com'])
            ->andReturn($user);

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->pendingEmails();
        $email = $this->makeEmail();
        $emails->shouldReceive('create')
            ->once()
            ->with($user, ['userId' => 'baz', 'address' => 'foo@bar.com'])
            ->andReturn($email);

        $this->assertEquals($user, $handler->create($data));
    }

    public function testCreateWithGroups()
    {
        /** @var Mockery\MockInterface $hasher */
        $hasher = $this->getHasher();
        $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');
        /** @var Mockery\MockInterface $handler */
        $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher);
        $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

        $data = [
            'displayName' => 'foo',
            'password' => 'secret',
            'groupId' => ['bar','baz']
        ];

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $user = $this->makeUser();
        $user->shouldReceive('joinGroups')->with(['bar','baz'])->andReturnSelf();

        /** @var Mockery\MockInterface $groups */
        $groups = $handler->groups();
        $groups->shouldReceive('whereIn')->once()->with('id', ['bar','baz'])->andReturnSelf();
        $groups->shouldReceive('get')->once()->andReturn([]);

        $users->shouldReceive('create')
            ->once()
            ->with(['displayName' => 'foo', 'password' => 'encrypted'])
            ->andReturn($user);

        $this->assertEquals($user, $handler->create($data));
    }

    public function testCreateWithAccounts()
    {
        /** @var Mockery\MockInterface $hasher */
        $hasher = $this->getHasher();
        $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');
        /** @var Mockery\MockInterface $handler */
        $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher);
        $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

        $data = [
            'displayName' => 'foo',
            'password' => 'secret',
            'account' => [
                'accountId' => 'bar',
                'email' => 'foo@bar.com',
                'provider' => 'baz',
                'data' => [],
                'token' => 'token'
            ]
        ];

        $account = $this->makeAccount();

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $user = $this->makeUser();
        $user->shouldReceive('getAttribute')->once()->with('id')->andReturn('baz');

        $hasMany = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);

        $user->shouldReceive('accounts')->once()->andReturn($hasMany);
        $hasMany->shouldReceive('save')->once()->with($account)->andReturnSelf();

        /** @var Mockery\MockInterface $accounts */
        $accounts = $handler->accounts();
        $accounts->shouldReceive('create')->once()->with($user, [
            'userId' => 'baz',
            'accountId' => 'bar',
            'email' => 'foo@bar.com',
            'provider' => 'baz',
            'data' => [],
            'token' => 'token'
        ])->andReturn($account);

        $users->shouldReceive('create')
            ->once()
            ->with(['displayName' => 'foo', 'password' => 'encrypted'])
            ->andReturn($user);

        $this->assertEquals($user, $handler->create($data));
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
        /** @var UserHandler $handler */
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
            'status' => UserHandler::STATUS_ACTIVATED
        ];
        /** @var UserHandler $handler */
        $handler = $this->getHandler();
        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\User\Exceptions\MailAlreadyExistsException
     */
    public function testValidateForCreateWithExistingEmail()
    {
        /** @var UserHandler $handler */
        $handler = $this->getHandler();

        $email = 'foo@xpressengine.com';

        $emailObj = $this->makeEmail();

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->emails();
        $emails->shouldReceive('findByAddress')->once()->with($email)->andReturn($emailObj);

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => UserHandler::STATUS_ACTIVATED,
            'email' => $email
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
     */
    public function testValidateForCreateWithEmptyDisplayName()
    {
        /** @var UserHandler $handler */
        $handler = $this->getHandler();

        $email = 'foo@xpressengine.com';

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->emails();
        $emails->shouldReceive('findByAddress')->once()->with($email)->andReturnNull();

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => '',
            'status' => UserHandler::STATUS_ACTIVATED,
            'email' => 'foo@xpressengine.com'
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
     */
    public function testValidateForCreateWithInvalidDisplayName()
    {
        $validate = Mockery::mock(
            Validator::class, [
            'fails' => true
        ]);
        $validator = $this->getValidator();
        $validator->shouldReceive('make')->once()->andReturn($validate);

        /** @var UserHandler $handler */
        $handler = $this->getHandler(null, null, null, null, null, null, null, $validator);

        $email = 'foo@xpressengine.com';

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->emails();
        $emails->shouldReceive('findByAddress')->once()->with($email)->andReturnNull();

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => UserHandler::STATUS_ACTIVATED,
            'email' => $email
        ];

        $handler->validateForCreate($data);
    }
    /**
     * @expectedException \Xpressengine\User\Exceptions\DisplayNameAlreadyExistsException
     */
    public function testValidateForCreateWithExistingDisplayName()
    {
        $validate = Mockery::mock(
            Validator::class, [
            'fails' => false
        ]);
        $validator = $this->getValidator();
        $validator->shouldReceive('make')->once()->andReturn($validate);

        /** @var UserHandler $handler */
        $handler = $this->getHandler(null, null, null, null, null, null, null, $validator);

        $email = 'foo@xpressengine.com';

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->emails();
        $emails->shouldReceive('findByAddress')->once()->with($email)->andReturnNull();

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $users->shouldReceive('where')->once()->with(['displayName' => 'foo'])->andReturnSelf();
        $users->shouldReceive('first')->once()->andReturn($this->makeUser());

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => UserHandler::STATUS_ACTIVATED,
            'email' => $email
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
     */
    public function testValidateForCreateWithInvalidAccount()
    {
        $validate = Mockery::mock(
            Validator::class, [
            'fails' => false
        ]);
        $validator = $this->getValidator();
        $validator->shouldReceive('make')->once()->andReturn($validate);

        /** @var UserHandler $handler */
        $handler = $this->getHandler(null, null, null, null, null, null, null, $validator);

        $email = 'foo@xpressengine.com';

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->emails();
        $emails->shouldReceive('findByAddress')->once()->with($email)->andReturnNull();

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $users->shouldReceive('where')->once()->with(['displayName' => 'foo'])->andReturnSelf();
        $users->shouldReceive('first')->once()->andReturnNull();

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => UserHandler::STATUS_ACTIVATED,
            'email' => 'foo@xpressengine.com',
            'account' => []
        ];

        $handler->validateForCreate($data);
    }

    /**
     * @expectedException \Xpressengine\User\Exceptions\AccountAlreadyExistsException
     */
    public function testValidateForCreateWithExistingAccount()
    {
        $validate = Mockery::mock(
            Validator::class, [
            'fails' => false
        ]);
        $validator = $this->getValidator();
        $validator->shouldReceive('make')->once()->andReturn($validate);

        /** @var UserHandler $handler */
        $handler = $this->getHandler(null, null, null, null, null, null, null, $validator);

        $email = 'foo@xpressengine.com';

        /** @var Mockery\MockInterface $emails */
        $emails = $handler->emails();
        $emails->shouldReceive('findByAddress')->once()->with($email)->andReturnNull();

        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $users->shouldReceive('where')->once()->with(['displayName' => 'foo'])->andReturnSelf();
        $users->shouldReceive('first')->once()->andReturnNull();

        /** @var Mockery\MockInterface $accounts */
        $accounts = $handler->accounts();
        $accounts->shouldReceive('where')->once()->with(['accountId'=>'foo','provider'=>'foo'])->andReturnSelf();
        $accounts->shouldReceive('first')->once()->andReturn(true);

        $data = [
            'rating' => Rating::MEMBER,
            'displayName' => 'foo',
            'status' => UserHandler::STATUS_ACTIVATED,
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

    public function testCallMagicMethod()
    {
        $handler = $this->getHandler();
        /** @var Mockery\MockInterface $users */
        $users = $handler->users();
        $users->shouldReceive('foo')->once()->with('bar')->andReturnNull();

        $this->assertNull($handler->foo('bar'));
    }

    /**
     * @return \Xpressengine\User\UserHandler
     */
    private function getHandler(
        $users = null,
        $accounts = null,
        $groups = null,
        $emails = null,
        $pendingEmails = null,
        $imageHandler = null,
        $hasher = null,
        $validator = null,
        $container = null
    ) {
        if ($users === null) {
            /** @var UserRepositoryInterface $users */
            $users = $this->getUsers();
        }
        if ($accounts === null) {
            /** @var UserAccountRepositoryInterface $accounts */
            $accounts = $this->getAccounts();
        }
        if ($groups === null) {
            /** @var UserGroupRepositoryInterface $groups */
            $groups = $this->getGroups();
        }
        if ($emails === null) {
            /** @var UserEmailRepositoryInterface $emails */
            $emails = $this->getMails();
        }
        if ($pendingEmails === null) {
            /** @var PendingEmailRepositoryInterface $pendingEmails */
            $pendingEmails = $this->getPendingMails();
        }
        if ($imageHandler === null) {
            /** @var UserImageHandler $imageHandler */
            $imageHandler = $this->getImageHander();
        }
        if ($hasher === null) {
            /** @var Hasher $hasher */
            $hasher = $this->getHasher();
        }
        if ($validator === null) {
            /** @var Factory $validator */
            $validator = $this->getValidator();
        }
        if ($container === null) {
            /** @var Container $container */
            $container = $this->getContainer();
        }

        $handler = new UserHandler(
            $users,
            $accounts,
            $groups,
            $emails,
            $pendingEmails,
            $imageHandler,
            $hasher,
            $validator,
            $container,
            true
        );
        return $handler;
    }

    /**
     * @return \Xpressengine\User\UserHandler
     */
    private function getHandlerMock(
        $users = null,
        $accounts = null,
        $groups = null,
        $emails = null,
        $pendingEmails = null,
        $imageHandler = null,
        $hasher = null,
        $validator = null,
        $container = null
    ) {
        if ($users === null) {
            /** @var UserRepositoryInterface $users */
            $users = $this->getUsers();
        }
        if ($accounts === null) {
            /** @var UserAccountRepositoryInterface $accounts */
            $accounts = $this->getAccounts();
        }
        if ($groups === null) {
            /** @var UserGroupRepositoryInterface $groups */
            $groups = $this->getGroups();
        }
        if ($emails === null) {
            /** @var UserEmailRepositoryInterface $emails */
            $emails = $this->getMails();
        }
        if ($pendingEmails === null) {
            /** @var PendingEmailRepositoryInterface $pendingEmails */
            $pendingEmails = $this->getPendingMails();
        }
        if ($imageHandler === null) {
            /** @var UserImageHandler $imageHandler */
            $imageHandler = $this->getImageHander();
        }
        if ($hasher === null) {
            /** @var Hasher $hasher */
            $hasher = $this->getHasher();
        }
        if ($validator === null) {
            /** @var Factory $validator */
            $validator = $this->getValidator();
        }
        if ($container === null) {
            /** @var Container $container */
            $container = $this->getContainer();
        }

        $handler = Mockery::mock(UserHandler::class, [
            $users,
            $accounts,
            $groups,
            $emails,
            $pendingEmails,
            $imageHandler,
            $hasher,
            $validator,
            $container,
            true
        ])->makePartial();
        return $handler;
    }

    protected function getUsers()
    {
        return Mockery::mock(UserRepositoryInterface::class);
    }

    protected function getAccounts()
    {
        return Mockery::mock(UserAccountRepositoryInterface::class);
    }

    protected function getGroups()
    {
        return Mockery::mock(UserGroupRepositoryInterface::class);
    }

    protected function getVgroups()
    {
        return Mockery::mock(VirtualGroupRepositoryInterface::class);
    }

    protected function getMails()
    {
        return Mockery::mock(UserEmailRepositoryInterface::class);
    }

    protected function getPendingMails()
    {
        return Mockery::mock(PendingEmailRepositoryInterface::class);
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

    protected function getImageHander()
    {
        return Mockery::mock(UserImageHandler::class);
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
     * makeUser
     *
     * @return Mockery\MockInterface
     */
    private function makeUser()
    {
        return Mockery::mock(\Xpressengine\User\Models\User::class);
    }

    private function makeAccount()
    {
        return Mockery::mock(\Xpressengine\User\Models\UserAccount::class);
    }
}

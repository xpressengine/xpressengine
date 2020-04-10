<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */


namespace Xpressengine\User {
    function xe_trans($id = null, $parameters = array(), $domain = 'messages', $locale = null)
    {
        return $id;
    }
}

namespace Xpressengine\Tests\User {

    use Illuminate\Contracts\Hashing\Hasher;
    use Illuminate\Contracts\Validation\Factory;
    use Illuminate\Contracts\Validation\Validator;
    use Illuminate\Support\Fluent;
    use Illuminate\Support\MessageBag;
    use Mockery;
    use Xpressengine\Config\ConfigManager;
    use Xpressengine\Register\Container;
    use Xpressengine\User\Models\User;
    use Xpressengine\User\Rating;
    use Xpressengine\User\Repositories\PendingEmailRepositoryInterface;
    use Xpressengine\User\Repositories\UserAccountRepositoryInterface;
    use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
    use Xpressengine\User\Repositories\UserGroupRepositoryInterface;
    use Xpressengine\User\Repositories\UserRepositoryInterface;
    use Xpressengine\User\Repositories\VirtualGroupRepositoryInterface;
    use Xpressengine\User\UserHandler;
    use Xpressengine\User\UserImageHandler;

    class UserHandlerTest extends \PHPUnit\Framework\TestCase
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

            $configManager = $this->getConfigManager();

            /** @var Mockery\MockInterface $handler */
            $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher, null, $configManager);
            $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

            $data = [
                'display_name' => 'foo',
                'password' => 'secret',
            ];

            /** @var Mockery\MockInterface $users */
            $users = $handler->users();
            $user = $this->makeUser();
            $users->shouldReceive('create')
                ->once()
                ->with([
                    'display_name' => 'foo',
                    'password' => 'encrypted',
                    'rating' => Rating::USER,
                    'status' => User::STATUS_ACTIVATED
                ])->andReturn($user);

            $configManager->shouldReceive('getVal')->with('user.register.register_process', User::STATUS_ACTIVATED)->andReturn(User::STATUS_ACTIVATED);
            $configManager->shouldReceive('getVal')->with('user.register.use_display_name')->andReturn(true);

            $this->assertEquals($user, $handler->create($data));
        }

        public function testCreateWithEmail()
        {
            /** @var Mockery\MockInterface $hasher */
            $hasher = $this->getHasher();
            $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');

            $configManager = $this->getConfigManager();

            /** @var Mockery\MockInterface $handler */
            $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher, null, $configManager);
            $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

            $data = [
                'display_name' => 'foo',
                'password' => 'secret',
                'email' => 'foo@bar.com',
            ];

            /** @var Mockery\MockInterface $users */
            $users = $handler->users();
            $user = $this->makeUser();
            $user->shouldReceive('hasMacro')->andReturn(false);
            $user->shouldReceive('getAttribute')->once()->with('email')->andReturn('foo@bar.com');
            $user->shouldReceive('getAttribute')->twice()->with('id')->andReturn('baz');

            $users->shouldReceive('create')
                ->once()
                ->with([
                    'display_name' => 'foo', 'password' => 'encrypted', 'email'=>'foo@bar.com',
                    'rating' => Rating::USER,
                    'status' => User::STATUS_ACTIVATED
                ])->andReturn($user);

            /** @var Mockery\MockInterface $emails */
            $emails = $handler->emails();
            $email = $this->makeEmail();
            $emails->shouldReceive('create')
                ->once()
                ->with($user, ['user_id' => 'baz', 'address' => 'foo@bar.com'])
                ->andReturn($email);

            /** @var Mockery\MockInterface $emails */
            $pendingEmails = $handler->pendingEmails();
            $email = $this->makeEmail();
            $pendingEmails->shouldReceive('findByUserId')
                ->once()
                ->with('baz')
                ->andReturnNull();

            $configManager->shouldReceive('getVal')->with('user.register.register_process', User::STATUS_ACTIVATED)->andReturn(User::STATUS_ACTIVATED);
            $configManager->shouldReceive('getVal')->with('user.register.use_display_name')->andReturn(true);

            $this->assertEquals($user, $handler->create($data));
        }

        public function testCreateWithPendingEmail()
        {
            /** @var Mockery\MockInterface $hasher */
            $hasher = $this->getHasher();
            $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');

            $configManager = $this->getConfigManager();

            /** @var Mockery\MockInterface $handler */
            $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher, null, $configManager);
            $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

            $data = [
                'display_name' => 'foo',
                'password' => 'secret',
                'email' => 'foo@bar.com',
            ];

            /** @var Mockery\MockInterface $users */
            $users = $handler->users();
            $user = $this->makeUser();
            $user->shouldReceive('hasMacro')->andReturn(false);
            $user->shouldReceive('getAttribute')->once()->with('email')->andReturn('foo@bar.com');
            $user->shouldReceive('getAttribute')->twice()->with('id')->andReturn('baz');

            $users->shouldReceive('create')
                ->once()
                ->with([
                    'display_name' => 'foo', 'password' => 'encrypted', 'email'=>'foo@bar.com',
                    'rating' => Rating::USER,
                    'status' => User::STATUS_ACTIVATED
                ])->andReturn($user);


            /** @var Mockery\MockInterface $emails */
            $emails = $handler->emails();
            $email = $this->makeEmail();
            $emails->shouldReceive('create')
                ->once()
                ->with($user, ['user_id' => 'baz', 'address' => 'foo@bar.com'])
                ->andReturn($email);


            /** @var Mockery\MockInterface $emails */
            $pendingEmails = $handler->pendingEmails();
            $email = $this->makeEmail();
            $pendingEmails->shouldReceive('findByUserId')
                ->once()
                ->with('baz')
                ->andReturnNull();

            $configManager->shouldReceive('getVal')->with('user.register.register_process', User::STATUS_ACTIVATED)->andReturn(User::STATUS_ACTIVATED);
            $configManager->shouldReceive('getVal')->with('user.register.use_display_name')->andReturn(true);

            $this->assertEquals($user, $handler->create($data));
        }

        public function testCreateWithGroups()
        {
            /** @var Mockery\MockInterface $hasher */
            $hasher = $this->getHasher();
            $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');

            $configManager = $this->getConfigManager();

            /** @var Mockery\MockInterface $handler */
            $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher, null, $configManager);
            $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

            $data = [
                'display_name' => 'foo',
                'password' => 'secret',
                'group_id' => ['bar','baz']
            ];

            /** @var Mockery\MockInterface $users */
            $users = $handler->users();
            $user = $this->makeUser();
            $user->shouldReceive('joinGroups')->with(['bar','baz'])->andReturnSelf();

            $users->shouldReceive('create')
                ->once()
                ->with([
                    'display_name' => 'foo', 'password' => 'encrypted',
                    'rating' => Rating::USER,
                    'status' => User::STATUS_ACTIVATED
                ])
                ->andReturn($user);

            $configManager->shouldReceive('getVal')->with('user.register.register_process', User::STATUS_ACTIVATED)->andReturn(User::STATUS_ACTIVATED);
            $configManager->shouldReceive('getVal')->with('user.register.use_display_name')->andReturn(true);

            $this->assertEquals($user, $handler->create($data));
        }

        public function testCreateWithAccounts()
        {
            /** @var Mockery\MockInterface $hasher */
            $hasher = $this->getHasher();
            $hasher->shouldReceive('make')->once()->with('secret')->andReturn('encrypted');

            $configManager = $this->getConfigManager();

            /** @var Mockery\MockInterface $handler */
            $handler = $this->getHandlerMock(null,null,null,null,null,null,$hasher, null, $configManager);
            $handler->shouldReceive('validateForCreate')->withAnyArgs()->andReturn(true);

            $data = [
                'display_name' => 'foo',
                'password' => 'secret',
                'account' => [
                    'account_id' => 'bar',
                    'email' => 'foo@bar.com',
                    'provider' => 'baz',
                    'data' => [],
                    'token' => 'token',
                    'token_secret' => 'tokenSecret',
                ]
            ];

            $account = $this->makeAccount();

            /** @var Mockery\MockInterface $users */
            $users = $handler->users();
            $user = $this->makeUser();
            $user->shouldReceive('hasMacro')->andReturn(false);
            $user->shouldReceive('getAttribute')->once()->with('id')->andReturn('baz');

            $hasMany = Mockery::mock(\Illuminate\Database\Eloquent\Relations\HasMany::class);

            $user->shouldReceive('accounts')->once()->andReturn($hasMany);
            $hasMany->shouldReceive('save')->once()->with($account)->andReturnSelf();

            /** @var Mockery\MockInterface $accounts */
            $accounts = $handler->accounts();
            $accounts->shouldReceive('create')->once()->with($user, [
                'user_id' => 'baz',
                'account_id' => 'bar',
                'email' => 'foo@bar.com',
                'provider' => 'baz',
                'token' => 'token',
                'token_secret' => 'tokenSecret',
            ])->andReturn($account);

            $users->shouldReceive('create')
                ->once()
                ->with([
                    'display_name' => 'foo', 'password' => 'encrypted',
                    'rating' => Rating::USER,
                    'status' => User::STATUS_ACTIVATED
                ])->andReturn($user);

            $configManager->shouldReceive('getVal')->with('user.register.register_process', User::STATUS_ACTIVATED)->andReturn(User::STATUS_ACTIVATED);
            $configManager->shouldReceive('getVal')->with('user.register.use_display_name')->andReturn(true);

            $this->assertEquals($user, $handler->create($data));
        }

        /**
         * @expectedException \Xpressengine\Support\Exceptions\InvalidArgumentException
         */
        public function testValidateForCreateFail()
        {
            $data = [
                'rating' => Rating::USER,
                'display_name' => 'foo'
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
                'rating' => Rating::USER,
                'display_name' => 'foo',
                'status' => User::STATUS_ACTIVATED
            ];
            /** @var UserHandler $handler */
            $handler = $this->getHandler();
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
         * @param null $users
         * @param null $accounts
         * @param null $groups
         * @param null $emails
         * @param null $pendingEmails
         * @param null $imageHandler
         * @param null $hasher
         * @param null $validator
         * @param null $configManager
         *
         * @return UserHandler
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
            $configManager = null
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
            if ($configManager === null) {
                /** @var ConfigManager $configManager */
                $configManager = $this->getConfigManager();
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
                $configManager
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
            $configManager = null
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
            if ($configManager === null) {
                /** @var ConfigManager $configManager */
                $configManager = $this->getConfigManager();
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
                $configManager
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

        public function getGroups()
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

        protected function getConfigManager()
        {
            return Mockery::mock(ConfigManager::class);
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
}

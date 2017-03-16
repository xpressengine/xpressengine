<?php
/**
 * This file is register this package for laravel
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Closure;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Media\MediaManager;
use Xpressengine\Media\Thumbnailer;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;
use App\ToggleMenus\Member\ProfileItem;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\Guard;
use Xpressengine\User\GuardInterface;
use Xpressengine\User\Models\Guest;
use Xpressengine\User\Models\PendingEmail;
use Xpressengine\User\Models\UnknownUser;
use Xpressengine\User\Models\User;
use Xpressengine\User\Models\UserAccount;
use Xpressengine\User\Models\UserEmail;
use Xpressengine\User\Models\UserGroup;
use Xpressengine\User\Repositories\PendingEmailRepository;
use Xpressengine\User\Repositories\PendingEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserAccountRepository;
use Xpressengine\User\Repositories\UserAccountRepositoryInterface;
use Xpressengine\User\Repositories\UserEmailRepository;
use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserGroupRepository;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;
use Xpressengine\User\Repositories\UserRepository;
use Xpressengine\User\Repositories\UserRepositoryInterface;
use Xpressengine\User\Repositories\VirtualGroupRepository;
use Xpressengine\User\Repositories\VirtualGroupRepositoryInterface;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserImageHandler;
use Xpressengine\User\UserProvider;

/**
 * laravel 에서 사용하기위해 등록처리를 하는 class
 *
 * @category    User
 * @package     Xpressengine\User
 */
class UserServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHandler();
        $this->registerRepositories();

        // user package 제거후 주석 해제
        $this->registerAuth();
        $this->registerTokenRepository();
        $this->registerEmailBroker();
        $this->registerPasswordBroker();

        $this->registerImageHandler();
    }

    /**
     * register Auth
     *
     * @return void
     */
    protected function registerAuth()
    {
        $this->app->singleton(
            ['xe.auth' => GuardInterface::class],
            function ($app) {
                $proxyClass = $app['xe.interception']->proxy(Guard::class, 'Auth');
                return new $proxyClass(
                    new UserProvider($app['hash'], User::class), $app['session.store'], $app['request']
                );
            }
        );
    }

    /**
     * Register the password broker instance.
     *
     * @return void
     */
    protected function registerPasswordBroker()
    {
        $this->app->singleton(
            'auth.password',
            function ($app) {
                // The password token repository is responsible for storing the email addresses
                // and password reset tokens. It will be used to verify the tokens are valid
                // for the given e-mail addresses. We will resolve an implementation here.
                $tokens = $app['auth.password.tokens'];

                $users = $app['auth']->driver()->getProvider();

                $view = $app['config']['auth.password.email'];

                // The password broker uses a token repository to validate tokens and send user
                // password e-mails, as well as validating that password reset process as an
                // aggregate service of sorts providing a convenient interface for resets.
                $broker = new PasswordBroker($tokens, $users, $app['mailer'], $view);

                // register validator for password
                $broker->validator(
                    function ($credentials) {
                        try {
                            return app('xe.user')->validatePassword($credentials['password']);
                        } catch (\Exception $e) {
                            return false;
                        }
                    }
                );

                return $broker;
            }
        );
    }

    /**
     * Register the email broker instance.
     *
     * @return void
     */
    protected function registerEmailBroker()
    {
        $this->app->singleton(
            'xe.auth.email',
            function ($app) {
                $view = $app['config']['auth.confirm.email'];

                // The password broker uses a token repository to validate tokens and send user
                // password e-mails, as well as validating that password reset process as an
                // aggregate service of sorts providing a convenient interface for resets.
                return new EmailBroker($app['xe.user'], $app['mailer'], $view);
            }
        );
    }

    private function registerImageHandler()
    {
        $this->app->singleton(
            'xe.user.image',
            function ($app) {

                $profileImgConfig = config('xe.user.profileImage');

                return new UserImageHandler(
                    $app['xe.storage'], $app['xe.media'], function () {
                    return Thumbnailer::getManager();
                }, $profileImgConfig
                );
            }
        );
    }

    /**
     * Register the token repository implementation.
     *
     * @return void
     */
    protected function registerTokenRepository()
    {
        $this->app->singleton(
            'auth.password.tokens',
            function ($app) {
                $connection = $app['xe.db']->connection('user');

                // The database token repository is an implementation of the token repository
                // interface, and is responsible for the actual storing of auth tokens and
                // their e-mail addresses. We will inject this table and hash key to it.
                $table = $app['config']['auth.password.table'];

                $key = $app['config']['app.key'];

                $expire = $app['config']->get('auth.password.expire', 60);

                return new DatabaseTokenRepository($connection, $table, $key, $expire);
            }
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // set guest's display name
        Guest::setName($this->app['config']['xe.user.guest.name']);

        // set guest's default profile image
        Guest::setDefaultProfileImage($this->app['config']['xe.user.profileImage.default']);

        // set unknown's display name
        UnknownUser::setName($this->app['config']['xe.user.unknown.name']);

        // set unknown's default profile image
        UnknownUser::setDefaultProfileImage($this->app['config']['xe.user.profileImage.default']);

        $this->setProfileImageResolverOfUser();

        // extend xe auth
        $this->extendAuth();

        // set config for validation of password, displayname
        $this->configValidation();

        // register validation extension for email prefix
        $this->extendValidator();

        // register default user skin
        $this->registerDefaultSkins();

        $this->registerSettingsPermissions();

        // register toggle menu
        $this->registerToggleMenu();
    }

    /**
     * registerMemberMenu
     *
     * @return void
     */
    protected function registerToggleMenu()
    {
        $this->app['xe.pluginRegister']->add(ProfileItem::class);
    }

    /**
     * registerHandler
     *
     * @return void
     */
    private function registerHandler()
    {
        $this->app->singleton(
            ['xe.user' => UserHandler::class],
            function ($app) {
                $proxyClass = $app['xe.interception']->proxy(UserHandler::class, 'XeUser');

                $userHandler = new $proxyClass(
                    $app['xe.users'],
                    $app['xe.user.accounts'],
                    $app['xe.user.groups'],
                    $app['xe.user.emails'],
                    $app['xe.user.pendingEmails'],
                    $app['xe.user.image'],
                    $app['hash'],
                    $app['validator'],
                    $app['xe.register'],
                    $app['xe.config']->getVal('user.join.useEmailCertify', false)
                );
                return $userHandler;
            }
        );
    }

    /**
     * register Repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->registerUserRepository();
        $this->registerAccoutRepository();
        $this->registerGroupRepository();
        $this->registerVirtualGroupRepository();
        $this->registerMailRepository();
    }

    protected function registerUserRepository()
    {
        $this->app->singleton(
            ['xe.users' => UserRepositoryInterface::class],
            function ($app) {
                return new UserRepository(User::class);
            }
        );
    }

    /**
     * register Accout Repository
     *
     * @return void
     */
    private function registerAccoutRepository()
    {
        $this->app->singleton(
            ['xe.user.accounts' => UserAccountRepositoryInterface::class],
            function ($app) {
                return new UserAccountRepository(UserAccount::class);
            }
        );
    }

    /**
     * register Group Repository
     *
     * @return void
     */
    protected function registerGroupRepository()
    {
        $this->app->singleton(
            ['xe.user.groups' => UserGroupRepositoryInterface::class],
            function ($app) {
                return new UserGroupRepository(UserGroup::class);
            }
        );
    }

    /**
     * register Virtual Group Repository
     *
     * @return void
     */
    protected function registerVirtualGroupRepository()
    {
        $this->app->singleton(
            ['xe.user.virtualGroups' => VirtualGroupRepositoryInterface::class],
            function ($app) {
                /** @var Closure $vGroups */
                $vGroups = $app['config']->get('xe.group.virtualGroup.all');
                /** @var Closure $getter */
                $getter = $app['config']->get('xe.group.virtualGroup.getByUser');
                return new VirtualGroupRepository($app['xe.users'], $vGroups(), $getter);
            }
        );
    }

    private function registerMailRepository()
    {
        $this->app->singleton(
            ['xe.user.emails' => UserEmailRepositoryInterface::class],
            function ($app) {
                return new UserEmailRepository(UserEmail::class);
            }
        );

        $this->app->singleton(
            ['xe.user.pendingEmails' => PendingEmailRepositoryInterface::class],
            function ($app) {
                return new PendingEmailRepository(PendingEmail::class);
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'xe.auth',
            'xe.auth.password',
            'xe.auth.email',
            'xe.auth.tokens',
            'xe.user',
            'xe.users',
            'xe.user.groups',
            'xe.user.virtualGroups',
            'xe.user.emails',
            'xe.user.pendingEmails',
            'xe.user.accounts'
        ];
    }

    /**
     * extendAuth
     *
     * @return void
     */
    private function extendAuth()
    {
        $this->app['auth']->extend(
            'xe',
            function ($app) {
                return $app['xe.auth'];
            }
        );
    }

    private function configValidation()
    {
        // set password validation to config
        $passwordLevels =  [
            'weak' => [
                'title' => 'xe::weak',
                'validate' => function ($password) {
                    return strlen($password) >= 4;
                },
                'description' => 'xe::passwordStrengthStrongDescription'
            ],
            'normal' => [
                'title' => 'xe::normal',
                'validate' => function ($password) {
                    if (!preg_match_all(
                        '$\S*(?=\S{6,})(?=\S*[a-zA-Z])(?=\S*[\d])\S*$',
                        $password
                    )
                    ) {
                        return false;
                    }
                    return true;
                },
                'description' => 'xe::passwordStrengthStrongDescription'
            ],
            'strong' => [
                'title' => 'xe::strong',
                'validate' => function ($password) {
                    if (!preg_match_all(
                        '$\S*(?=\S{8,})(?=\S*[a-zA-Z])(?=\S*[\d])(?=\S*[\W])\S*$',
                        $password
                    )
                    ) {
                        return false;
                    }
                    return true;
                },
                'description' => 'xe::passwordStrengthStrongDescription'
            ]
        ];
        app('config')->set('xe.user.password.levels', $passwordLevels);

        // set display name validation to config
        app('config')->set('xe.user.displayName.validate', function ($value) {
            if (!is_string($value) && !is_numeric($value)) {
                return false;
            }

            if (str_contains($value, "  ")) {
                return false;
            }

            $byte = strlen($value);
            $multiByte = mb_strlen($value);

            if ($byte === $multiByte) {
                if ($byte < 3) {
                    return false;
                }
            } else {
                if ($multiByte < 2) {
                    return false;
                }
            }
            return preg_match('/^[\pL\pM\pN][. \pL\pM\pN_-]*[\pL\pM\pN]$/u', $value);
        });

    }

    /**
     * extendEmailPrefixValidator
     *
     * @return void
     */
    private function extendValidator()
    {
        /** @var Validator $validator */
        $validator = $this->app['validator'];

        // 도메인이 생략된 이메일 validation 추가
        $validator->extend(
            'email_prefix',
            function ($attribute, $value, $parameters) {
                if (!str_contains($value, '@')) {
                    $value .= '@test.com';
                }
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
            }
        );

        // 표시이름 validation 추가
        /** @var Closure $displayNameValidate */
        $displayNameValidate = app('config')->get('xe.user.displayName.validate');
        $validator->extend(
            'display_name',
            function ($attribute, $value, $parameters) use ($displayNameValidate) {
                return $displayNameValidate($value);
            }
        );

        $passwordConfig = app('config')->get('xe.user.password');
        $levels = $passwordConfig['levels'];
        $level = $levels[$passwordConfig['default']];
        $validate = $level['validate'];

        $validator->extend(
            'password',
            function ($attribute, $value, $parameters) use ($validate) {
                return $validate($value);
            },
            xe_trans($level['description'])
        );
    }

    /**
     * registerDefaultSkins
     *
     * @return void
     */
    private function registerDefaultSkins()
    {
        $pluginRegister = $this->app['xe.pluginRegister'];
        $pluginRegister->add(\App\Skins\Member\AuthSkin::class);
        $pluginRegister->add(\App\Skins\Member\SettingsSkin::class);
        $pluginRegister->add(\App\Skins\Member\ProfileSkin::class);
    }

    private function registerSettingsPermissions()
    {
        $permissions = [
            'user.list' => [
                'title' => '회원정보 보기',
                'tab' => '회원'
            ],
            'user.edit' => [
                'title' => '회원정보 수정',
                'tab' => '회원'
            ]
        ];
        $register = $this->app->make('xe.register');
        foreach ($permissions as $id => $permission) {
            $register->push('settings/permission', $id, $permission);
        }
    }

    private function setProfileImageResolverOfUser()
    {
        $default = $this->app['config']['xe.user.profileImage.default'];
        $storage = $this->app['xe.storage'];
        $media = $this->app['xe.media'];
        User::setProfileImageResolver(
            function ($imageId) use ($default, $storage, $media) {
                try {
                    if($imageId !== null) {
                        /** @var Storage $storage */
                        $file = File::find($imageId);

                        if ($file !== null) {
                            /** @var MediaManager $media */
                            $mediaFile = $media->make($file);
                            return asset($mediaFile->url());
                        }
                    }
                } catch(\Exception $e) {
                }

                return asset($default);
            }
        );
    }
}

<?php
/**
 * UserServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use App\ToggleMenus\User\ManageItem;
use App\ToggleMenus\User\ProfileItem;
use Closure;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Media\MediaManager;
use Xpressengine\Media\Thumbnailer;
use Xpressengine\Storage\Storage;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\Guard;
use Xpressengine\User\Middleware\Admin;
use Xpressengine\User\Models\Guest;
use Xpressengine\User\Models\PendingEmail;
use Xpressengine\User\Models\Term;
use Xpressengine\User\Models\UnknownUser;
use Xpressengine\User\Models\User;
use Xpressengine\User\Models\UserAccount;
use Xpressengine\User\Models\UserEmail;
use Xpressengine\User\Models\UserGroup;
use Xpressengine\User\Parts\AgreementPart;
use Xpressengine\User\Parts\CaptchaPart;
use Xpressengine\User\Parts\DefaultPart;
use Xpressengine\User\Parts\DynamicFieldPart;
use Xpressengine\User\Parts\RegisterFormPart;
use Xpressengine\User\Parts\EmailVerifyPart;
use Xpressengine\User\PasswordValidator;
use Xpressengine\User\UserRegisterHandler;
use Xpressengine\User\Repositories\PendingEmailRepository;
use Xpressengine\User\Repositories\PendingEmailRepositoryInterface;
use Xpressengine\User\Repositories\RegisterTokenRepository;
use Xpressengine\User\Repositories\TermsRepository;
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
use Xpressengine\User\TermsHandler;
use Xpressengine\User\UserHandler;
use Xpressengine\User\UserImageHandler;
use Xpressengine\User\UserProvider;

/**
 * Class UserServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->setModels();

        // extend xe auth
        $this->extendAuth();

        // set guest's display name
        Guest::setName($this->app['config']['xe.user.guest.name']);

        // set guest's default profile image
        Guest::setDefaultProfileImage($this->app['config']['xe.user.profileImage.default']);

        // set unknown's display name
        UnknownUser::setName($this->app['config']['xe.user.unknown.name']);

        // set unknown's default profile image
        UnknownUser::setDefaultProfileImage($this->app['config']['xe.user.profileImage.default']);

        $this->setProfileImageResolverOfUser();

        // register default user skin
        $this->registerDefaultSkins();

        $this->registerSettingsPermissions();

        // register admin middleware
        $this->app['router']->aliasMiddleware('admin', Admin::class);

        // register toggle menu
        $this->registerToggleMenu();

        UserHandler::setContainer($this->app['xe.register']);
        // add RegiserForm
        $this->addRegisterFormParts();

        $this->addUserSettingSection();

        $this->app->resolving('mailer', function ($mailer) {
            $config = $this->app['xe.config']->get('user.common');
            if (!empty($config->get('webmasterEmail'))) {
                $mailer->alwaysFrom($config->get('webmasterEmail'), $config->get('webmasterName'));
            }
        });

        $this->app['events']->listen('Illuminate\Auth\Events\Login', function ($event) {
            if (method_exists($event->user, 'setLoginTime')) {
                $event->user->setLoginTime();
                $event->user->save();
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHandler();
        $this->registerRepositories();

        $this->registerTokenRepository();
        $this->registerEmailBroker();

        $this->registerImageHandler();

        $this->registerTerms();
        $this->registerPasswordValidator();

        $this->registerUserRegisterHandler();

        // register validation extension for email prefix
        $this->extendValidator();
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
                return new EmailBroker($app['xe.user']);
            }
        );
    }

    /**
     * Register the image handler for the user.
     *
     * @return void
     */
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
        // register register-token repository
        $this->app->singleton(RegisterTokenRepository::class, function ($app) {
            $connection = $app['xe.db']->connection();

            // The database token repository is an implementation of the token repository
            // interface, and is responsible for the actual storing of auth tokens and
            // their e-mail addresses. We will inject this table and hash key to it.
            $table = $app['config']['auth.register.table'];

            $keygen = $app['xe.keygen'];

            $expire = $app['config']->get('auth.register.expire', 10080);

            return new RegisterTokenRepository($connection, $keygen, $table, $expire);
        });
        $this->app->alias(RegisterTokenRepository::class, 'xe.user.register.tokens');
    }

    /**
     * Register the toggle menu.
     *
     * @return void
     */
    protected function registerToggleMenu()
    {
        $this->app['xe.pluginRegister']->add(ProfileItem::class);
        $this->app['xe.pluginRegister']->add(ManageItem::class);
    }

    /**
     * Register the use handler.
     *
     * @return void
     */
    private function registerHandler()
    {
        $this->app->singleton(UserHandler::class, function ($app) {
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
                $app['xe.config']
            );
            return $userHandler;
        });
        $this->app->alias(UserHandler::class, 'xe.user');
    }

    /**
     * Register the term handler.
     *
     * @return void
     */
    private function registerTerms()
    {
        $this->app->singleton(TermsHandler::class, function ($app) {
            return new TermsHandler($app[TermsRepository::class]);
        });
        $this->app->alias(TermsHandler::class, 'xe.terms');
    }

    /**
     * Register the password validator.
     *
     * @return void
     */
    private function registerPasswordValidator()
    {
        $this->app->singleton('xe.password.validator', function ($app) {
            return new PasswordValidator($app);
        });
    }

    /**
     * Register repositories.
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

        $this->registerTermsRepository();
    }

    /**
     * Register the us repository.
     *
     * @return void
     */
    protected function registerUserRepository()
    {
        $this->app->singleton(UserRepositoryInterface::class, function ($app) {
            return new UserRepository;
        });
        $this->app->alias(UserRepositoryInterface::class, 'xe.users');
    }

    /**
     * register the account repository.
     *
     * @return void
     */
    private function registerAccoutRepository()
    {
        $this->app->singleton(UserAccountRepositoryInterface::class, function ($app) {
            return new UserAccountRepository;
        });
        $this->app->alias(UserAccountRepositoryInterface::class, 'xe.user.accounts');
    }

    /**
     * Register the group repository.
     *
     * @return void
     */
    protected function registerGroupRepository()
    {
        $this->app->singleton(UserGroupRepositoryInterface::class, function ($app) {
            return new UserGroupRepository;
        });
        $this->app->alias(UserGroupRepositoryInterface::class, 'xe.user.groups');
    }

    /**
     * Register the virtual group repository.
     *
     * @return void
     */
    protected function registerVirtualGroupRepository()
    {
        $this->app->singleton(VirtualGroupRepositoryInterface::class, function ($app) {
            /** @var Closure $vGroups */
            $vGroups = $app['config']->get('xe.group.virtualGroup.all');
            /** @var Closure $getter */
            $getter = $app['config']->get('xe.group.virtualGroup.getByUser');
            return new VirtualGroupRepository($app['xe.users'], $vGroups(), $getter);
        });
        $this->app->alias(VirtualGroupRepositoryInterface::class, 'xe.user.virtualGroups');
    }

    /**
     * Register the mail repository.
     *
     * @return void
     */
    private function registerMailRepository()
    {
        $this->app->singleton(UserEmailRepositoryInterface::class, function ($app) {
            return new UserEmailRepository;
        });
        $this->app->alias(UserEmailRepositoryInterface::class, 'xe.user.emails');

        $this->app->singleton(PendingEmailRepositoryInterface::class, function ($app) {
            return new PendingEmailRepository;
        });
        $this->app->alias(PendingEmailRepositoryInterface::class, 'xe.user.pendingEmails');
    }

    /**
     * Register the term repository.
     *
     * @return void
     */
    private function registerTermsRepository()
    {
        $this->app->singleton(TermsRepository::class, function ($app) {
            return new TermsRepository;
        });
    }

    /**
     * Set the model to the repository
     *
     * @return void
     */
    private function setModels()
    {
        UserRepository::setModel(User::class);
        UserAccountRepository::setModel(UserAccount::class);
        UserGroupRepository::setModel(UserGroup::class);
        UserEmailRepository::setModel(UserEmail::class);
        PendingEmailRepository::setModel(PendingEmail::class);
        TermsRepository::setModel(Term::class);
    }

    /**
     * Register a custom driver creator to Auth.
     *
     * @return void
     */
    private function extendAuth()
    {
        $this->app['auth']->extend('xe', function ($app, $name, $config) {
            $adminAuth = $app['config']->get('auth.admin');
            $proxyClass = $app['xe.interception']->proxy(Guard::class, 'Auth'); // todo: 제거
            $provider = $app['auth']->createUserProvider($config['provider']);
            $guard = new $proxyClass(
                $name, $provider, $app['session.store'], $adminAuth, $app['request']
            );

            if (method_exists($guard, 'setCookieJar')) {
                $guard->setCookieJar($app['cookie']);
            }

            if (method_exists($guard, 'setDispatcher')) {
                $guard->setDispatcher($app['events']);
            }

            if (method_exists($guard, 'setRequest')) {
                $guard->setRequest($app->refresh('request', $guard, 'setRequest'));
            }

            return $guard;
        });

        $this->app['auth']->provider('xe', function ($app, $config) {
            return new UserProvider($app['hash'], $config['model'], $app['events']);
        });
    }

    /**
     * Register a display name validation to config.
     *
     * @return void
     */
    private function configValidation()
    {
        // set display name validation to config
        if ($this->isInstalled()) {
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

            app('config')->set('xe.user.loginId.validate', function ($value) {
                if (str_contains($value, " ")) {
                    return false;
                }

                $length = strlen($value);
                if ($length < 5 || $length > 20) {
                    return false;
                }

                return preg_match('/[a-z0-9][a-z0-9-_][a-z0-9-_][a-z0-9-_]+[a-z0-9]+/', $value);
            });
        } else {
            app('config')->set('xe.user.displayName.validate', function ($value) {
                return true;
            });

            app('config')->set('xe.user.loginId.validate', function ($value) {
                return true;
            });
        }
    }

    /**
     * Determine if the application is installed.
     *
     * @return bool
     */
    protected function isInstalled()
    {
        return file_exists(app()->getInstalledPath());
    }

    /**
     * Register validations for the user.
     *
     * @return void
     */
    private function extendValidator()
    {
        $this->configValidation();

        $this->app->resolving('validator', function ($validator) {
            // 표시이름 validation 추가
            /** @var Closure $displayNameValidate */
            $displayNameValidate = app('config')->get('xe.user.displayName.validate');
            $validator->extend(
                'display_name',
                function ($attribute, $value, $parameters) use ($displayNameValidate) {
                    return $displayNameValidate($value);
                },
                xe_trans(
                    'xe::validationDisplayName',
                    ['attribute' => xe_trans(app('xe.config')->getVal('user.register.display_name_caption'))]
                )
            );

            //loginId validation 추가
            $loginIdValidate = app('config')->get('xe.user.loginId.validate');
            $validator->extend(
                'login_id',
                function ($attribute, $value, $parameters) use ($loginIdValidate) {
                    return $loginIdValidate($value);
                },
                xe_trans('xe::validationLoginId')
            );

            $validator->extend('password', function ($attribute, $value, $parameters) {
                return $this->app['xe.password.validator']->handle($value);
            });
            $validator->replacer('password', function () {
                return $this->app['xe.password.validator']->getMessage();
            });
        });
    }

    /**
     * Register skins for the user.
     *
     * @return void
     */
    private function registerDefaultSkins()
    {
        $pluginRegister = $this->app['xe.pluginRegister'];
        $pluginRegister->add(\App\Skins\User\AuthSkin::class);
        $pluginRegister->add(\App\Skins\User\SettingsSkin::class);
        $pluginRegister->add(\App\Skins\User\ProfileSkin::class);
    }

    /**
     * Register permissions for the user setting.
     *
     * @return void
     */
    private function registerSettingsPermissions()
    {
        $this->app['events']->listen(RouteMatched::class, function ($event) {
            $register = $this->app['xe.register'];
            $permissions = [
                'user.list' => [
                    'title' => xe_trans('xe::accessUserList'),
                    'tab' => xe_trans('xe::user')
                ],
                'user.edit' => [
                    'title' => xe_trans('xe::editUserInfo'),
                    'tab' => xe_trans('xe::user')
                ]
            ];
            foreach ($permissions as $id => $permission) {
                $register->push('settings/permission', $id, $permission);
            }
        });
    }

    /**
     * Set the profile image resolver to the user object.
     *
     * @return void
     */
    private function setProfileImageResolverOfUser()
    {
        User::setProfileImageResolver(
            function ($imageId) {
                $default = $this->app['config']['xe.user.profileImage.default'];
                $storage = $this->app['xe.storage'];
                $media = $this->app['xe.media'];
                try {
                    if($imageId !== null) {
                        /** @var Storage $storage */
                        $file = $storage->find($imageId);

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

    /**
     * Add form parts to the user register.
     *
     * @return void
     */
    protected function addRegisterFormParts()
    {
        RegisterFormPart::setSkinResolver($this->app['xe.skin']);
        RegisterFormPart::setContainer($this->app);

        UserHandler::addRegisterPart(DefaultPart::class);
        UserHandler::addRegisterPart(DynamicFieldPart::class);
        UserHandler::addRegisterPart(AgreementPart::class);
        UserHandler::addRegisterPart(CaptchaPart::class);
    }

    /**
     * Set the section to the user setting.
     *
     * @return void
     */
    protected function addUserSettingSection()
    {
        UserHandler::setSettingsSections('settings', [
            'title' => 'xe::defaultSettings',
            'content' => function ($user) {
                // dynamic field
                $fieldTypes = $this->app['xe.dynamicField']->gets('user');

                $this->app['xe.frontend']->js(
                    ['assets/core/xe-ui-component/js/xe-form.js', 'assets/core/xe-ui-component/js/xe-page.js']
                )->load();

                $this->app['xe.skin']->setMobileResolver(function () {
                    return app('request')->isMobile();
                });

                $skin = $this->app['xe.skin']->getAssigned('user/settings');

                return $skin->setView('edit')->setData(compact('user', 'fieldTypes'));
            }
        ]);
    }

    /**
     * register UserRegisterHandler
     *
     * @return void
     */
    protected function registerUserRegisterHandler()
    {
        $this->app->singleton(UserRegisterHandler::class, function () {
            return new UserRegisterHandler();
        });
        $this->app->alias(UserRegisterHandler::class, 'xe.user_register');
    }
}

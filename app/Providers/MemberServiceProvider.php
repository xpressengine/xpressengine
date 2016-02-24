<?php
/**
 * This file is register this package for laravel
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Closure;
use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use Illuminate\Auth\Passwords\PasswordBroker;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Media\Models\Image;
use Xpressengine\Media\Thumbnailer;
use Xpressengine\Member\EmailBroker;
use Xpressengine\Member\Entities\Database\MemberEntity;
use Xpressengine\Member\Entities\Guest;
use Xpressengine\Member\Guard;
use Xpressengine\Member\GuardInterface;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Member\MemberImageHandler;
use Xpressengine\Member\Provider;
use Xpressengine\Member\Repositories\AccountRepositoryInterface;
use Xpressengine\Member\Repositories\Database\AccountRepository;
use Xpressengine\Member\Repositories\Database\GroupRepository;
use Xpressengine\Member\Repositories\Database\MailRepository;
use Xpressengine\Member\Repositories\Database\MemberRepository;
use Xpressengine\Member\Repositories\Database\UserRepository;
use Xpressengine\Member\Repositories\Database\PendingMailRepository;
use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;
use Xpressengine\Member\Repositories\PendingMailRepositoryInterface;
use Xpressengine\Member\Repositories\VirtualGroupRepository;
use Xpressengine\Member\Repositories\VirtualGroupRepositoryInterface;
use Xpressengine\ToggleMenus\Member\LinkItem;
use Xpressengine\ToggleMenus\Member\RawItem;

/**
 * laravel 에서 사용하기위해 등록처리를 하는 class
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MemberServiceProvider extends ServiceProvider
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
        // $this->registerAuth();
        $this->registerHandler();

        $this->registerRepositories();
        $this->registerTokenRepository();

        // $this->registerEmailBroker();
        // $this->registerPasswordBroker();

        // $this->registerImageHandler();
    }

    /**
     * register Repositories
     *
     * @return void
     */
    protected function registerRepositories()
    {
        $this->registerMemberRepository();
        $this->registerAccoutRepository();
        $this->registerGroupRepository();
        $this->registerVirtualGroupRepository();
        $this->registerMailRepository();
    }

    /**
     * register Member Repository
     *
     * @return void
     */
    protected function registerMemberRepository()
    {
        $this->app->singleton(
            'xe.members',
            function ($app) {
                $generator = $app['xe.keygen'];
                $conn = $app['xe.db']->connection('member');

                return new MemberRepository($conn, $generator);
            }
        );
        $this->app->bind(MemberRepositoryInterface::class, 'xe.members');
    }

    /**
     * register Accout Repository
     *
     * @return void
     */
    private function registerAccoutRepository()
    {
        $this->app->singleton(
            'xe.member.accounts',
            function ($app) {
                $generator = $app['xe.keygen'];
                $conn = $app['xe.db']->connection('member');

                return new AccountRepository($conn, $generator);
            }
        );
        $this->app->bind(AccountRepositoryInterface::class, 'xe.member.accounts');
    }

    /**
     * register Group Repository
     *
     * @return void
     */
    protected function registerGroupRepository()
    {
        $this->app->singleton(
            'xe.member.groups',
            function ($app) {
                $generator = $app['xe.keygen'];
                $conn = $app['xe.db']->connection('member');
                return new GroupRepository($conn, $generator);
            }
        );
        $this->app->bind(GroupRepositoryInterface::class, 'xe.member.groups');
    }

    /**
     * register Virtual Group Repository
     *
     * @return void
     */
    protected function registerVirtualGroupRepository()
    {
        $this->app->singleton(
            'xe.member.virtualGroups',
            function ($app) {
                /** @var Closure $vGroups */
                $vGroups = $app['config']->get('xe.group.virtualGroup.all');
                $getter = $app['config']->get('xe.group.virtualGroup.getByMember');
                return new VirtualGroupRepository($app['xe.members'], $vGroups(), $getter);
            }
        );
        $this->app->bind(VirtualGroupRepositoryInterface::class, 'xe.member.virtualGroups');
    }

    private function registerMailRepository()
    {
        $this->app->singleton(
            'xe.member.mails',
            function ($app) {
                $conn = $app['xe.db']->connection('member');
                return new MailRepository($conn);
            }
        );
        $this->app->bind(MailRepositoryInterface::class, 'xe.member.mails');

        $this->app->singleton(
            'xe.member.pendingMails',
            function ($app) {
                $conn = $app['xe.db']->connection('member');
                return new PendingMailRepository($conn);
            }
        );
        $this->app->bind(PendingMailRepositoryInterface::class, 'xe.member.pendingMails');
    }

    /**
     * register Auth
     *
     * @return void
     */
    protected function registerAuth()
    {
        $this->app->singleton(
            'xe.auth',
            function ($app) {

                $proxyClass = $app['xe.interception']->proxy(Guard::class, 'Auth');
                return new $proxyClass(
                    new Provider($app['xe.members'], $app['hash']), $app['session.store'], $app['request']
                );
            }
        );
        $this->app->bind(GuardInterface::class, 'xe.auth');
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
                $broker->validator(function($credentials){
                    try {
                        return app('xe.member')->validatePassword($credentials['password']);
                    } catch (\Exception $e) {
                        return false;
                    }
                });

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
                return new EmailBroker($app['xe.member.mails'], $app['xe.member.pendingMails'], $app['mailer'], $view);
            }
        );
    }

    private function registerImageHandler()
    {
        $this->app->singleton(
            'xe.member.image',
            function ($app) {

                $profileImgConfig = config('xe.member.profileImage');

                return new MemberImageHandler(
                    $app['xe.storage'],
                    $app['xe.media'],
                    function() {
                        return Thumbnailer::getManager();
                    },
                    $profileImgConfig
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
                $connection = $app['db']->connection();

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
        Guest::setName($this->app['config']['xe.member.guest.name']);

        // set member entity's default profile image
        Guest::setDefaultProfileImage($this->app['config']['xe.member.profileImage.default']);

        $this->setProfileImageResolverOfMember();

        $this->addRelationship();

        // extend xe auth
        $this->extendAuth();

        // register validation extension for email prefix
        $this->extendValidator();

        // register default member skin
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
        $this->app['xe.pluginRegister']->add(LinkItem::class);
        $this->app['xe.pluginRegister']->add(RawItem::class);
    }

    /**
     * registerHandler
     *
     * @return void
     */
    private function registerHandler()
    {
        $this->app->singleton(
            'xe.member',
            function ($app) {
                $proxyClass = $app['xe.interception']->proxy(MemberHandler::class, 'Member');
                $memberHandler = new $proxyClass(
                    $app['xe.members'],
                    $app['xe.member.accounts'],
                    $app['xe.member.groups'],
                    $app['xe.member.virtualGroups'],
                    $app['xe.member.mails'],
                    $app['xe.member.pendingMails'],
                    $app['hash'],
                    $app['validator'],
                    $app['xe.register'],
                    $app['xe.config']->getVal('member.join.useMailCertify', 'true')

                );
                return $memberHandler;
            }
        );
        $this->app->bind(MemberHandler::class, 'xe.member');
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
            'xe.members', // ....
            'xe.member.accounts',
            'xe.member.groups',
            'xe.member.virtualGroups',
            'xe.member.mails',
            'xe.member.pendingMails',
            'xe.member.image'
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
        $displayNameValidate = app('config')->get('xe.member.displayName.validate');
        $validator->extend(
            'display_name',
            function ($attribute, $value, $parameters) use ($displayNameValidate) {
                return $displayNameValidate($value);
            }
        );

        $passwordConfig = app('config')->get('xe.member.password');
        $levels = $passwordConfig['levels'];
        $level = $levels[$passwordConfig['default']];
        $validate = $level['validate'];

        $validator->extend(
            'password',
            function ($attribute, $value, $parameters) use ($validate) {
                return $validate($value);
            },
            $level['description']
        );
    }

    /**
     * registerDefulteSkins
     *
     * @return void
     */
    private function registerDefaultSkins()
    {
        $pluginRegister = $this->app['xe.pluginRegister'];
        $pluginRegister->add(\Xpressengine\Skins\Member\AuthSkin::class);
        $pluginRegister->add(\Xpressengine\Skins\Member\SettingsSkin::class);
        $pluginRegister->add(\Xpressengine\Skins\Member\ProfileSkin::class);
    }

    private function registerSettingsPermissions()
    {
        $permissions = [
            'member.list' => [
                'title' => '회원정보보기',
                'tab' => '회원관리'
            ],
            'member.edit' => [
                'title' => '회원정보수정',
                'tab' => '회원관리'
            ],
            'member.setting' => [
                'title' => '회원설정',
                'tab' => '회원관리'
            ],
        ];
        $register = $this->app->make('xe.register');
        foreach ($permissions as $id => $permission) {
            $register->push('settings/permission', $id, $permission);
        }
    }

    private function addRelationship()
    {

        /** @var MemberRepository $memberRepo */
        $memberRepo = $this->app['xe.members'];

        /** @var VirtualGroupRepository $vGroupRepo */
        $vGroupRepo = $this->app['xe.member.virtualGroups'];

        // add virtual_groups to MemberRepository
        $memberRepo->addRelation(
            'virtual_groups',
            function ($memberIds) use ($vGroupRepo) {
                $members = [];
                foreach ($memberIds as $memberId) {
                    $groups = $vGroupRepo->fetchAllByMember($memberId);
                    $members[$memberId] = $groups;
                }
                return $members;
            },
            null
        );
    }

    private function setProfileImageResolverOfMember()
    {
        $default = $this->app['config']['xe.member.profileImage.default'];

        MemberEntity::setProfileImageResolver(
            function ($imageId) use ($default) {
                /** @var Image $image */
                if (!$image = Image::find($imageId)) {
                    return asset($default);
                }

                return asset($image->url());
            }
        );
    }
}

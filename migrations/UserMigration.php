<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class UserMigration extends Migration {

    public function install()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('user ID');
            $table->string('display_name', 255)->unique()->comment('display name.');
            $table->string('email', 255)->nullable()->comment('email');
            $table->string('password', 255)->nullable()->comment('password');
            $table->string('rating', 15)->default('member')->comment('user rating. guest/member/manager/super');
            $table->string('status', 20)->comment('account status. activated/deactivated');
            $table->text('introduction')->default(null)->nullable()->comment('user introduction');
            $table->string('profile_image_id', 36)->nullable()->comment('profile image file ID');
            $table->string('remember_token', 255)->nullable()->comment('token for keep login');
            $table->timestamp('login_at')->nullable()->comment('login date');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->index()->comment('updated date');
            $table->timestamp('password_updated_at')->nullable()->comment('password updated date');

            $table->primary('id');
        });
        Schema::create('user_group', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('group ID');
            $table->string('name')->comment('group name');
            $table->string('description', 1000)->comment('group description');
            $table->integer('order')->default(0)->index()->comment('order number');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->primary('id');
        });

        Schema::create('user_group_user', function (Blueprint $table) {
            // user IDs included in the use group
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('group_id', 36)->comment('group ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->timestamp('created_at')->nullable()->comment('created date');

            $table->unique(['group_id','user_id']);
            $table->index('group_id');
            $table->index('user_id');
        });

        Schema::create('user_account', function (Blueprint $table) {
            // user account. Login via account information provided by other providers. As like OAuth.
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('ID');
            $table->string('user_id')->comment('user ID');
            $table->string('account_id')->comment('account Id');
            $table->string('email')->nullable()->comment('email');
            $table->char('provider', 20)->comment('OAuth provider. naver/twitter/facebook/...');
            $table->string('token', 500)->comment('token');
            $table->string('token_secret', 500)->comment('token secret');
            $table->timestamp('created_at')->nullable()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->primary('id');
            $table->unique(['provider','account_id']);
        });

        Schema::create('user_email', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->string('address')->comment('email address');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->index('user_id');
            $table->index('address');
        });

        Schema::create('user_pending_email', function (Blueprint $table) {
            // email confirm
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->string('address')->comment('email address');
            $table->string('confirmation_code')->nullable()->comment('confirmation code');
            $table->timestamp('created_at')->nullable()->index()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->index('user_id');
            $table->index('address');
        });

        Schema::create('user_password_resets', function (Blueprint $table) {
            // find account password
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('email')->index()->comment('email address');
            $table->string('token')->index()->comment('token');
            $table->timestamp('created_at')->nullable()->comment('created date');
        });

        Schema::create('user_register_token', function (Blueprint $table) {
            // find account password
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('user ID');
            $table->string('guard', 100)->comment('the guard creating token');
            $table->text('data')->comment('token data');
            $table->timestamp('created_at')->nullable()->comment('created date');
        });

        Schema::create('user_terms', function (Blueprint $table) {
            $table->string('id', 36);
            $table->string('title');
            $table->string('content')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_enabled')->default(false);

            $table->primary('id');
            $table->engine = "InnoDB";
        });

    }

    public function installed()
    {
        \DB::table('config')->insert([
                                         ['name' => 'user', 'vars' => '[]'],
                                         ['name' => 'user.common', 'vars' => '{"secureLevel":"low","useCaptcha":false,"webmasterName":"webmaster","webmasterEmail":"webmaster@domain.com","agreement":"","privacy":""}'],
                                         ['name' => 'user.join', 'vars' => '{"joinable":true}'],
                                         ['name' => 'toggleMenu@user', 'vars' => '{"activate":["user/toggleMenu/xpressengine@raw"]}']
                                     ]);
    }

    public function init()
    {
        // add default user groups
        $joinGroup = app('xe.user')->groups()->create(
            [
                'name' => '정회원',
                'description' => 'default user group'
            ]
        );
        app('xe.user')->groups()->create(
            [
                'name' => '준회원',
                'description' => 'sub user group'
            ]
        );
        $joinConfig = app('xe.config')->get('user.join');

        $joinConfig->set('joinGroup', $joinGroup->id);
        app('xe.config')->modify($joinConfig);

        // set admin's group
        auth()->user()->joinGroups($joinGroup);
    }

    /**
     * 서비스가 업데이트되었을 경우, update()메소드를 실행해야 하는지의 여부를 체크한다.
     * update()메소드를 실행해야 한다면 false를 반환한다.
     *
     * @param string $installedVersion current version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        // ver.3.0.0-beta.18
        if (!Schema::hasTable('user_register_token')) {
            return false;
        }

        // ver.3.0.0-beta.24
        $joinConfig = app('xe.config')->get('user.join');
        $config = $joinConfig->getPureAll();
        if (array_has($config, 'useEmailCertify') || array_has($config, 'useCaptcha')) {
            return false;
        }

        // ver.3.0.0-beta.27
        if (!Schema::hasTable('user_terms')) {
            return false;
        }
    }

    /**
     * update 코드를 실행한다.
     *
     * @param string $installedVersion current version
     *
     * @return mixed
     */
    public function update($installedVersion = null)
    {
        // ver.3.0.0-beta.6
        if (Schema::hasColumn('user_group', 'count')) {
            Schema::table('user_group', function ($table) {
                $table->dropColumn('count');
            });
        }
        if (!Schema::hasColumn('user_account', 'token_secret')) {
            Schema::table('user_account', function ($table) {
                $table->string('token_secret', 500);
            });
        }

        // ver.3.0.0-beta.17
        if (!Schema::hasColumn('user', 'login_at')) {
            Schema::table('user', function ($table) {
                $table->timestamp('login_at')->nullable();
            });
        }

        // ver.3.0.0-beta.18
        if (Schema::hasTable('password_resets')) {
            Schema::rename('password_resets', 'user_password_resets');
        }
        if (Schema::hasColumn('user_account', 'data')) {
            Schema::table('user_account', function ($table) {
                $table->dropColumn('data');
            });
        }
        if (!Schema::hasTable('user_register_token')) {
            Schema::create('user_register_token', function (Blueprint $table) {
                // find account password
                $table->engine = "InnoDB";

                $table->string('id', 36)->comment('user ID');
                $table->string('guard', 100)->comment('the guard creating token');
                $table->text('data')->comment('token data');
                $table->timestamp('created_at')->nullable()->comment('created date');
            });
        }

        // ver.3.0.0-beta.24
        $joinConfig = app('xe.config')->get('user.join');

        $use = $joinConfig->get('useEmailCertify');
        if ($use !== null) {
            $guards = $joinConfig->get('guards', []);
            if ($use && !in_array('email', $guards)) {
                array_unshift($guards, 'email');
            }
            $joinConfig->set('useEmailCertify', null);
            $joinConfig->set('guard_forced', $use);
            app('xe.config')->modify($joinConfig);
        }
        $use = $joinConfig->get('useCaptcha');
        if ($use !== null) {
            $guards = $joinConfig->get('guards', []);
            if ($use && !in_array('captcha', $guards)) {
                array_unshift($guards, 'captcha');
            }
            $joinConfig->set('useCaptcha', null);
            app('xe.config')->modify($joinConfig);
        }

        // ver.3.0.0-beta.27
        if (!Schema::hasTable('user_terms')) {
            Schema::create('user_terms', function (Blueprint $table) {
                $table->string('id', 36);
                $table->string('title');
                $table->string('content')->nullable();
                $table->integer('order')->default(0);
                $table->boolean('is_enabled')->default(false);

                $table->primary('id');
                $table->engine = "InnoDB";
            });

            // todo: schema 변경됨 수정 필요
            $commonConfig = app('xe.config')->get('user.common');
            $tos = $commonConfig->get('agreement');
            $tosTitleKey = 'user::'.app('xe.keygen')->generate();
            \XeLang::save($tosTitleKey, 'ko', '서비스 이용약관');
            \XeLang::save($tosTitleKey, 'en', 'Terms of Service');
            $tosContentKey = 'user::'.app('xe.keygen')->generate();
            \XeLang::save($tosContentKey, 'ko', $tos);
            app('xe.terms')->create([
                'title' => $tosTitleKey,
                'content' => $tosContentKey,
                'order' => 0,
                'is_enabled' => true,
            ]);

            $privacy = $commonConfig->get('privacy');
            $privacyTitleKey = 'user::'.app('xe.keygen')->generate();
            \XeLang::save($privacyTitleKey, 'ko', '개인정보 보호정책');
            \XeLang::save($privacyTitleKey, 'en', 'Privacy Policy');
            $privacyContentKey = 'user::'.app('xe.keygen')->generate();
            \XeLang::save($privacyContentKey, 'ko', $privacy);
            app('xe.terms')->create([
                'title' => $privacyTitleKey,
                'content' => $privacyContentKey,
                'order' => 1,
                'is_enabled' => true,
            ]);
        }

    }


}

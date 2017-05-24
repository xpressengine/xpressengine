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
            $table->string('displayName', 255)->unique()->comment('display name.');
            $table->string('email', 255)->nullable()->comment('email');
            $table->string('password', 255)->nullable()->comment('password');
            $table->string('rating', 15)->default('member')->comment('user rating. guest/member/manager/super');
            $table->char('status', 20)->comment('account status. activated/deactivated');
            $table->text('introduction')->default(null)->nullable()->comment('user introduction');
            $table->string('profileImageId', 36)->nullable()->comment('profile image file ID');
            $table->string('rememberToken', 255)->nullable()->comment('token for keep login');
            $table->timestamp('loginAt')->comment('login date');
            $table->timestamp('createdAt')->index()->comment('created date');
            $table->timestamp('updatedAt')->index()->comment('updated date');
            $table->timestamp('passwordUpdatedAt')->comment('password updated date');

            $table->primary('id');
        });
        Schema::create('user_group', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('group ID');
            $table->string('name')->comment('group name');
            $table->string('description', 1000)->comment('group description');
            $table->integer('order')->default(0)->index()->comment('order number');
            $table->timestamp('createdAt')->index()->comment('created date');
            $table->timestamp('updatedAt')->comment('updated date');

            $table->primary('id');
        });

        Schema::create('user_group_user', function (Blueprint $table) {
            // user IDs included in the use group
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('groupId', 36)->comment('group ID');
            $table->string('userId', 36)->comment('user ID');
            $table->timestamp('createdAt')->comment('created date');

            $table->unique(['groupId','userId']);
            $table->index('groupId');
            $table->index('userId');
        });

        Schema::create('user_account', function (Blueprint $table) {
            // user account. Login via account information provided by other providers. As like OAuth.
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('ID');
            $table->string('userId')->comment('user ID');
            $table->string('accountId')->comment('account Id');
            $table->string('email')->nullable()->comment('email');
            $table->char('provider', 20)->comment('OAuth provider. naver/twitter/facebook/...');
            $table->string('token', 500)->comment('token');
            $table->string('tokenSecret', 500)->comment('token secret');
            $table->timestamp('createdAt')->comment('created date');
            $table->timestamp('updatedAt')->comment('updated date');

            $table->primary('id');
            $table->unique(['provider','accountId']);
        });

        Schema::create('user_email', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('userId', 36)->comment('user ID');
            $table->string('address')->comment('email address');
            $table->timestamp('createdAt')->index()->comment('created date');
            $table->timestamp('updatedAt')->comment('updated date');

            $table->index('userId');
            $table->index('address');
        });

        Schema::create('user_pending_email', function (Blueprint $table) {
            // email confirm
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('userId', 36)->comment('user ID');
            $table->string('address')->comment('email address');
            $table->string('confirmationCode')->nullable()->comment('confirmation code');
            $table->timestamp('createdAt')->index()->comment('created date');
            $table->timestamp('updatedAt')->comment('updated date');

            $table->index('userId');
            $table->index('address');
        });

        Schema::create('user_password_resets', function (Blueprint $table) {
            // find account password
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('email')->index()->comment('email address');
            $table->string('token')->index()->comment('token');
            $table->timestamp('created_at')->comment('created date');
        });

        Schema::create('user_register_token', function (Blueprint $table) {
            // find account password
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('user ID');
            $table->string('guard', 100)->comment('the guard creating token');
            $table->text('data')->comment('token data');
            $table->timestamp('createdAt')->comment('created date');
        });

    }

    public function installed()
    {
        \DB::table('config')->insert([
                                         ['name' => 'user', 'vars' => '[]'],
                                         ['name' => 'user.common', 'vars' => '{"secureLevel":"low","useCaptcha":false,"webmasterName":"webmaster","webmasterEmail":"webmaster@domain.com","agreement":"","privacy":""}'],
                                         ['name' => 'user.join', 'vars' => '{"joinable":true,"useEmailCertify":false,"useCaptcha":false}'],
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
        // ver.3.0.0-rc
        return Schema::hasTable('user_register_token');
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
        if (!Schema::hasColumn('user_account', 'tokenSecret')) {
            Schema::table('user_account', function ($table) {
                $table->string('tokenSecret', 500);
            });
        }

        // ver.3.0.0-beta.17
        if (!Schema::hasColumn('user', 'loginAt')) {
            Schema::table('user', function ($table) {
                $table->timestamp('loginAt');
            });
        }

        // ver.3.0.0-rc
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
                $table->timestamp('createdAt')->comment('created date');
            });
        }

    }


}

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

            $table->string('id', 36);
            $table->string('displayName', 255)->unique();
            $table->string('email', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('rating', 15)->default('member');
            $table->char('status', 20);
            $table->text('introduction')->default(null)->nullable();
            $table->string('profileImageId', 36)->nullable();
            $table->string('rememberToken', 255)->nullable();
            $table->timestamp('createdAt')->index();
            $table->timestamp('updatedAt')->index();
            $table->timestamp('passwordUpdatedAt');

            $table->primary('id');
        });

        Schema::create('user_group', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table->string('name');
            $table->string('description', 1000);
            $table->integer('order')->default(0)->index();
            $table->timestamp('createdAt')->index();
            $table->timestamp('updatedAt');

            $table->primary('id');
        });

        Schema::create('user_group_user', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('groupId', 36);
            $table->string('userId', 36);
            $table->timestamp('createdAt');

            $table->unique(['groupId','userId']);
            $table->index('groupId');
            $table->index('userId');
        });

        Schema::create('user_account', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table->string('userId');
            $table->string('accountId');
            $table->string('email')->nullable();
            $table->char('provider', 20);
            $table->string('token', 500);
            $table->string('tokenSecret', 500);
            $table->string('data');
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');

            $table->primary('id');
            $table->unique(['provider','accountId']);
        });

        Schema::create('user_email', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('userId', 36);
            $table->string('address');
            $table->timestamp('createdAt')->index();
            $table->timestamp('updatedAt');

            $table->index('userId');
            $table->index('address');
        });

        Schema::create('user_pending_email', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('userId', 36);
            $table->string('address');
            $table->string('confirmationCode')->nullable();
            $table->timestamp('createdAt')->index();
            $table->timestamp('updatedAt');

            $table->index('userId');
            $table->index('address');
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at');
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
        // ver.3.0.0-beta.6
        if (Schema::hasColumn('user_group', 'count')) {
            return false;
        }
        if (!Schema::hasColumn('user_account', 'tokenSecret')) {
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
        if (!Schema::hasColumn('user_account', 'tokenSecret')) {
            Schema::table('user_account', function ($table) {
                $table->string('tokenSecret', 500);
            });
        }
    }


}

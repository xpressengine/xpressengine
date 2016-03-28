<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class UserMigration implements Migration {

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
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');
            $table->timestamp('passwordUpdatedAt');

            $table->primary('id');
        });

        Schema::create('user_group', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table->string('name');
            $table->string('description', 1000);
            $table->integer('count')->default(0);
            $table->integer('order')->default(0);
            $table->timestamp('createdAt');
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
            $table->timestamp('createdAt');
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
            $table->timestamp('createdAt');
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
                                         ['name' => 'user.common', 'vars' => '{"secureLevel":"low","useCaptcha":false,"webmasterName":"webmaster","webmasterEmail":"webmaster@domain.com"}'],
                                         ['name' => 'user.join', 'vars' => '{"joinable":true,"useEmailCertify":false,"agreement":"","useCaptcha":false}'],
                                         ['name' => 'user.usermenu', 'vars' => '{"activate":[]}'],
                                     ]);
    }

    public function update($currentVersion)
    {

    }

    public function checkInstall()
    {
    }

    public function checkUpdate($currentVersion)
    {
    }
}

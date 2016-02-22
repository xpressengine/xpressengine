<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class PermissionMigration implements Migration {

    public function install()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('siteKey', 50)->default('default');
//            $table->string('type', 20);
            $table->string('name');
            $table->text('grants');
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');

//            $table->unique(['siteKey', 'type', 'name']);
            $table->unique(['siteKey', 'name']);
        });
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

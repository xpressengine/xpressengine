<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class RoutingMigration implements Migration {

    public function install()
    {
        Schema::create('instanceRoute', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('url');
            $table->string('module');
            $table->string('instanceId');
            $table->string('menuId');
            $table->string('siteKey');

            $table->unique('instanceId');
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

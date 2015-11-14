<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class ConfigMigration implements Migration {

    public function install()
    {
        Schema::create('config', function ($table) {
            $table->engine = "InnoDB";

            $table->string('siteKey', 50)->default('default');
            $table->string('name', 255);
            $table->text('vars')->default('');
            $table->primary(['siteKey', 'name']);
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

<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class TemporaryMigration implements Migration {

    public function install()
    {
        Schema::create('temporary', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', '36');
            $table->string('userId', '36');
            $table->string('key');
            $table->text('val');
            $table->mediumText('etc');
            $table->boolean('isAuto');
            $table->timestamp('createdAt');

            $table->primary('id');
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

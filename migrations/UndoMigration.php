<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class UndoMigration implements Migration {

    public function install()
    {
        Schema::create('undo_data', function (Blueprint $table) {
            $table->engine = "InnoDB";
            
            $table->increments('id');
            $table->string('namespace', 255);
            $table->string('user_id', 36);
            $table->text('data')->default('');
            $table->unique('namespace');
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

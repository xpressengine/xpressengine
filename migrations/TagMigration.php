<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class TagMigration implements Migration {

    public function install()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('instanceId')->nullable();
            $table->string('word', 100);
            $table->string('decomposed');
            $table->integer('count');

            $table->index('instanceId');
            $table->index('decomposed');
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('tagId');
            $table->string('taggableId', 36);
            $table->integer('position');
            $table->timestamp('createdAt');

            $table->unique(['tagId', 'taggableId']);
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

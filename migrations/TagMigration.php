<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class TagMigration implements Migration {

    public function install()
    {
        Schema::create('tag_item', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('instanceId');
            $table->string('word', 100);
            $table->string('decomposed');
            $table->integer('count');
            $table->timestamp('createdAt');

            $table->index('instanceId');
            $table->index('decomposed');
        });

        Schema::create('tag_item_used', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('targetId', 36);
            $table->integer('itemId');
            $table->timestamp('createdAt');

            $table->unique(['targetId', 'itemId']);
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

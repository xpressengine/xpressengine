<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class CategoryMigration implements Migration {

    public function install()
    {
        Schema::create('category_group', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('name', 100);
            $table->integer('count');
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');
        });

        Schema::create('category_item', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('categoryId');
            $table->string('word', 250);
            $table->text('description');
            $table->integer('count');
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');
            $table->integer('ordering');

            $table->index('categoryId');
        });

        Schema::create('category_item_used', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('targetId', 36);
            $table->integer('itemId');
            $table->timestamp('createdAt');

            $table->unique(['targetId', 'itemId']);
        });

        Schema::create('category_item_hierarchy', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id');
            $table->bigInteger('ancestor');
            $table->bigInteger('descendant');
            $table->tinyInteger('depth');

            $table->unique(['ancestor', 'descendant']);
            $table->index('ancestor');
            $table->index('descendant');
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

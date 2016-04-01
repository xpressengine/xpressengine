<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class CategoryMigration implements Migration {

    public function install()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('name', 100);
            $table->integer('count');
        });

        Schema::create('category_item', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->integer('categoryId');
            $table->integer('parentId')->nullable();
            $table->string('word', 250);
            $table->text('description');
            $table->integer('ordering');

            $table->index('categoryId');
            $table->index('parentId');
        });

        Schema::create('category_closure', function (Blueprint $table) {
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

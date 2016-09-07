<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class CategoryMigration extends Migration {

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
}

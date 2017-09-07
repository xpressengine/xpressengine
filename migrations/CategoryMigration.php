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
            // category item group
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('name', 100)->comment('category name');
            $table->integer('count')->comment('The count of category item');
        });

        Schema::create('category_item', function (Blueprint $table) {
            // category item
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->integer('category_id')->comment('category ID.');
            $table->integer('parent_id')->nullable()->comment('parent ID. parent category item ID.');
            $table->string('word', 250)->comment('string of category item. It can be code of translation information.');
            $table->text('description')->comment('description of category item. It can be code of translation information.');
            $table->integer('ordering')->comment('ordering number of category item sort.');

            $table->index('category_id');
            $table->index('parent_id');
        });

        Schema::create('category_closure', function (Blueprint $table) {
            // category item tree information
            $table->engine = "InnoDB";

            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('ancestor')->comment('parent category item ID');
            $table->bigInteger('descendant')->comment('child category item ID');
            $table->tinyInteger('depth')->comment('depth');

            $table->unique(['ancestor', 'descendant']);
            $table->index('ancestor');
            $table->index('descendant');
        });
    }
}

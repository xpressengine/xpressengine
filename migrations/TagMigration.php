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

class TagMigration extends Migration {

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
}

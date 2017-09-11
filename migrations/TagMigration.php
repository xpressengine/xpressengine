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

            $table->increments('id')->comment('tag ID');
            $table->string('instance_id')->nullable()->comment('instance ID');
            $table->string('word', 100)->comment('tag');
            $table->string('decomposed')->comment('decomposed. for auto complete.');
            $table->integer('count')->comment('same tag registrations count');

            $table->index('instance_id');
            $table->index('decomposed');
        });

        Schema::create('taggables', function (Blueprint $table) {
            // mapping a tag to target. If Document saved a tag, [taggableId] is document ID.
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->integer('tag_id')->comment('tag ID');
            $table->string('taggable_id', 36)->comment('target ID. If Document saved a tag, [taggable_id] is document ID.');
            $table->integer('position')->comment('position number within same [taggable_id]');
            $table->timestamp('createdAt')->comment('created date');

            $table->unique(['tag_id', 'taggable_id']);
        });
    }
}

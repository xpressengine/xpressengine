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

class StorageMigration extends Migration {

    public function install()
    {

        Schema::create('files', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table->string('originId', 36)->nullable();
            $table->string('userId', 36)->nullable();
            $table->string('disk', 20)->charset('latin1');
            $table->string('path')->charset('latin1');
            $table->string('filename', 100)->charset('latin1');
            $table->string('clientname', 100);
            $table->string('mime', 50);
            $table->integer('size');
            $table->integer('useCount')->default(0);
            $table->integer('downloadCount')->default(0);
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');

            $table->primary('id');
            $table->unique(['disk', 'path', 'filename'], 'findKey');
            $table->index('originId');
        });

        Schema::create('fileables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fileId', 36);
            $table->string('fileableId', 36);
            $table->timestamp('createdAt');

            $table->unique(['fileId', 'fileableId']);
        });
    }
}

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

class MediaMigration extends Migration {

    public function install()
    {
        Schema::create('files_image', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('fileId', 36);
            $table->string('type', 20)->nullable();
            $table->string('code', 20)->nullable();
            $table->integer('width');
            $table->integer('height');

            $table->index('fileId');
        });

        Schema::create('files_video', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('fileId', 36);
            $table->string('audio');
            $table->string('video');
            $table->integer('playtime');
            $table->integer('bitrate');

            $table->index('fileId');
        });

        Schema::create('files_audio', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('fileId', 36);
            $table->string('audio');
            $table->integer('playtime');
            $table->integer('bitrate');

            $table->index('fileId');
        });
    }
}

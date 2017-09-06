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
            // image file information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID.');
            $table->string('type', 20)->nullable()->comment('thumbnail type. fit/letter/widen/heighten/stretch/spill/...');
            $table->string('code', 20)->nullable()->comment('code. thumbnail type code.');
            $table->integer('width')->comment('width');
            $table->integer('height')->comment('height');

            $table->index('file_id');
        });

        Schema::create('files_video', function (Blueprint $table) {
            // video file information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID.');
            $table->string('audio')->comment('audio information. JSON date type.');
            $table->string('video')->comment('video information. JSON date type.');
            $table->integer('playtime')->comment('play time');
            $table->integer('bitrate')->comment('bit rate');

            $table->index('file_id');
        });

        Schema::create('files_audio', function (Blueprint $table) {
            // audio file information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID.');
            $table->string('audio')->comment('audio information. JSON date type.');
            $table->integer('playtime')->comment('play time');
            $table->integer('bitrate')->comment('bit rate');

            $table->index('file_id');
        });
    }
}

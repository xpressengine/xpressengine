<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class MediaMigration implements Migration {

    public function install()
    {
        Schema::create('files_image', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table->string('originId', 36)->nullable();
            $table->string('type', 20)->nullable();
            $table->string('code', 20)->nullable();
            $table->integer('width');
            $table->integer('height');

            $table->primary('id');
            $table->index('originId');
        });

        Schema::create('files_video', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table->string('originId', 36)->nullable();
            $table->string('audio');
            $table->string('video');
            $table->integer('playtime');
            $table->integer('bitrate');

            $table->primary('id');
            $table->index('originId');
        });

        Schema::create('files_audio', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36);
            $table->string('originId', 36)->nullable();
            $table->string('audio');
            $table->integer('playtime');
            $table->integer('bitrate');

            $table->primary('id');
            $table->index('originId');
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

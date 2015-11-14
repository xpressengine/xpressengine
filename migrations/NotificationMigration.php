<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class NotificationMigration implements Migration {

    public function install()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id');
            $table->string('title');
            $table->string('type');
            $table->string('link');
            $table->text('content')->nullable();
            $table->string('sender');
            $table->string('receiver');
            $table->timestamp('sendAt');
            $table->timestamp('readAt')->nullable();

            $table->primary('id');
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

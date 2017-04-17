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

class PermissionMigration extends Migration {

    public function install()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('siteKey', 50)->default('default')->comment('site key. for multi web site support.');
//            $table->string('type', 20);
            $table->string('name')->comment('permission name');
            $table->text('grants')->comment('grant information. JSON data type.');
            $table->timestamp('createdAt')->comment('date of created');
            $table->timestamp('updatedAt')->comment('date of updated');

//            $table->unique(['siteKey', 'type', 'name']);
            $table->unique(['siteKey', 'name']);
        });
    }
}

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
            $table->string('site_key', 50)->default('default')->comment('site key. for multi web site support.');
//            $table->string('type', 20);
            $table->string('name')->comment('permission name');
            $table->text('grants')->comment('grant information. JSON data type.');
            $table->timestamp('created_at')->comment('created date');
            $table->timestamp('updated_at')->comment('updated date');

//            $table->unique(['siteKey', 'type', 'name']);
            $table->unique(['site_key', 'name']);
        });
    }
}

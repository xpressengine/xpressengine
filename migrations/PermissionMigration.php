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

            $table->increments('id');
            $table->string('siteKey', 50)->default('default');
//            $table->string('type', 20);
            $table->string('name');
            $table->text('grants');
            $table->timestamp('createdAt');
            $table->timestamp('updatedAt');

//            $table->unique(['siteKey', 'type', 'name']);
            $table->unique(['siteKey', 'name']);
        });
    }
}

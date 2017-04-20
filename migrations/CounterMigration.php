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

class CounterMigration extends Migration {

    public function install()
    {
        Schema::create('counter_log', function ($table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id')->comment('ID');
            $table->string('counterName', 36)->comment('counter name');
            $table->string('counterOption', 36)->comment('counter option');
            $table->string('targetId', 36)->comment('target ID');
            $table->string('userId', 36)->comment('user ID');
            $table->integer('point')->default(1)->comment('point');
            $table->string('ipaddress', 16)->comment('IP address');
            $table->timestamp('createdAt')->comment('created date');

            $table->index(['targetId', 'userId']);
            $table->index(['targetId', 'counterName']);
        });

        \DB::table('config')->insert(['name' => 'counter', 'vars' => '{}']);
    }

}

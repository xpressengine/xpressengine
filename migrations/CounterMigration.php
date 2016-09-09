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

            $table->bigIncrements('id');
            $table->string('counterName', 36);
            $table->string('counterOption', 36);
            $table->string('targetId', 36);
            $table->string('userId', 36);
            $table->integer('point')->default(1);
            $table->string('ipaddress', 16);
            $table->timestamp('createdAt');

            $table->index(['targetId', 'userId']);
            $table->index(['targetId', 'counterName']);
        });

        \DB::table('config')->insert(['name' => 'counter', 'vars' => '{}']);
    }

}

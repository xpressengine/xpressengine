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
            $table->string('counter_name', 36)->comment('counter name');
            $table->string('counter_option', 36)->comment('counter option');
            $table->string('target_id', 36)->comment('target ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->integer('point')->default(1)->comment('point');
            $table->string('ipaddress', 16)->comment('IP address');
            $table->timestamp('created_at')->comment('created date');

            $table->index(['target_id', 'user_id']);
            $table->index(['target_id', 'counter_name']);
        });

        \DB::table('config')->insert(['name' => 'counter', 'vars' => '{}']);
    }

}

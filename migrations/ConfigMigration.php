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

class ConfigMigration extends Migration {

    public function install()
    {
        Schema::create('config', function ($table) {
            $table->engine = "InnoDB";

            $table->string('site_key', 50)->default('default')->comment('site key. for multi web site support.');
            $table->string('name', 255)->comment('site name');
            $table->text('vars')->default('')->comment('setting values. JSON data type.');
            $table->primary(['site_key', 'name']);
        });
    }
}

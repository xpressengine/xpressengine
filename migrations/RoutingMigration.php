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

class RoutingMigration extends Migration {

    public function install()
    {
        Schema::create('instance_route', function (Blueprint $table) {
            // instance route information. creating when creating menu items.
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('url')->comment('URL');
            $table->string('module')->comment('module ID');
            $table->string('instance_id')->comment('instance ID. menu item ID');
            $table->string('menu_id')->comment('menu ID. menu ID');
            $table->string('site_key')->comment('site key. for multi web site support.');

            $table->unique('instance_id');
        });
    }
}

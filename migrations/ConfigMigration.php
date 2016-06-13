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

class ConfigMigration implements Migration {

    public function install()
    {
        Schema::create('config', function ($table) {
            $table->engine = "InnoDB";

            $table->string('siteKey', 50)->default('default');
            $table->string('name', 255);
            $table->text('vars')->default('');
            $table->primary(['siteKey', 'name']);
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

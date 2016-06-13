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

class TemporaryMigration implements Migration {

    public function install()
    {
        Schema::create('temporary', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', '36');
            $table->string('userId', '36');
            $table->string('key');
            $table->text('val');
            $table->mediumText('etc');
            $table->boolean('isAuto');
            $table->timestamp('createdAt');

            $table->primary('id');
        });
    }

    public function update($installedVersion = null)
    {

    }

    public function checkInstalled()
    {
    }

    public function checkUpdated($installedVersion = null)
    {
    }
}

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

class DraftMigration extends Migration {

    public function install()
    {
        Schema::create('draft', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', '36')->comment('ID');
            $table->string('user_id', '36')->comment('user ID');
            $table->string('key')->comment('key');
            $table->text('val')->comment('val');
            $table->mediumText('etc')->comment('etc');
            $table->boolean('is_auto')->comment('is auto saved');
            $table->timestamp('created_at')->comment('created date');

            $table->primary('id');
        });
    }

    public function update($installedVersion = null)
    {
        // 3.0.0-beta.6
        if (Schema::hasTable('temporary') && !Schema::hasTable('draft')) {
            Schema::rename('temporary', 'draft');
        }
    }

    public function checkUpdated($installedVersion = null)
    {
        // 3.0.0-beta.6
        if (Schema::hasTable('temporary') && !Schema::hasTable('draft')) {
            return false;
        }

        return true;
    }
}

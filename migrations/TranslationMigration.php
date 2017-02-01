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
use XeLang;
use Xpressengine\Support\Migration;

class TranslationMigration extends Migration {

    public function install()
    {
        Schema::create('translation', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('namespace')->charset('latin1')->index();
            $table->string('item')->charset('latin1')->index();
            $table->string('locale')->charset('latin1')->index();
            $table->text('value');
            $table->boolean('multiline')->default(false);
            $table->unique(array('namespace', 'item', 'locale'));
        });
    }

    public function init()
    {
        // initialize
        app('xe.translator')->putFromLangDataSource('xe', app()->langPath()."/common.php");
    }

    public function update($installedVersion = null)
    {
        $this->init();
    }

    public function checkUpdated($installedVersion = null)
    {
        return false;
    }
}

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
            // multiple languages information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('namespace', 50)->index()->comment('item namespace. XE Core use [xe] and plugin use plugin name as like [board], [page].');
            $table->string('item', 100)->index()->comment('item key. A string that can understand meaning when read by a person.');
            $table->string('locale', 6)->index()->comment('language locale code. ko:korean/en:english');
            $table->text('value')->comment('display string');
            $table->boolean('multiline')->default(false)->comment('multiple lines support. Set to 1 if use multiple lines to display string value.');
            $table->unique(array('namespace', 'item', 'locale'));
        });
    }

    public function init()
    {
        // initialize
        app('xe.translator')->putFromLangDataSource('xe', app()->langPath()."/common.php");
        app('xe.translator')->importLaravel(app()->langPath());
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

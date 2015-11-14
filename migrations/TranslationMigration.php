<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use XeLang;
use Xpressengine\Support\Migration;

class TranslationMigration implements Migration {

    public function install()
    {
        Schema::create('translation', function (Blueprint $table) {
            $table->engine = "InnoDB";
            
            $table->increments('id');
            $table->string('namespace')->index();
            $table->string('item')->index();
            $table->string('locale')->index();
            $table->text('value');
            $table->boolean('multiline')->default(false);
            $table->unique(array('namespace', 'item', 'locale'));
        });
    }

    public function installed()
    {
        // seeding
        // 다국어 파일 내용을 db에 넣기
    }

    public function init()
    {
        // initialize
        app('xe.translator')->putFromLangDataSource('xe', app()->langPath()."/common.php");
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

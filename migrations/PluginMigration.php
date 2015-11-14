<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class PluginMigration implements Migration
{

    public function install()
    {
    }

    public function installed()
    {
        \DB::table('config')->insert(['name' => 'plugin', 'vars' => '[]']);
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

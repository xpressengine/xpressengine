<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class SkinMigration implements Migration
{

    public function install()
    {
    }

    public function installed()
    {
        \DB::table('config')->insert(['name' => 'skins', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'skins.selected', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'skins.configs', 'vars' => '[]']);
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

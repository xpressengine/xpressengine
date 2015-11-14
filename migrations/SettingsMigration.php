<?php
namespace Xpressengine\Migrations;

use Xpressengine\Support\Migration;

class SettingsMigration implements Migration {

    public function install()
    {

    }

    public function installed()
    {
        \DB::table('config')->insert(['name' => 'settings', 'vars' => '[]']);
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

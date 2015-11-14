<?php
namespace Xpressengine\Migrations;

use Xpressengine\Support\Migration;

class DynamicFieldMigration implements Migration {

    public function install()
    {

    }

    public function installed()
    {
        \DB::table('config')->insert(['name' => 'dynamicField', 'vars' => '{"required":false,"sortable":false,"searchable":false,"use":true,"tableMethod":false}']);
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

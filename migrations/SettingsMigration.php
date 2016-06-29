<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

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

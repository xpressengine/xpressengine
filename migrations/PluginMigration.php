<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   LGPL-2.1
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link      https://xpressengine.io
 */

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

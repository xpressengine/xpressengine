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

class SkinMigration extends Migration
{
    public function installed()
    {
        \DB::table('config')->insert(['name' => 'skins', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'skins.selected', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'skins.configs', 'vars' => '[]']);
    }
}

<?php
/**
 * SiteMigration.php
 *
 * PHP version 5
 *
 * @category    Migrations
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class SiteMigration implements Migration {

    public function install()
    {
        Schema::create('site', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('host');
            $table->string('siteKey');

            $table->primary('host');
        });
    }

    public function installed()
    {
        $url = \Config::get('app.url');
        $url = preg_replace('#^https?://#', '', $url);
        \DB::table('site')->insert(['host' => $url, 'siteKey' => 'default']);
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

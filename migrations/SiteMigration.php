<?php
/**
 * SiteMigration.php
 *
 * PHP version 5
 *
 * @category    Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

class SiteMigration extends Migration {

    public function install()
    {
        Schema::create('site', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('site_key')->comment('site key');
            $table->string('host')->commet('host');

            $table->primary('site_key');
        });
    }

    public function installed()
    {
        $url = \Config::get('app.url');
        $url = preg_replace('#^https?://#', '', $url);
        \DB::table('site')->insert(['host' => $url, 'site_key' => 'default']);
    }
}

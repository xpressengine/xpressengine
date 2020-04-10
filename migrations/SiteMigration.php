<?php
/**
 * SiteMigration.php
 *
 * PHP version 7
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

/**
 * Class SiteMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SiteMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('site', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('site_key')->comment('site key');
            $table->string('host')->commet('host');

            $table->primary('site_key');
        });
    }

    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed()
    {
        $url = \Config::get('app.url');
        $url = preg_replace('#^https?://#', '', $url);
        \DB::table('site')->insert(['host' => $url, 'site_key' => 'default']);
    }
}

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
use DB;
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
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable()->comment('site created date');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->nullable()->comment('site updated date');

            $table->index('created_at');
            $table->index('updated_at');
            $table->primary('site_key');
        });
    }

    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed($site_key = false)
    {
        if($site_key !== false) return;
        $url = \Config::get('app.url');
        $url = preg_replace('#^https?://#', '', $url);
        \DB::table('site')->insert(['host' => $url, 'site_key' => 'default']);
    }

    /**
     * check updated
     *
     * @param null $installedVersion installed version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        // for 3.0.15
        if (Schema::hasColumn('site', 'created_at') == false) {
            return false;
        }

        return true;
    }

    /**
     * run update
     *
     * @param null $installedVersion installed version
     *
     * @return void
     */
    public function update($installedVersion = null)
    {
        // for 3.0.15
        if (Schema::hasColumn('site', 'created_at') == false) {
            Schema::table('site', function (Blueprint $table) {
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable()->comment('site created date');
                $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'))->nullable()->comment('site updated date');

                $table->index('created_at');
                $table->index('updated_at');
            });
        }
    }
}

<?php
/**
 * CounterMigration.php
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
 * Class CounterMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CounterMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('counter_log', function ($table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id')->comment('ID');
            $table->string('counter_name', 36)->comment('counter name');
            $table->string('counter_option', 36)->comment('counter option');
            $table->string('target_id', 36)->comment('target ID');
            $table->string('user_id', 36)->comment('user ID');
            $table->integer('point')->default(1)->comment('point');
            $table->string('ipaddress', 16)->comment('IP address');
            $table->timestamp('created_at')->nullable()->comment('created date');

            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');

            $table->index(['target_id', 'user_id']);
            $table->index(['target_id', 'counter_name']);
        });
    }

    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed($site_key = 'default')
    {
        \DB::table('config')->insert(['name' => 'counter', 'vars' => '{}','site_key'=>$site_key]);
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
        if(Schema::hasColumn('counter_log', 'site_key') == false) {
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
        if(Schema::hasColumn('counter_log', 'site_key') == false) {
            Schema::table('counter_log', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }
    }
}

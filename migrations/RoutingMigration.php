<?php
/**
 * RoutingMigration.php
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
 * Class RoutingMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class RoutingMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('instance_route', function (Blueprint $table) {
            // instance route information. creating when creating menu items.
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('url')->comment('URL');
            $table->string('module')->comment('module ID');
            $table->string('instance_id')->comment('instance ID. menu item ID');
            $table->string('menu_id')->comment('menu ID. menu ID');
            $table->string('site_key')->comment('site key. for multi web site support.');

            $table->unique('instance_id');
        });
    }
}

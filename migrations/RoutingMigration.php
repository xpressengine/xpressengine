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

            // index
            $table->unique('instance_id');
            $table->index(['url'], 'URL_INDEX');
            $table->index('menu_id');
        });
    }

    /**
     * 서비스에 필요한 환경(타 서비스와 연관된 환경)을 구축한다.
     * db seeding과 같은 코드를 작성한다.
     * @return void
     */
    public function installed()
    {
        Schema::table('instance_route', static function (Blueprint $table) {
            // foreign
            $table->foreign('menu_id')->references('id')->on('menu');
            $table->foreign('site_key')->references('site_key')->on('site');
        });
    }
}

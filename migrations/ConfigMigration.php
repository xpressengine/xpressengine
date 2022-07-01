<?php
/**
 * ConfigMigration.php
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
 * Class ConfigMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ConfigMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('config', function ($table) {
            $table->engine = "InnoDB";

            $table->string('site_key', 50)->default('default')->comment('site key. for multi web site support.');
            $table->string('name', 255)->comment('site name');
            $table->longText('vars')->default('')->comment('setting values. JSON data type.');
            $table->primary(['site_key', 'name']);
        });
    }

    /**
     * 서비스에 필요한 환경(타 서비스와 연관된 환경)을 구축한다.
     * db seeding과 같은 코드를 작성한다.
     * @return void
     */
    public function installed()
    {
        Schema::table('config', function ($table) {
            $table->foreign('site_key')->references('site_key')->on('site');
        });
    }
}

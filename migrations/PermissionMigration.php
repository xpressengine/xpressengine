<?php
/**
 * PermissionMigration.php
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
 * Class PermissionMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PermissionMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('site_key', 50)->default('default')->comment('site key. for multi web site support.');
            $table->string('name')->comment('permission name');
            $table->text('grants')->comment('grant information. JSON data type.');
            $table->timestamp('created_at')->nullable()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->unique(['site_key', 'name']);
        });
    }
}

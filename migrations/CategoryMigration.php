<?php
/**
 * CategoryMigration.php
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
 * Class CategoryMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CategoryMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('category', function (Blueprint $table) {
            // category item group
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('name', 100)->comment('category name');
            $table->integer('count')->default(0)->comment('The count of category item');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');
        });

        Schema::create('category_item', function (Blueprint $table) {
            // category item
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->integer('category_id')->comment('category ID.');
            $table->integer('parent_id')->nullable()->comment('parent ID. parent category item ID.');
            $table->string('word', 250)->comment('string of category item. It can be code of translation information.');
            $table->text('description')->comment('description of category item. It can be code of translation information.');
            $table->integer('ordering')->default(0)->comment('ordering number of category item sort.');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');
            $table->index('category_id');
            $table->index('parent_id');
        });

        Schema::create('category_closure', function (Blueprint $table) {
            // category item tree information
            $table->engine = "InnoDB";

            $table->bigIncrements('id')->comment('ID');
            $table->bigInteger('ancestor')->comment('parent category item ID');
            $table->bigInteger('descendant')->comment('child category item ID');
            $table->tinyInteger('depth')->comment('depth');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');

            $table->unique(['ancestor', 'descendant']);
            $table->index('ancestor');
            $table->index('descendant');
        });
    }

    /**
     * @param null $installedVersion installed version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        if (Schema::hasColumn('category', 'site_key') == false) {
            return false;
        }

        if (Schema::hasColumn('category_item', 'site_key') == false) {
            return false;
        }

        if (Schema::hasColumn('category_closure', 'site_key') == false) {
            return false;
        }

        return true;
    }

    /**
     * @param null $installedVersion installed version
     *
     * @return void
     */
    public function update($installedVersion = null)
    {
        if (Schema::hasColumn('category', 'site_key') == false) {
            Schema::table('category', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }

        if (Schema::hasColumn('category_item', 'site_key') == false) {
            Schema::table('category_item', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }

        if (Schema::hasColumn('category_closure', 'site_key') == false) {
            Schema::table('category_closure', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }
    }

}

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
        if(Schema::hasTable('category') === false){
            Schema::create('category', function (Blueprint $table) {
                // category item group
                $table->engine = "InnoDB";

                $table->increments('id')->comment('ID');
                $table->string('name', 100)->comment('category name');
                $table->integer('count')->default(0)->comment('The count of category item');
            });
        }

        if(Schema::hasTable('category_item') === false) {
            Schema::create('category_item', function (Blueprint $table) {
                // category item
                $table->engine = "InnoDB";

                $table->increments('id')->comment('ID');
                $table->integer('category_id')->comment('category ID.');
                $table->integer('parent_id')->nullable()->comment('parent ID. parent category item ID.');
                $table->string('word', 250)->comment('string of category item. It can be code of translation information.');
                $table->text('description')->comment('description of category item. It can be code of translation information.');
                $table->integer('ordering')->default(0)->comment('ordering number of category item sort.');

                $table->index('category_id');
                $table->index('parent_id');
            });
        }

        if(Schema::hasTable('category_closure') === false) {
            Schema::create('category_closure', function (Blueprint $table) {
                // category item tree information
                $table->engine = "InnoDB";

                $table->bigIncrements('id')->comment('ID');
                $table->bigInteger('ancestor')->comment('parent category item ID');
                $table->bigInteger('descendant')->comment('child category item ID');
                $table->tinyInteger('depth')->comment('depth');

                $table->unique(['ancestor', 'descendant']);
                $table->index('ancestor');
                $table->index('descendant');
            });
        }
    }
}

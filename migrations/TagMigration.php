<?php
/**
 * TagMigration.php
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
 * Class TagMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TagMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id')->comment('tag ID');
            $table->string('instance_id')->nullable()->comment('instance ID');
            $table->string('word', 100)->comment('tag');
            $table->string('decomposed')->comment('decomposed. for auto complete.');
            $table->integer('count')->default(0)->comment('same tag registrations count');

            $table->index('instance_id');
            $table->index('decomposed');
        });

        Schema::create('taggables', function (Blueprint $table) {
            // mapping a tag to target. If Document saved a tag, [taggableId] is document ID.
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->integer('tag_id')->comment('tag ID');
            $table->string('taggable_id', 36)->comment('target ID. If Document saved a tag, [taggable_id] is document ID.');
            $table->integer('position')->default(0)->comment('position number within same [taggable_id]');
            $table->timestamp('created_at')->nullable()->comment('created date');

            $table->unique(['tag_id', 'taggable_id']);
        });
    }
}

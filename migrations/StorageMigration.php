<?php
/**
 * StorageMigration.php
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
 * Class StorageMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class StorageMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {

        Schema::create('files', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('file ID');
            $table->string('origin_id', 36)->nullable()->comment('original file ID');
            $table->string('user_id', 36)->nullable()->comment('own user ID');
            $table->string('disk', 20)->comment('storage locale.');
            $table->string('path')->comment('registered file path. without name');
            $table->string('filename')->comment('registered file name. without extension');
            $table->string('clientname')->comment('original file name');
            $table->string('mime', 50)->comment('mime type');
            $table->integer('size')->comment('file size');
            $table->integer('use_count')->default(0)->comment('use count. how much used in the system.');
            $table->integer('download_count')->default(0)->comment('download count');
            $table->timestamp('created_at')->nullable()->comment('created date');
            $table->timestamp('updated_at')->nullable()->comment('updated date');

            $table->primary('id');
            $table->unique(['disk', 'path', 'filename'], 'findKey');
            $table->index('origin_id');
        });

        Schema::create('fileables', function (Blueprint $table) {
            $table->engine = "InnoDB";

            // mapping a file to target. If Document uploaded a file, [fileableId] is document ID.
            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID');
            $table->string('fileable_id', 36)->comment('target ID. If Document uploaded a file, [fileable_id] is document ID.');
            $table->timestamp('created_at')->nullable()->comment('created date');

            $table->unique(['file_id', 'fileable_id']);
        });
    }
}

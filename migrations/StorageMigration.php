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
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');
            $table->primary('id');
            $table->unique(['disk', 'path', 'filename'], 'findKey');
            $table->index('origin_id');
            $table->index('user_id');
        });

        Schema::create('fileables', function (Blueprint $table) {
            $table->engine = "InnoDB";

            // mapping a file to target. If Document uploaded a file, [fileableId] is document ID.
            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID');
            $table->string('fileable_id', 36)->comment('target ID. If Document uploaded a file, [fileable_id] is document ID.');
            $table->timestamp('created_at')->nullable()->comment('created date');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');
            $table->unique(['file_id', 'fileable_id']);
            $table->index(['fileable_id'], 'FILEABLE_INDEX');
        });
    }


    /**
     * 서비스에 필요한 환경(타 서비스와 연관된 환경)을 구축한다.
     * db seeding과 같은 코드를 작성한다.
     * @return void
     */
    public function installed()
    {
        Schema::table('files', static function (Blueprint $table) {
            // foreign
            $table->foreign('origin_id')->references('id')->on('files');
            $table->foreign('user_id')->references('id')->on('user');
        });

        Schema::table('fileables', static function (Blueprint $table) {
            // foreign
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('site_key')->references('site_key')->on('site');
        });
    }

    /**
     * @param null $installedVersion installed version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        if (Schema::hasColumn('files', 'site_key') == false) {
            return false;
        }

        if (Schema::hasColumn('fileables', 'site_key') == false) {
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
        if (Schema::hasColumn('files', 'site_key') == false) {
            Schema::table('files', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }

        if (Schema::hasColumn('fileables', 'site_key') == false) {
            Schema::table('fileables', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }
    }
}

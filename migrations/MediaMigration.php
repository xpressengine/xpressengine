<?php
/**
 * MediaMigration.php
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
 * Class MediaMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('files_image', function (Blueprint $table) {
            // image file information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID.');
            $table->string('type', 20)->nullable()->comment('thumbnail type. fit/letter/widen/heighten/stretch/spill/...');
            $table->string('code', 20)->nullable()->comment('code. thumbnail type code.');
            $table->integer('width')->comment('width');
            $table->integer('height')->comment('height');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');
            $table->index('file_id');
        });

        Schema::create('files_video', function (Blueprint $table) {
            // video file information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID.');
            $table->string('audio')->comment('audio information. JSON date type.');
            $table->string('video')->comment('video information. JSON date type.');
            $table->integer('playtime')->comment('play time');
            $table->integer('bitrate')->comment('bit rate');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');
            $table->index('file_id');
        });

        Schema::create('files_audio', function (Blueprint $table) {
            // audio file information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('file_id', 36)->comment('file ID.');
            $table->string('audio')->comment('audio information. JSON date type.');
            $table->integer('playtime')->comment('play time');
            $table->integer('bitrate')->comment('bit rate');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');

            $table->index('site_key');
            $table->index('file_id');
        });
    }

    /**
     * 서비스에 필요한 환경(타 서비스와 연관된 환경)을 구축한다.
     * db seeding과 같은 코드를 작성한다.
     * @return void
     */
    public function installed()
    {
        Schema::table('files_image', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('site_key')->references('site_key')->on('site');
        });

        Schema::table('files_video', function (Blueprint $table) {
            $table->foreign('file_id')->references('id')->on('files');
            $table->foreign('site_key')->references('site_key')->on('site');
        });

        Schema::table('files_audio', function (Blueprint $table) {
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
        if (Schema::hasColumn('files_image', 'site_key') == false) {
            return false;
        }

        if (Schema::hasColumn('files_video', 'site_key') == false) {
            return false;
        }

        if (Schema::hasColumn('files_audio', 'site_key') == false) {
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
        if (Schema::hasColumn('files_image', 'site_key') == false) {
            Schema::table('files_image', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }

        if (Schema::hasColumn('files_video', 'site_key') == false) {
            Schema::table('files_video', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }

        if (Schema::hasColumn('files_audio', 'site_key') == false) {
            Schema::table('files_audio', function (Blueprint $table) {
                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }
    }
}

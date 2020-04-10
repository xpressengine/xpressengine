<?php
/**
 * TranslationMigration.php
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
use XeLang;
use Xpressengine\Support\Migration;

/**
 * Class TranslationMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TranslationMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('translation', function (Blueprint $table) {
            // multiple languages information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('namespace', 50)->index()->comment('item namespace. XE Core use [xe] and plugin use plugin name as like [board], [page].');
            $table->string('item', 100)->index()->comment('item key. A string that can understand meaning when read by a person.');
            $table->string('locale', 6)->index()->comment('language locale code. ko:korean/en:english');
            $table->text('value')->comment('display string');
            $table->boolean('multiline')->default(false)->comment('multiple lines support. Set to 1 if use multiple lines to display string value.');
            $table->unique(array('namespace', 'item', 'locale'));
        });
    }

    /**
     * Run after service activation.
     *
     * @return void
     */
    public function init()
    {
        // initialize
        app('xe.translator')->putFromLangDataSource('xe', app()->langPath()."/common.php");
        app('xe.translator')->importLaravel(app()->langPath());
    }

    /**
     * Run when update the application.
     *
     * @param string $installedVersion current version
     * @return void
     */
    public function update($installedVersion = null)
    {
        $this->init();
    }

    /**
     * Determine if executed the migration when application update.
     *
     * @param string $installedVersion current version
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        // update 시 항상 실행되도록 함.
        return false;
    }
}

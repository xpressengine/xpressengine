<?php
/**
 * DraftMigration.php
 *
 * PHP version 7
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Support\Migration;

/**
 * Class DraftMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DraftMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('draft', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', '36')->comment('ID');
            $table->string('user_id', '36')->comment('user ID');
            $table->string('key')->comment('key');
            $table->text('val')->comment('val');
            $table->mediumText('etc')->comment('etc');
            $table->boolean('is_auto')->default(false)->comment('is auto saved');
            $table->timestamp('created_at')->nullable()->comment('created date');

            $table->primary('id');
        });
    }

    /**
     * Run when update the application.
     *
     * @param string|null $installedVersion current version
     * @return void
     */
    public function update($installedVersion = null)
    {
        // 3.0.0-beta.6
        if (Schema::hasTable('temporary') && !Schema::hasTable('draft')) {
            Schema::rename('temporary', 'draft');
        }
    }

    /**
     * Determine if executed the migration when application update.
     *
     * @param string|null $installedVersion current version
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        // 3.0.0-beta.6
        if (Schema::hasTable('temporary') && !Schema::hasTable('draft')) {
            return false;
        }

        return true;
    }
}

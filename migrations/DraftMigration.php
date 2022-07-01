<?php
/**
 * DraftMigration.php
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
 * Class DraftMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
     * 서비스에 필요한 환경(타 서비스와 연관된 환경)을 구축한다.
     * db seeding과 같은 코드를 작성한다.
     * @return void
     */
    public function installed()
    {
        Schema::table('draft', function (Blueprint $table) {
            // foreign
            $table->foreign('user_id')->references('id')->on('user');
        });
    }
}

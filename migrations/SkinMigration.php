<?php
/**
 * SkinMigration.php
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

use Xpressengine\Support\Migration;

/**
 * Class SkinMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SkinMigration extends Migration
{
    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed()
    {
        \DB::table('config')->insert(['name' => 'skins', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'skins.selected', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'skins.configs', 'vars' => '[]']);
    }
}

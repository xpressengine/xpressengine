<?php
/**
 * WidgetboxMigration.php
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
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Support\Migration;

/**
 * Class WidgetboxMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class WidgetboxMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        // create table
        if(!Schema::hasTable('widgetbox')) {
            Schema::create(
                'widgetbox',
                function (Blueprint $table) {
                    $table->engine = "InnoDB";

                    $table->string('id', 100)->comment('ID');
                    $table->string('title', 200)->comment('widget box title');
                    $table->text('content')->comment('widget information. HTML string');
                    $table->text('options')->comment('options');
                    $table->timestamp('created_at')->nullable()->comment('created date');
                    $table->timestamp('updated_at')->nullable()->comment('updated date');
                    $table->primary('id');
                }
            );
        }
    }

    /**
     * Run after service activation.
     *
     * @return void
     */
    public function init()
    {
        // create widgetbox permission
        /** @var PermissionHandler $permission */
        $permission = app('xe.permission');
        if($permission->get('widgetbox') === null) {
            $permission->register('widgetbox', new Grant());
        }

        // dashboard setting
        $handler = app('xe.widgetbox');
        $dashboard = $handler->find('dashboard');
        if($dashboard === null) {

            $handler->create([
                'id'=>'dashboard',
                'title'=>'dashboard',
                'content'=> $this->getDefaultDashboard(),
                'options' => ['presenter' => \Xpressengine\Widget\Presenters\XEUIPresenter::class]
            ]);
        }

        $userProfile = $handler->find('user-profile');
        if($userProfile === null) {
            $handler->create(['id'=>'user-profile', 'title'=>'User Profile']);
        }
    }

    /**
     * Get the widget-box data for the dashboard.
     *
     * @return array
     */
    private function getDefaultDashboard()
    {
        return json_decode('[[{"grid":{"md":6,"xs":"12"},"rows":[],"widgets":[{"@attributes":{"id":"widget\/xpressengine@systemInfo","title":"System Info","skin-id":"widget\/xpressengine@systemInfo\/skin\/xpressengine@default"},"skin":""}]},{"grid":{"md":6,"xs":"12"},"rows":[],"widgets":[{"@attributes":{"id":"widget\/xpressengine@storageSpace","title":"Storage \uc0ac\uc6a9\ub7c9","skin-id":"widget\/xpressengine@storageSpace\/skin\/xpressengine@default"},"limit":"5","skin":""}]}],[{"grid":{"md":"6","xs":"12"},"rows":[],"widgets":[{"@attributes":{"id":"widget\/xpressengine@contentInfo","title":"Content Info","skin-id":"widget\/xpressengine@contentInfo\/skin\/xpressengine@default"}}]},{"grid":{"md":"6","xs":"12"},"rows":[],"widgets":[{"@attributes":{"id":"widget\/news_client@news","title":"News","skin-id":"widget\/news_client@news\/skin\/news_client@default"}}]}]]', true);
    }
}

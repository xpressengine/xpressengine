<?php
/**
 * WidgetboxMigration.php
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
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Support\Migration;

/**
 * Class WidgetboxMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
     * Run when update the application.
     *
     * @param string $installedVersion current version
     * @return void
     */
    public function update($installedVersion = null)
    {
        $this->install();
        $this->init();

        // beta.27 later
        if(!app('xe.widgetbox')->find('dashboard')->content) {
            app('xe.widgetbox')->update('dashboard', [
                'content'=> $this->getDefaultDashboard(),
                'options' => ['presenter' => \Xpressengine\Widget\Presenters\XEUIPresenter::class]
            ]);
        }
    }

    /**
     * Determine if executed the migration when application update.
     *
     * @param string $installedVersion current version
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        // check table
        if(!Schema::hasTable('widgetbox')) {
            return false;
        }

        // check permission
        if(app('xe.permission')->get('widgetbox') === null) {
            return false;
        }

        // check dashboard widgetbox
        if(app('xe.widgetbox')->find('dashboard') === null) {
            return false;
        }

        // check user-profile widgetbox
        if(app('xe.widgetbox')->find('user-profile') === null) {
            return false;
        }

        // beta.27 later
        if(!app('xe.widgetbox')->find('dashboard')->content) {
            return false;
        }

        return true;
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

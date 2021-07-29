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
        // create widget box table
        if(!Schema::hasTable('widgetbox')) {
            Schema::create(
                'widgetbox',
                function (Blueprint $table) {
                    $table->engine = "InnoDB";

                    $table->string('id', 100)->comment('ID');
                    $table->string('title', 200)->comment('widget box title');
                    $table->text('content')->comment('widget information. HTML string');
                    $table->text('options')->comment('options');
                    $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                    $table->timestamp('created_at')->nullable()->comment('created date');
                    $table->timestamp('updated_at')->nullable()->comment('updated date');

                    $table->index('site_key');
                    $table->primary(['site_key','id']);
                }
            );
        }

        // create widget box history table
        if(!Schema::hasTable('widgetbox_history')) {
            $this->createHistoryTable();
        }
    }

    public function installed($siteKey = 'default')
    {
        $siteKey = $siteKey == null ? XeSite::getCurrentSiteKey() : $siteKey;

        if($siteKey != 'default') {
            $this->init($siteKey);
        }
    }

    /**
     * Run after service activation.
     *
     * @return void
     */
    public function init($site_key = 'default')
    {
        // create widgetbox permission
        /** @var PermissionHandler $permission */
        $permission = app('xe.permission');
        if($permission->get('widgetbox') === null) {
            $permission->register('widgetbox', new Grant());
        }

        // dashboard setting
        $handler = app('xe.widgetbox');
        $dashboard = $handler->query()->where('site_key','a')->find('dashboard');

        if($dashboard === null) {
            $handler->create([
                'id'=>'dashboard',
                'title'=>'dashboard',
                'content'=> $this->getDefaultDashboard(),
                'options' => ['presenter' => \Xpressengine\Widget\Presenters\XEUIPresenter::class]
            ]);
        }

        $userProfile = $handler->query()->where('site_key',$site_key)->find('user-profile');
        if($userProfile === null) {
            $handler->create(['id'=>'user-profile', 'title'=>'User Profile']);
        }
    }

    /**
     * check updated
     *
     * @param null $installedVersion installed version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        if (Schema::hasColumn('widgetbox', 'site_key') == false) {
            return false;
        }

        if (!Schema::hasTable('widgetbox_history')) {
            return false;
        }

        return true;
    }

    /**
     * run update
     *
     * @param null $installedVersion installed version
     *
     * @return void
     */
    public function update($installedVersion = null)
    {
        if(Schema::hasColumn('widgetbox', 'site_key') == false) {
            Schema::table('widgetbox', function (Blueprint $table) {
                $table->dropPrimary('id');
                $table->primary(['site_key','id']);

                $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
                $table->index('site_key');
            });
        }

        if (!Schema::hasTable('widgetbox_history')) {
            $this->createHistoryTable();
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

    /**
     * create widget history table
     *
     * @return void
     */
    public function createHistoryTable()
    {
        Schema::create('widgetbox_history', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->unsignedBigInteger('id', true)->comment('ID');
            $table->string('widgetbox_id', 100)->comment('widget Box ID');
            $table->string('site_key', 50)->nullable()->default('default')->comment('site key. for multi web site support.');
            $table->text('content')->comment('written content');
            $table->text('options')->comment('written options');
            $table->timestamp('created_at')->nullable()->comment('created_at');

            $table->index(['site_key', 'widgetbox_id'], 'WIDGETBOX_INDEX');
        });
    }
}

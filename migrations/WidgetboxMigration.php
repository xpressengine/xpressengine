<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\Support\Migration;

class WidgetboxMigration extends Migration {

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
                    $table->timestamp('createdAt')->comment('created date');
                    $table->timestamp('updatedAt')->comment('updated date');
                    $table->primary('id');
                }
            );
        }
    }

    public function init()
    {
        // create widgetbox permission
        /** @var PermissionHandler $permission */
        $permission = app('xe.permission');
        if($permission->get('widgetbox') === null) {
            $permission->register('widgetbox', new Grant());
        }
    }

    public function initialized()
    {
        // dashboard setting
        $handler = app('xe.widgetbox');
        $dashboard = $handler->find('dashboard');
        if($dashboard === null) {
            $handler->create(['id'=>'dashboard', 'title'=>'dashboard', 'content'=>'<div class="xe-row"><div class="xe-col-md-6">
<div class="xe-row widgetarea-row">
<div class="xe-col-md-12">
<div class="widgetarea" data-height="140">

<div class="xe-row">
<div class="xe-col-md-12"><xewidget id="widget/xpressengine@systemInfo" title="System Info" skin-id="widget/xpressengine@systemInfo/skin/xpressengine@default">
  <skin>
  </skin>
</xewidget>
</div>
</div></div>
</div>
</div>
</div><div class="xe-col-md-6">
<div class="xe-row widgetarea-row">
<div class="xe-col-md-12">
<div class="widgetarea" data-height="140">

<div class="xe-row">
<div class="xe-col-md-12"><xewidget id="widget/xpressengine@storageSpace" title="Storage 사용량" skin-id="widget/xpressengine@storageSpace/skin/xpressengine@default">
  <limit>5</limit>
  <skin>
  </skin>
</xewidget>
</div>
</div></div>
</div>
</div>
</div></div><div class="xe-row"><div class="xe-col-md-6">
<div class="xe-row widgetarea-row">
<div class="xe-col-md-12">
<div class="widgetarea" data-height="140">

<div class="xe-row">
<div class="xe-col-md-12"><xewidget id="widget/xpressengine@contentInfo" title="Content Info" skin-id="widget/xpressengine@contentInfo/skin/xpressengine@default">
  <skin>
  </skin>
</xewidget>
</div>
</div></div>
</div>
</div>
</div><div class="xe-col-md-6">
<div class="xe-row widgetarea-row">
<div class="xe-col-md-12 selected">
<div class="widgetarea" data-height="140">

<div class="xe-row">
<div class="xe-col-md-12"><xewidget id="widget/news_client@news" title="News" skin-id="widget/news_client@news/skin/news_client@default">
  <skin>
  </skin>
</xewidget>
</div>
</div></div>
</div>
</div>
</div></div>']);
        }

        $userProfile = $handler->find('user-profile');
        if($userProfile === null) {
            $handler->create(['id'=>'user-profile', 'title'=>'User Profile']);
        }
    }

    protected function check()
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

        return true;
    }

    public function update($installedVersion = null)
    {
        $this->install();
        $this->init();
        $this->initialized();
    }

    public function checkUpdated($installedVersion = null)
    {
        return $this->check();
    }
}

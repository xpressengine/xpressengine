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

                    $table->string('id', 100);
                    $table->string('title', 200);
                    $table->text('content');
                    $table->text('options');
                    $table->timestamp('createdAt');
                    $table->timestamp('updatedAt');
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

    protected function check()
    {
        // check table
        if(!Schema::hasTable('widgetbox')) {
            return false;
        }

        if(app('xe.permission')->get('widgetbox') === null) {
            return false;
        }

        return true;
    }

    public function update($installedVersion = null)
    {
        $this->install();
        $this->init();
    }

    public function checkUpdated($installedVersion = null)
    {
        return $this->check();
    }

    public function checkInstalled()
    {
        return $this->check();
    }
}

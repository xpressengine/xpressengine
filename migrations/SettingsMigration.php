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
use Xpressengine\Support\Migration;

class SettingsMigration extends Migration {

    public function installed()
    {
        \DB::table('config')->insert(['name' => 'settings', 'vars' => '[]']);
        \DB::table('permissions')->insert(['site_key'=> 'default', 'name' => 'settings', 'grants' => '[]']);
        \DB::table('permissions')->insert(['site_key'=> 'default', 'name' => 'settings.user', 'grants' => '[]']);
    }

    /**
     * 서비스에 필요한 자체 환경(타 서비스와 연관이 없는 환경)을 구축한다.
     * 서비스의 db table 생성과 같은 migration 코드를 작성한다.
     *
     * @return mixed
     */
    public function install()
    {
        Schema::create('admin_log', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 36)->comment('Log ID');
            $table->string('type', 255)->comment('logger type');
            $table->string('user_id', 36)->comment('user id');
            $table->char('method', 10)->comment('http method of request');
            $table->string('url', 1000)->comment('url of request');
            $table->text('parameters')->comment('parameters of request');
            $table->string('summary', 2000)->comment('summary for request');
            $table->text('data')->comment('extra data for request');
            $table->string('ipaddress', 16)->comment('ip address');
            $table->timestamp('created_at')->index()->comment('created date');
            $table->timestamp('updated_at')->index()->comment('updated date');

            $table->primary('id');
        });
    }

    /**
     * 서비스가 업데이트되었을 경우, update()메소드를 실행해야 하는지의 여부를 체크한다.
     * update()메소드를 실행해야 한다면 false를 반환한다.
     *
     * @param string $installedVersion current version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        return Schema::hasTable('admin_log');
    }

    /**
     * update 코드를 실행한다.
     *
     * @param string $installedVersion current version
     *
     * @return mixed
     */
    public function update($installedVersion = null)
    {
        if (!Schema::hasTable('admin_log')) {
            $this->install();
        }
    }


}

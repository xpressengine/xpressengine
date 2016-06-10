<?php
/**
 * Database command class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Cache\Console\ClearCommand;

/**
 * command
 *
 * ## 명령어 사용
 * ```
 * php artisan cache --tables=tableName1,tableName2...
 * ```
 *
 * @category    Commands
 * @package     App\Console\Commands
 */
class XeCacheClear extends ClearCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'xeCache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'XE 에서 추가된 모든 Cache store 를 삭제합니다.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        // xe 에서 관리하는 stores
        $stores = [
            'file',
            'lang',
            'plugins',
            'schema',
        ];

        $storeName = $this->argument('store');

        if ($storeName != null) {
            $stores = array_intersect($stores, explode(',', $storeName));
        }

        foreach ($stores as $storeName) {
            $this->laravel['events']->fire('cache:clearing', [$storeName]);

            $this->cache->store($storeName)->flush();

            $this->laravel['events']->fire('cache:cleared', [$storeName]);
        }


        $this->info('Application cache cleared!');
    }
}

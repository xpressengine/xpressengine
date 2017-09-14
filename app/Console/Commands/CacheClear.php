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
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CacheClear extends ClearCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cache:clear-xe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove XE cache files';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // xe 에서 관리하는 stores
        $stores = [
            'file',
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

<?php
/**
 * CacheClearPlus.php
 *
 * PHP version 7
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
use Symfony\Component\Console\Input\InputOption;
use Xpressengine\Interception\InterceptionHandler;

/**
 * Class CacheClearPlus
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CacheClearPlus extends ClearCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'cache:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Flush the application cache and XE cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->laravel['events']->fire(
            'cache:clearing', [$this->argument('store'), $this->tags()]
        );

        $this->cache()->flush();

        $this->flushFacades();

        $this->flushXeCaches();

        $this->laravel['events']->fire(
            'cache:cleared', [$this->argument('store'), $this->tags()]
        );

        $this->info('Cache cleared successfully. XE cache has also been cleared.');
    }

    /**
     * this command basically flush few stores.
     *
     * @return void
     */
    protected function flushXeCaches()
    {
        /**
         * default flush stores
         */
        $stores = ['file', 'schema',];

        $storeName = $this->argument('store');

        if ($storeName != null) {
            $stores = array_intersect($stores, explode(',', $storeName));
        }

        foreach ($stores as $storeName) {
            $this->laravel['events']->fire('cache:clearing', [$storeName, $this->tags()]);

            $this->cache->store($storeName)->flush();

            $this->laravel['events']->fire('cache:cleared', [$storeName, $this->tags()]);
        }

        if (!$this->option('no-proxy')) {
            /** flush interception proxy store */
            app(InterceptionHandler::class)->clearProxies();
        }
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge(parent::getOptions(), [
            ['no-proxy', null, InputOption::VALUE_NONE, 'The interception proxy is except.'],
        ]);
    }
}

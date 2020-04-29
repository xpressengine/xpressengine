<?php
/**
 * StorageServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Storage\File;
use Xpressengine\Storage\FileRepository;
use Xpressengine\Storage\FilesystemHandler;
use Xpressengine\Storage\MimeFilter;
use Xpressengine\Storage\RoundRobinDistributor;
use Xpressengine\Storage\Storage;
use Xpressengine\Storage\TempFileCreator;
use Xpressengine\Storage\UrlMaker;

/**
 * Class StorageServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class StorageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        File::setContentReader(function (File $file) {
            return $this->app['xe.storage']->getFilesystemHandler()->read($file);
        });
        File::setUrlMaker($this->app['xe.storage.url']);
        FileRepository::setModel(File::class);

        $this->hooks();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('xe.storage.temp', function ($app) {
            return new TempFileCreator();
        });

        $this->app->singleton(Storage::class, function ($app) {
            $distributor = new RoundRobinDistributor($app['config']['filesystems'], $app['xe.db']->connection());

            $proxyClass = $app['xe.interception']->proxy(Storage::class, 'XeStorage');

            return new $proxyClass(
                new FileRepository,
                new FilesystemHandler($app['filesystem']),
                $app['auth']->guard(),
                $app['xe.keygen'],
                $distributor,
                $app['xe.storage.temp'],
                $app[ResponseFactory::class],
                new MimeFilter($app['config']['filesystems'])
            );
        });
        $this->app->alias(Storage::class, 'xe.storage');

        $this->app->singleton(UrlMaker::class, function ($app) {
            return new UrlMaker(
                $app['Illuminate\Contracts\Routing\UrlGenerator'],
                $app['config']['filesystems.disks']
            );
        });
        $this->app->alias(UrlMaker::class, 'xe.storage.url');
    }

    /**
     * Add event listener.
     *
     * @return void
     */
    private function hooks()
    {
        intercept(
            'XeSettings@getManageMenu',
            ['storage.managemenu' => ['before' => 'manage.sort']],
            function ($target) {
                $menu          = $target();
                $menu['contents']['submenu']['file'] = [
                    'title' => xe_trans('xe::file'),
                    'description' => '',
                    'link' => '/manage/storage'

                ];
                return $menu;
            }
        );
    }
}

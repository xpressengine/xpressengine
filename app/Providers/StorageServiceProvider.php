<?php
/**
 * This file is registered for use with this package at Laravel
 *
 * PHP version 5
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Storage\File;
use Xpressengine\Storage\FileRepository;
use Xpressengine\Storage\FilesystemHandler;
use Xpressengine\Storage\RoundRobinDistributor;
use Xpressengine\Storage\Storage;
use Xpressengine\Storage\TempFileCreator;
use Xpressengine\Storage\UrlMaker;

/**
 * laravel 프레임워크에서 이 패키지를 사용하기 위한 등록절차를 수행
 *
 * @category    Storage
 * @package     Xpressengine\Storage
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
                new FilesystemHandler($app['filesystem'], $distributor),
                $app['auth']->guard(),
                $app['xe.keygen'],
                $distributor,
                $app['xe.storage.temp'],
                $app[ResponseFactory::class]
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

    private function hooks()
    {
        intercept(
            'XeSettings@getManageMenu',
            ['storage.managemenu' => ['before' => 'manage.sort']],
            function ($target) {
                $menu          = $target();
                $menu['contents']['submenu']['file'] = [
                    'title' => '파일',
                    'description' => 'blur blur~',
                    'link' => '/manage/storage'

                ];
                return $menu;
            }
        );
    }
}

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

use Illuminate\Support\ServiceProvider;
use Xpressengine\Storage\File;
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
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        File::setContentReader($this->app['xe.storage']->getFilesystemHandler());
        File::setUrlMaker($this->app['xe.storage.url']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.storage.temp', function ($app) {
            return new TempFileCreator();
        }, true);

        $this->app->bind('xe.storage', function ($app) {
            $distributor = new RoundRobinDistributor($app['config']['filesystems'], $app['xe.db']->connection());

            $proxyClass = $app['xe.interception']->proxy(Storage::class, 'XeStorage');

            return new $proxyClass(
                new FilesystemHandler($app['filesystem'], $distributor),
                $app['xe.auth'],
                $app['xe.keygen'],
                $distributor,
                $app['xe.storage.temp']
            );
        }, true);

        $this->app->bind(Storage::class, 'xe.storage');

        $this->app->bind('xe.storage.url', function ($app) {
            return new UrlMaker(
                $app['Illuminate\Contracts\Routing\UrlGenerator'],
                $app['config']['filesystems.disks']
            );
        }, true);

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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.storage', 'xe.storage.temp', 'xe.storage.url'];
    }
}

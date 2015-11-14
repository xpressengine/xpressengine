<?php
/**
 * This file is registered for use with this package at Laravel
 *
 * PHP version 5
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\Adapter\Ftp as FtpAdapter;
use Xpressengine\Storage\DatabaseFileRepository;
use Xpressengine\Storage\FileHandler;
use Xpressengine\Storage\RoundRobinDistributor;
use Xpressengine\Storage\Storage;
use Xpressengine\Storage\UrlMaker;

/**
 * laravel 프레임워크에서 이 패키지를 사용하기 위한 등록절차를 수행
 *
 * @category    Storage
 * @package     Xpressengine\Storage
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
        /**
         * @deprecated laravel 버전업되면서 ftp 가 기본으로 포함된 듯
         */
        $this->app['filesystem']->extend('ftp', function ($app, $config) {
            return new Flysystem(new FtpAdapter($config));
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.storage', function ($app) {
            $distributor = new RoundRobinDistributor($app['config']['filesystems'], $app['xe.db']->connection());

            $proxyClass = $app['xe.interception']->proxy(Storage::class, 'Storage');
            return new $proxyClass(
                new FileHandler($app['filesystem'], $distributor),
                new DatabaseFileRepository($app['xe.db']->connection()),
                $app['xe.auth'],
                $app['xe.keygen']
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
            'Settings@getManageMenu',
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
        return ['xe.storage', 'xe.storage.url'];
    }
}

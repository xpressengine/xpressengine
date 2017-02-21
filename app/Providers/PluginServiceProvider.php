<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Plugin\Cache\ArrayPluginCache;
use Xpressengine\Plugin\Cache\FilePluginCache;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginCollection;
use Xpressengine\Plugin\PluginEntity;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Plugin\PluginScanner;
use App\Skins\Plugin\PluginSettingsSkin;

class PluginServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPluginRegister();
        $this->registerPluginScanner();
        $this->registerPluginProvider();
        $this->registerComposerWriter();
        $this->registerPluginHandler();
    }

    protected function registerPluginRegister()
    {
        $this->app->singleton(
            'xe.pluginRegister',
            function ($app) {

                /** @var \Xpressengine\Interception\InterceptionHandler $interception */
                $interception = $app['xe.interception'];
                $pluginRegister = $interception->proxy(PluginRegister::class, 'PluginRegister');

                /** @var \Xpressengine\Register\Container $register */
                $register = $app['xe.register'];
                $pluginRegister = new $pluginRegister($register, 'plugins');

                return $pluginRegister;
            }
        );
    }

    protected function registerPluginScanner()
    {
        $this->app->singleton(
            PluginScanner::class,
            function ($app) {

                $pluginDir = base_path('plugins');

                $metaFileReader = new MetaFileReader('composer.json');
                $scanner = new PluginScanner($metaFileReader, $pluginDir);

                return $scanner;
            }
        );
    }


    protected function registerPluginHandler()
    {
        $this->app->singleton(
            ['xe.plugin' => PluginHandler::class],
            function ($app) {

                $pluginDir = base_path('plugins');

                $app['view']->addLocation($pluginDir);

                $pluginStatus = $app['xe.config']->getVal('plugin.list', []);

                $cachePath = $app['config']->get('cache.stores.plugins.path');
                if ($app['config']->get('app.debug') === true || !is_writable($cachePath)) {
                    $cache = new ArrayPluginCache();
                    $app->terminating(
                        function () {
                            app('cache')->driver('plugins')->forget('list');
                        }
                    );
                } else {
                    $cache = new FilePluginCache($app['cache']->driver('plugins'), 'list');
                }

                $pluginCollection = new PluginCollection($app[PluginScanner::class], $cache, PluginEntity::class, $pluginStatus);

                /** @var \Xpressengine\Interception\InterceptionHandler $interception */
                $interception = $app['xe.interception'];
                $pluginHandler = $interception->proxy(PluginHandler::class, 'XePlugin');
                $pluginHandler = new $pluginHandler(
                    $pluginDir, $pluginCollection, $app['xe.plugin.provider'], $app['view'], $app['xe.pluginRegister'], $app
                );

                $pluginHandler->setConfig($app['xe.config']);

                return $pluginHandler;
            }
        );
    }

    protected function registerPluginProvider()
    {
        $this->app->singleton(
            ['xe.plugin.provider' => PluginProvider::class],
            function ($app) {
                $url = $app['config']->get('xe.plugin.api.url');
                $auth = $app['config']->get('xe.plugin.api.auth');
                $provider = new PluginProvider($url, $auth);
                return $provider;
            }
        );
    }

    protected function registerComposerWriter()
    {
        $this->app->singleton(
            ['xe.plugin.writer' => ComposerFileWriter::class],
            function ($app) {
                $writer = new ComposerFileWriter(storage_path('app/composer.plugins.json'), $app[PluginScanner::class]);
                return $writer;
            }
        );
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        // boot plugins
        $this->app->booted(
            function () {
                /** @var PluginHandler $pluginHandler */
                $pluginHandler = $this->app['xe.plugin'];
                $pluginHandler->bootPlugins();
            }
        );

        // register skin for Plugin settings page
        $this->app->make('xe.pluginRegister')->add(PluginSettingsSkin::class);

        $this->registerSettingsPermissions();
    }

    private function registerSettingsPermissions()
    {
        $permissions = [
            'plugin' => [
                'title' => '플러그인 관리',
                'tab' => '플러그인'
            ]
        ];
        $register = $this->app->make('xe.register');
        foreach ($permissions as $id => $permission) {
            $register->push('settings/permission', $id, $permission);
        }
    }


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.plugin'];
    }
}

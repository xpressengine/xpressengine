<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Plugin\Cache\ArrayPluginCache;
use Xpressengine\Plugin\Cache\FilePluginCache;
use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginCollection;
use Xpressengine\Plugin\PluginEntity;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Plugin\PluginScanner;
use Xpressengine\Skins\Plugin\PluginSettingsSkin;

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
        $this->registerPluginRegistryManager();
        $this->registerPluginHandler();
    }

    protected function registerPluginRegistryManager()
    {
        $this->app->singleton(
            'xe.pluginRegister',
            function ($app) {

                /** @var \Xpressengine\Interception\InterceptionHandler $interception */
                $interception = $app['xe.interception'];
                $pluginRegister = $interception->proxy(PluginRegister::class, 'PluginRegister');

                /** @var \Xpressengine\Register\Container $register */
                $register = $app['xe.register'];
                $pluginRegister = new $pluginRegister($register);

                return $pluginRegister;
            }
        );
    }

    protected function registerPluginHandler()
    {
        $this->app->singleton(
            'xe.plugin',
            function ($app) {

                $pluginDir = base_path('plugins');

                $app['view']->addLocation($pluginDir);

                $pluginStatus = $app['xe.config']->getVal('plugin.list', []);

                if ($app['config']->get('app.debug') === true) {
                    $cache = new ArrayPluginCache();
                    $app->terminating(
                        function () {
                            app('cache')->driver('plugins')->forget('list');
                        }
                    );
                } else {
                    $cache = new FilePluginCache($app['cache']->driver('plugins'), 'list');
                }

                $metaFileReader = new MetaFileReader('composer.json');
                $scanner = new PluginScanner($metaFileReader, $pluginDir);

                $pluginCollection = new PluginCollection($scanner, $cache, PluginEntity::class, $pluginStatus);

                /** @var \Xpressengine\Interception\InterceptionHandler $interception */
                $interception = $app['xe.interception'];
                $pluginHandler = $interception->proxy(PluginHandler::class, 'Plugin');
                $pluginHandler = new $pluginHandler(
                    $pluginDir, $pluginCollection, $app['view'], $app['xe.pluginRegister'], $app
                );

                $pluginHandler->setConfig($app['xe.config']);

                return $pluginHandler;
            }
        );
        $this->app->bind(PluginHandler::class, 'xe.plugin');
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
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('xe.plugin');
    }
}

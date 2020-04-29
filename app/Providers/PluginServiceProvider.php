<?php
/**
 * PluginServiceProvider.php
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

use App\Skins\Plugin\PluginSettingsSkin;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginCollection;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\Plugin\PluginRepository;
use Xpressengine\Plugin\PluginScanner;

/**
 * Class PluginServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class PluginServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        PluginCollection::setConfig($this->app['xe.config']);

        // boot plugins
        $this->app->booted(function ($app) {
            $pluginHandler = $app['xe.plugin'];

            $app['events']->fire('booting.plugins', [$pluginHandler]);

            $pluginHandler->bootPlugins();

            $app['events']->fire('booted.plugins', [$pluginHandler]);
        });

        $this->registerSettingsPermissions();
    }

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

    /**
     * Register the plugin register.
     *
     * @return void
     */
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

                // register skin for Plugin settings page
                $pluginRegister->add(PluginSettingsSkin::class);

                return $pluginRegister;
            }
        );
    }

    /**
     * Register the plugin scanner.
     *
     * @return void
     */
    protected function registerPluginScanner()
    {
        $this->app->singleton(PluginScanner::class, function ($app) {
            $metaFileReader = new MetaFileReader('composer.json');
            $scanner = new PluginScanner($metaFileReader, $app['path.plugins'], $app['path.base']);

            return $scanner;
        });
    }

    /**
     * Register the plugin handler.
     *
     * @return void
     */
    protected function registerPluginHandler()
    {
        $this->app->singleton(PluginHandler::class, function ($app) {
            $app['view']->addLocation($app['path.plugins']);

            $repo = new PluginRepository(
                $app['files'],
                $app[PluginScanner::class],
                $app->getCachedPluginsPath()
            );

            /** @var \Xpressengine\Interception\InterceptionHandler $interception */
            $interception = $app['xe.interception'];
            $pluginHandler = $interception->proxy(PluginHandler::class, 'XePlugin');
            $pluginHandler = new $pluginHandler(
                $repo, $app['xe.plugin.provider'], $app['view'], $app['xe.pluginRegister'], $app
            );

            $pluginHandler->setConfig($app['xe.config']);

            return $pluginHandler;
        });
        $this->app->alias(PluginHandler::class, 'xe.plugin');
    }

    /**
     * Register the plugin provider.
     *
     * @return void
     */
    protected function registerPluginProvider()
    {
        $this->app->singleton(PluginProvider::class, function ($app) {
            $url = $app['config']->get('xe.plugin.api.url');
            $auth = $app['config']->get('xe.plugin.api.auth');
            $provider = new PluginProvider($url, $auth);
            return $provider;
        });
        $this->app->alias(PluginProvider::class, 'xe.plugin.provider');
    }

    /**
     * Register the composer writer.
     *
     * @return void
     */
    protected function registerComposerWriter()
    {
        $this->app->singleton(ComposerFileWriter::class, function ($app) {
            $writer = new ComposerFileWriter(storage_path('app/composer.plugins.json'), $app[PluginScanner::class]);
            return $writer;
        });
        $this->app->alias(ComposerFileWriter::class, 'xe.plugin.writer');
    }

    /**
     * Register the settings permission.
     *
     * @return void
     */
    private function registerSettingsPermissions()
    {
        $this->app['events']->listen(RouteMatched::class, function ($event) {
            $register = $this->app['xe.register'];
            $permissions = [
                'plugin' => [
                    'title' => xe_trans('xe::plugin').' '.xe_trans('xe::manage'),
                    'tab' => xe_trans('xe::plugin')
                ]
            ];
            foreach ($permissions as $id => $permission) {
                $register->push('settings/permission', $id, $permission);
            }
        });
    }
}

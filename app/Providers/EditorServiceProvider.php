<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Editor\EditorHandler;
use Xpressengine\Editor\Textarea;
use Xpressengine\Permission\Grant;
use Xpressengine\Skins\Editor\DefaultSkin;

class EditorServiceProvider extends ServiceProvider
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
        $this->app['xe.pluginRegister']->add(Textarea::class);
        $this->app['xe.pluginRegister']->add(DefaultSkin::class);
        $this->app['xe.skin']->setDefaultSkin('editor', 'editor/skin/xpressengine@default');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            [EditorHandler::class => 'xe.editor'],
            function ($app) {
                $editorHandler = $app['xe.interception']->proxy(EditorHandler::class, 'XeEditor');
                /**
                 * @var EditorHandler $editorHandler
                 */
                $editorHandler = new $editorHandler(
                    $app['xe.pluginRegister'],
                    $app['xe.config'],
                    $app,
                    $app['xe.storage'],
                    $app['xe.media'],
                    $app['xe.tag']
                );
                $editorHandler->setDefaultEditorId($app['config']->get('xe.editor.default'));
                return $editorHandler;
            }
        );

        intercept('XeEditor@render', 'editor.perm.default', function ($func, $instanceId, $args, $targetId) {
            $key = $this->app['xe.editor']->getPermKey($instanceId);
            if (!$this->app['xe.permission']->get($key)) {
                $this->app['xe.permission']->register($key, new Grant);
            }

            return $func($instanceId, $args, $targetId);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('xe.editor');
    }
}

<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Editor\ConfigHandler;
use Xpressengine\Editor\EditorHandler;
use Xpressengine\Editor\EditorInstanceStore;

class EditorServiceProvider extends ServiceProvider
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
        $this->app->singleton(
            'xe.editor',
            function ($app) {
                $editorHandler = $app['xe.interception']->proxy(EditorHandler::class, 'XeEditor');
                /**
                 * @var EditorHandler $editorHandler
                 */
                $editorHandler = new $editorHandler(
                    $app['xe.pluginRegister'],
                    app('xe.config')
                );
                $editorHandler->setDefaultEditorId($app['config']->get('xe.editor.default'));
                return $editorHandler;
            }
        );
        $this->app->bind(editorHandler::class, 'xe.editor');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}

<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Editor\AbstractEditor;
use Xpressengine\Editor\EditorHandler;
use Xpressengine\Editor\Textarea;
use Xpressengine\Media\Models\Media;
use Xpressengine\Permission\Grant;

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

        AbstractEditor::setImageResolver(function (array $ids) {
            $dimension = $this->app['request']->isMobile() ? 'M' : 'L';
            $fileClass = $this->app['xe.storage']->getModel();
            $files = $fileClass::whereIn('id', $ids)->get();

            $imgClass = $this->app['xe.media']->getHandler(Media::TYPE_IMAGE)->getModel();
            $images = [];
            foreach ($files as $file) {
                $images[] = $imgClass::getThumbnail(
                    $this->app['xe.media']->make($file),
                    EditorHandler::THUMBNAIL_TYPE,
                    $dimension
                );
            }

            return $images;
        });

        $this->app['events']->listen('xe.editor.option.building', function ($editor) {
            $key = $this->app['xe.editor']->getPermKey($editor->getInstanceId());
            if (!$this->app['xe.permission']->get($key)) {
                $this->app['xe.permission']->register($key, new Grant);
            }
        });

        $this->app['events']->listen('xe.editor.render', function ($editor) {
            $this->app['xe.frontend']->js('assets/core/common/js/xe.editor.core.js')->load();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            ['xe.editor' => EditorHandler::class],
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

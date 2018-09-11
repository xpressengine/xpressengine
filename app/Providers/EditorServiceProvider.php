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

            $handler = $this->app['xe.media']->getHandler(Media::TYPE_IMAGE);
            $images = [];
            foreach ($files as $file) {
                $images[] = $handler->getThumbnail(
                    $this->app['xe.media']->make($file),
                    EditorHandler::THUMBNAIL_TYPE,
                    $dimension
                );
            }

            return $images;
        });
        AbstractEditor::setPrivilegedDeterminer(function () {
            return $this->app['auth']->user()->isManager();
        });

        $this->app['events']->listen('xe.editor.option.building', function ($editor) {
            $key = $this->app['xe.editor']->getPermKey($editor->getInstanceId());
            if (!$this->app['xe.permission']->get($key)) {
                $this->app['xe.permission']->register($key, new Grant);
            }
        });

        $this->app['events']->listen('xe.editor.render', function ($editor) {
            $this->app['xe.frontend']->js('assets/core/editor/editor.bundle.js')->prependTo('head')->load();
        });

        $this->app['events']->listen('xe.editor.compile', function ($editor) {
            // 콘텐츠 폰트 설정 적용
            $config = $editor->getConfig();
            $fontSize = $config->get('fontSize');
            $fontFamily = $config->get('fontFamily');
            $instanceId = $editor->getInstanceId();

            $contentStyle = [];
            if ($fontSize) {
                $contentStyle[] = 'font-size: ' . $fontSize . ';';
            }
            if ($fontFamily) {
                $contentStyle[] = 'font-family: ' . $fontFamily . ';';
            }
            if ($contentStyle) {
                $this->app['xe.frontend']->html('xe.content.style.' . $instanceId)->content('
                    <style>
                        .xe-content-' . $instanceId . ' {' . implode($contentStyle) . '}
                    </style>
                ')->appendTo('head')->load();
            }
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(EditorHandler::class, function ($app) {
            $editorHandler = $app['xe.interception']->proxy(EditorHandler::class, 'XeEditor');
            /**
             * @var EditorHandler $editorHandler
             */
            $editorHandler = new $editorHandler(
                $app['xe.pluginRegister'],
                $app['xe.config'],
                $app,
                $app['xe.storage'],
                $app['xe.media']
            );
            $editorHandler->setDefaultEditorId($app['config']->get('xe.editor.default'));
            return $editorHandler;
        });
        $this->app->alias(EditorHandler::class, 'xe.editor');
    }
}

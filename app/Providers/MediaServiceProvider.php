<?php
/**
 * This file is Media service provider.
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use FFMpeg\FFMpeg;
use Illuminate\Support\ServiceProvider;
use Xpressengine\Media\CommandFactory;
use Xpressengine\Media\Extensions\DummyExtension;
use Xpressengine\Media\Extensions\FFMpegExtension;
use Xpressengine\Media\Handlers\AudioHandler;
use Xpressengine\Media\Handlers\ImageHandler;
use Xpressengine\Media\Handlers\VideoHandler;
use Xpressengine\Media\MediaManager;
use Intervention\Image\ImageManager;
use Xpressengine\Media\Models\Audio;
use Xpressengine\Media\Models\Image;
use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Models\Video;
use Xpressengine\Media\Repositories\AudioRepository;
use Xpressengine\Media\Repositories\ImageRepository;
use Xpressengine\Media\Repositories\VideoRepository;
use Xpressengine\Media\Thumbnailer;

/**
 * laravel 에서의 사용을 위한 service provider
 *
 * @category    Media
 * @package     Xpressengine\Media
 */
class MediaServiceProvider extends ServiceProvider
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
        Thumbnailer::setManager(new ImageManager());

        ImageRepository::setModel(Image::class);
        VideoRepository::setModel(Video::class);
        AudioRepository::setModel(Audio::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(['xe.media' => MediaManager::class], function ($app) {
            $config = $app['config']['xe.media'];
            $proxyClass = $app['xe.interception']->proxy(MediaManager::class, 'XeMedia');
            $mediaManager = new $proxyClass($app['xe.storage'], new CommandFactory(), $config['thumbnail']);

            $mediaManager->extend(Media::TYPE_IMAGE, new ImageHandler(new ImageRepository(), $app['xe.storage']));

            $extensionName = isset($config['videoExtensionDefault']) ? $config['videoExtensionDefault'] : 'dummy';
            $method = 'create' . ucfirst($extensionName) . 'Extension';
            if (method_exists($this, $method) !== true) {
                throw new \InvalidArgumentException(
                    sprintf('Unknown extension [%s]', $config['videoExtensionDefault'])
                );
            }
            $extension = $this->{$method}($config);
            $mediaManager->extend(Media::TYPE_VIDEO, new VideoHandler(
                new VideoRepository(),
                new \getID3(),
                $app['xe.storage.temp'],
                $extension,
                isset($config['videoSnapshotFromSec']) ?: null
            ));

            $mediaManager->extend(Media::TYPE_AUDIO, new AudioHandler(
                new AudioRepository(),
                new \getID3(),
                $app['xe.storage.temp']
            ));

            return $mediaManager;
        });


        $this->registerEvent();
    }

    /**
     * Returns DummyExtension
     *
     * @param array $config config data
     * @return DummyExtension
     */
    private function createDummyExtension($config)
    {
        return new DummyExtension();
    }

    /**
     * Returns FFMpegExtension
     *
     * @param array $config config data
     * @return FFMpegExtension
     */
    private function createFfmpegExtension($config)
    {
        return new FFMpegExtension(FFMpeg::create($config['videoExtensions']['ffmpeg']), $this->app['xe.storage.temp']);
    }

    private function registerEvent()
    {
        intercept('XeStorage@delete', 'media.delete', function ($target, $file) {

            /** @var MediaManager $manager */
            $manager = $this->app['xe.media'];
            if ($manager->is($file)) {
                if (!$file instanceof Media) {
                    $file = $manager->cast($file);
                }

                $manager->metaDelete($file);
            }

            return $target($file);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.media'];
    }
}

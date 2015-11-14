<?php
/**
 * This file is Media service provider.
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
use Xpressengine\Media\Repositories\AudioRepository;
use Xpressengine\Media\Repositories\ImageRepository;
use Intervention\Image\ImageManager;
use Xpressengine\Media\Repositories\VideoRepository;
use Xpressengine\Media\Spec\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Xpressengine\Media\TempStorage;
use Xpressengine\Media\Thumbnailer;

/**
 * laravel 에서의 사용을 위한 service provider
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
        Media::setUrlMaker($this->app['xe.storage.url']);
        Thumbnailer::setManager(new ImageManager());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.media', function ($app) {
            $config = $app['config']['xe.media'];
            $proxyClass = $app['xe.interception']->proxy(MediaManager::class, 'Media');
            $mediaManager = new $proxyClass(new CommandFactory(), $config['thumbnail']);

            $image = new ImageHandler(
                $app['xe.storage'],
                new ImageRepository($app['xe.db']->connection())
            );
            $mediaManager->extend(Media::TYPE_IMAGE, $image);

            $extensionName = isset($config['videoExtensionDefault']) ? $config['videoExtensionDefault'] : 'dummy';
            $method = 'create' . ucfirst($extensionName) . 'Extension';
            if (method_exists($this, $method) !== true) {
                throw new \InvalidArgumentException(
                    sprintf('Unknown extension [%s]', $config['videoExtensionDefault'])
                );
            }
            $extension = $this->{$method}($config);
            $video = new VideoHandler(
                $app['xe.storage'],
                new VideoRepository($app['xe.db']->connection()),
                new \getID3(),
                new TempStorage(),
                $extension
            );
            $mediaManager->extend(Media::TYPE_VIDEO, $video);

            $audio = new AudioHandler(
                $app['xe.storage'],
                new AudioRepository($app['xe.db']->connection()),
                new \getID3(),
                new TempStorage()
            );
            $mediaManager->extend(Media::TYPE_AUDIO, $audio);

            return $mediaManager;
        }, true);

        $app = $this->app;
        intercept('Storage@remove', 'media.remove', function ($target, $file) use ($app) {

            /** @var MediaManager $manager */
            $manager = $app['xe.media'];
            if ($manager->is($file)) {
                $media = $manager->make($file);
                if ($media->originId === null) {
                    $manager->getHandler(Media::TYPE_IMAGE)->removeThumbnails($media);
                }

                $manager->remove($media);
            }

            return $target($file);
        });
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
        return new FFMpegExtension(FFMpeg::create($config['videoExtensions']['ffmpeg']), new TempStorage());
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

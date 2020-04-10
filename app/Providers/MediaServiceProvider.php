<?php
/**
 * MediaServiceProvider.php
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
 * Class MediaServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MediaServiceProvider extends ServiceProvider
{
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

        $this->hooks();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MediaManager::class, function ($app) {
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
        $this->app->alias(MediaManager::class, 'xe.media');
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

    /**
     * Add event listener.
     *
     * @return void
     */
    private function hooks()
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
}

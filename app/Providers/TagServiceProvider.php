<?php
/**
 * TagServiceProvider.php
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

use Illuminate\Support\ServiceProvider;
use Xpressengine\Tag\SimpleDecomposer;
use Xpressengine\Tag\Tag;
use Xpressengine\Tag\TagHandler;
use Xpressengine\Tag\TagRepository;

/**
 * Class TagServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class TagServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        TagRepository::setModel(Tag::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TagHandler::class, function ($app) {
            $proxyClass = $app['xe.interception']->proxy(TagHandler::class, 'XeTag');

            return new $proxyClass(new TagRepository, new SimpleDecomposer);
        });
        $this->app->alias(TagHandler::class, 'xe.tag');
    }
}

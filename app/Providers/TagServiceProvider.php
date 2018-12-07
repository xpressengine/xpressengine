<?php
/**
 * TagServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

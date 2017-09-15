<?php
/**
 * This file is Draft package service provider.
 *
 * PHP version 5
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Draft\DraftHandler;
use Xpressengine\Draft\DraftRepository;

/**
 * laravel 에서의 사용을 위한 등록 처리
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 */
class DraftServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DraftHandler::class, function ($app) {
            $proxyClass = $app['xe.interception']->proxy(DraftHandler::class, 'XeDraft');
            return new $proxyClass(
                new DraftRepository($app['xe.db']->connection(), $app['xe.keygen']), $app['auth']
            );
        });
        $this->app->alias(DraftHandler::class, 'xe.draft');
    }
}

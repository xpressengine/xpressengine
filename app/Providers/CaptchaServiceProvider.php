<?php
/**
 * This file is register this package for laravel
 *
 * PHP version 5
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Captcha\CaptchaManager;
use App\UIObjects\Captcha\CaptchaUIObject;

/**
 * laravel 에서 사용하기위해 등록처리를 하는 class
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 */
class CaptchaServiceProvider extends ServiceProvider
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
        CaptchaUIObject::setManager($this->app['xe.captcha']);

        $this->app['xe.pluginRegister']->add(CaptchaUIObject::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(['xe.captcha' => CaptchaManager::class], function ($app) {
            $proxyClass = $app['xe.interception']->proxy(CaptchaManager::class, 'Captcha');
            $captchaManager = new $proxyClass($app);
            return $captchaManager;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.captcha'];
    }
}

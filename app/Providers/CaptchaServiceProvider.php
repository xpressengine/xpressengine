<?php
/**
 * CaptchaServiceProvider.php
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
use Xpressengine\Captcha\CaptchaManager;
use App\UIObjects\Captcha\CaptchaUIObject;

/**
 * Class CaptchaServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CaptchaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['xe.pluginRegister']->add(CaptchaUIObject::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CaptchaManager::class, function ($app) {
            $proxyClass = $app['xe.interception']->proxy(CaptchaManager::class, 'Captcha');
            $captchaManager = new $proxyClass($app);
            return $captchaManager;
        });
        $this->app->alias(CaptchaManager::class, 'xe.captcha');
    }
}

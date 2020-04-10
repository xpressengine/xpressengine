<?php
/**
 * LogServiceProvider.php
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
use Xpressengine\Log\Loggers\AuthLogger;
use Xpressengine\Log\LogHandler;
use Xpressengine\Log\Models\Log;
use Xpressengine\Log\Repositories\LogRepository;
use Xpressengine\Register\Container;

/**
 * Class LogServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // register for admin log
        $this->app->singleton('xe.logs', function ($app) {
            $repo = $app['xe.interception']->proxy(LogRepository::class);
            $repo = new $repo(Log::class);
            return $repo;
        });

        $this->app->singleton(LogHandler::class, function ($app) {
            $handler = $app['xe.interception']->proxy(LogHandler::class, 'XeLog');
            $handler = new $handler($app['xe.register'], $app['xe.logs']);
            return $handler;
        });
        $this->app->alias(LogHandler::class, 'xe.log');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLoggers();

        $this->setDetailResolverForLog();

        $this->app->booted(function () {
            $handler = $this->app['xe.log'];

            $handler->initLoggers($this->app);
        });
    }

    /**
     * AuthLogger register에 등록
     *
     * @return void
     */
    private function registerLoggers()
    {
        /** @var Container $register */
        $register = $this->app['xe.register'];
        $register->push(LogHandler::ADMIN_LOGGER_KEY, AuthLogger::ID, AuthLogger::class);
    }

    /**
     * Set resolver for log content.
     *
     * @return void
     */
    private function setDetailResolverForLog()
    {
        /** @var LogHandler $handler */
        $handler = $this->app['xe.log'];
        Log::setDetailResolver(
            function ($log) use ($handler) {
                $logger = $handler->getLogger($log->type);
                return $logger->renderDetail($log);
            }
        );
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Register\Container;
use Xpressengine\Settings\AdminLog\Loggers\AuthLogger;
use Xpressengine\Settings\AdminLog\LogHandler;
use Xpressengine\Settings\AdminLog\Models\Log;
use Xpressengine\Settings\AdminLog\Repositories\LogRepository;

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
        $this->app->singleton('xe.adminlogs', function ($app) {
            $repo = $app['xe.interception']->proxy(LogRepository::class);
            $repo = new $repo(Log::class);
            return $repo;
        });

        $this->app->singleton(LogHandler::class, function ($app) {
            $handler = $app['xe.interception']->proxy(LogHandler::class, 'XeAdminLog');
            $handler = new $handler($app['xe.register'], $app['xe.adminlogs']);
            return $handler;
        });
        $this->app->alias(LogHandler::class, 'xe.adminlog');
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

        $this->app->booted( function () {
            $handler = $this->app['xe.adminlog'];

            $handler->initLoggers($this->app);
        });
    }

    private function registerLoggers()
    {
        /** @var Container $register */
        $register = $this->app['xe.register'];
        $register->push(LogHandler::ADMIN_LOGGER_KEY, AuthLogger::ID, AuthLogger::class);
    }

    private function setDetailResolverForLog()
    {
        /** @var LogHandler $handler */
        $handler = $this->app['xe.adminlog'];
        Log::setDetailResolver(
            function ($log) use ($handler) {
                $logger = $handler->getLogger($log->type);
                return $logger->renderDetail($log);
            }
        );
    }
}

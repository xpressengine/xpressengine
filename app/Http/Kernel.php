<?php
/**
 * Kernel.php
 *
 * PHP version 7
 *
 * @category    Http
 * @package     App\Http
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace App\Http;

use App\ModeCheckTrait;
use App\ResetProvidersTrait;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

/**
 * Class Kernel
 *
 * @category    Http
 * @package     App\Http
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class Kernel extends HttpKernel
{
    use ResetProvidersTrait, ModeCheckTrait;

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \App\Bootstrappers\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
        \Illuminate\Foundation\Bootstrap\BootProviders::class,
    ];

    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \App\Http\Middleware\ShareLocalizeSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,

            \App\Http\Middleware\HttpProtocol::class,
            \App\Http\Middleware\RequiredDF::class,
            \App\Http\Middleware\ExceptAppendableVerifyCsrfToken::class,
            \App\Http\Middleware\LangPreprocessor::class,
            \App\Http\Middleware\Purifying::class,
            \App\Http\Middleware\FreezeSEO::class,
            \App\Http\Middleware\AsyncExpose::class,
        ],

        'api' => [
            'throttle:60,1',
            'bindings',
        ],

        'safe' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            // \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\ExceptAppendableVerifyCsrfToken::class,
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'bindings' => \Illuminate\Routing\Middleware\SubstituteBindings::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,

        'settings' => \Xpressengine\Settings\SettingsMiddleware::class,
        'access' => \Xpressengine\Routing\AccessMiddleware::class,
    ];

    /**
     * Bootstrap the application for artisan commands.
     *
     * @return void
     */
    public function bootstrap()
    {
        $this->checkSafeMode();

        if ($this->isInstalled() === false) {
            $this->resetForInstall();
        }

        if ($this->isMaintenanceMode() === true) {
            $this->resetForMaintenanceMode();
        }

        parent::bootstrap();
    }

    /**
     * Is installed
     *
     * @return bool
     */
    protected function isInstalled()
    {
        return file_exists(app()->getInstalledPath());
    }

    /**
     * Reset for install
     *
     * @return void
     */
    protected function resetForInstall()
    {
        $this->resetProviders([
            \App\Providers\InstallServiceProvider::class
        ]);
    }

    /**
     * is maintenance mode
     *
     * @return bool
     */
    protected function isMaintenanceMode()
    {
        return $this->app->isDownForMaintenance();
    }

    /**
     * Reset for maintenance mode
     *
     * @return void
     */
    protected function resetForMaintenanceMode()
    {
        $this->resetProviders();
    }
}

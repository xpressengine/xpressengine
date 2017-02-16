<?php

use Xpressengine\Http\Request;

/*
 * Define Xpressengine Version
 */
if (!defined('__XE_VERSION__')) {
    define('__XE_VERSION__', '3.0.0-beta.12');
}


/*
 * Set RequestFactory so that make all of generated request to Xpressengine's request
 * Request에 RequestFactory를 지정한다.
 * XE에서 새로운 request가 생성될 때에는 이 ReqeustFactory는 사용되어 항상 Xpressengine\Http\Request를 생성하도록 한다
 */
Request::setFactory(
    function (
        $query,
        $request,
        $attributes,
        $cookies,
        $files,
        $server,
        $content
    ) {
        return new Request($query, $request, $attributes, $cookies, $files, $server, $content);
    }
);

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| The first thing we will do is create a new Laravel application instance
| which serves as the "glue" for all the components of Laravel, and is
| the IoC container for the system binding all of the various parts.
|
*/

$app = new Illuminate\Foundation\Application(
    realpath(__DIR__.'/../')
);

/*
|--------------------------------------------------------------------------
| Bind Important Interfaces
|--------------------------------------------------------------------------
|
| Next, we need to bind some important interfaces into the container so
| we will be able to resolve them when needed. The kernels serve the
| incoming requests to this application from both the web and CLI.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| This script returns the application instance. The instance is given to
| the calling script so we can separate the building of the instances
| from the actual running of the application and sending responses.
|
*/

$app->bind(
    'path.public',
    function () {
        return base_path();
    }
);

return $app;

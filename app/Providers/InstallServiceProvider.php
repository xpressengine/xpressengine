<?php
/**
 * InstallServiceProvider.php
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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

/**
 * Class InstallServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class InstallServiceProvider extends ServiceProvider
{
    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot()
    {
        Route::get('/', function() {
            return redirect()->route('install.index');
        });

        Route::prefix('install')
            ->middleware('safe')
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/install.php'));

        app('config')->set('app.debug', true);

        // 실제 키 생성전 임시
        // .env 를 생성하지 않기 때문에 설치 전 encrypt key 값이 존재하지 않음
        app('config')->set('app.key', Str::random(32));
        \App\Http\Middleware\ExceptAppendableVerifyCsrfToken::setExcept('/install/post');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }
}

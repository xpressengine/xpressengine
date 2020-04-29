<?php
/**
 * SafeModeServiceProvider.php
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
use Illuminate\Support\Facades\Route;

/**
 * Class SafeModeServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SafeModeServiceProvider extends ServiceProvider
{
    /**
     * Service Provider Boot
     *
     * @return void
     */
    public function boot()
    {
        // 에러 페이지 출력할 때 문제
//        app('config')->set('app.debug', true);

        $safeModePrefix = app('config')->get('xe.routing.safeModePrefix');

        Route::prefix($safeModePrefix)
            ->middleware('safe')
            ->namespace('App\Http\Controllers')
            ->group(base_path('routes/safe.php'));
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

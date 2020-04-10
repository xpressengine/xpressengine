<?php
/**
 * AsyncExpose.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Middleware;

use Closure;
use Xpressengine\Http\Request;

/**
 * Class AsyncExpose
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AsyncExpose
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request request
     * @param Closure $next    to be called next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->wantsJson() && $request->hasHeader('X-XE-Async-Expose')) {
            $content = json_decode($response->getContent(), true);

            // assets
            $assetCss = \Xpressengine\Presenter\Html\Tags\CSSFile::getFileList();
            $assetJs = \Xpressengine\Presenter\Html\Tags\JSFile::getFileList();
            $routes = \Xpressengine\Presenter\Html\Tags\Route::getRoutes();
            $rules = \Xpressengine\Presenter\Html\Tags\Rule::getRuleList();
            $translations = \Xpressengine\Presenter\Html\Tags\Translation::getTransList();

            $assets = [];
            $_XE_ = [];
            if ($assetCss) {
                $assets['css'] = $assetCss;
            }
            if ($assetJs) {
                $assets['js'] = $assetJs;
            }

            if ($assets) {
                $_XE_['assets'] = $assets;
            }
            if ($routes) {
                $_XE_['routes'] = $routes;
            }
            if ($rules) {
                $_XE_['rules'] = $rules;
            }
            if ($translations) {
                $_XE_['translations'] = $translations;
            }

            $data = array_merge($content, compact('_XE_'));
            $response = response()->json($data);
        }

        return $response;
    }
}

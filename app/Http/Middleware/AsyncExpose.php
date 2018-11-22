<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Response;
use Xpressengine\Http\Request;

class AsyncExpose
{
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if($request->wantsJson() && $request->hasHeader('X-XE-Async-Expose')) {
            $content = json_decode($response->getContent(), true);

            // assets
            $assetCss = \Xpressengine\Presenter\Html\Tags\CSSFile::getFileList();
            $assetJs = \Xpressengine\Presenter\Html\Tags\JSFile::getFileList();
            $routes = \Xpressengine\Presenter\Html\Tags\Route::getRoutes();
            $rules = \Xpressengine\Presenter\Html\Tags\Rule::getRuleList();
            $translations = \Xpressengine\Presenter\Html\Tags\Translation::getTransList();

            $assets = [];
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

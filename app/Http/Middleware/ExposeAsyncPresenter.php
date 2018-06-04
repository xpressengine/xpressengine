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
use Illuminate\Support\Str;

class ExposeAsyncPresenter
{
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if($request->wantsJson() && $request->input('_xe_expose') === 'true') {
            $content = json_decode($response->getContent(), true);

            $assetCss = \Xpressengine\Presenter\Html\Tags\CSSFile::getFileList();
            $assetJs = \Xpressengine\Presenter\Html\Tags\JSFile::getFileList();

            $data = array_merge($content, [
                // @deprecated XE_ASSET_LOAD
                "XE_ASSET_LOAD" => [
                    "css" => $assetCss,
                    "js" => $assetJs
                ],
                "_XE_" => [
                    "assets" => [
                      "css" => $assetCss,
                      "js" => $assetJs
                    ],
                    "routes" => \Xpressengine\Presenter\Html\Tags\Route::getRoutes(),
                    "rules" => \Xpressengine\Presenter\Html\Tags\Rule::getRuleList(),
                    "translations" => \Xpressengine\Presenter\Html\Tags\Translation::getTransList(),
                ]
            ]);
            $response = response()->json($data);
        }

        return $response;
    }
}

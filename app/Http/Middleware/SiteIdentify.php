<?php
/**
 * SiteIdentify
 *
 * PHP version 5
 *
 * @category    App
 * @package     App\Http\Middleware
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Redirect;
use Xpressengine\Site\Exceptions\NotFoundSiteException;
use Xpressengine\Site\Site;
use Xpressengine\Site\SiteHandler;

/**
 * Class SiteIdentify
 *
 * @category    App
 * @package     App\Http\Middleware
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SiteIdentify
{
    protected static $redirectMap = [];
    /**
     * @var SiteHandler
     */
    protected $siteHandler;

    /**
     * SiteIdentify constructor.
     *
     * @param SiteHandler $siteHandler site handler
     */
    public function __construct(SiteHandler $siteHandler)
    {
        $this->siteHandler = $siteHandler;
    }


    /**
     * Handle an incoming request.
     *
     * @param  Request $request request
     * @param  Closure $next    next middleware closure
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*$host = $request->getHost();

        if (isset(static::$redirectMap[$host])) {
            return Redirect::away(static::$redirectMap[$host]);
        }

        $site = $this->siteHandler->get($host);
        $this->siteHandler->setCurrentSite($site);*/

        return $next($request);
    }
}

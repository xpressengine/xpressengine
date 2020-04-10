<?php
/**
 * AccessMiddleware class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Routing;

use Auth;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * Class AccessMiddleware
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AccessMiddleware
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var GateContract
     */
    protected $gate;

    /**
     * 생성자이며, Application 을 주입받는다.
     *
     * @param Application  $app  Application
     * @param GateContract $gate GateContract
     */
    public function __construct(Application $app, GateContract $gate)
    {
        $this->app = $app;
        $this->gate = $gate;
    }

    /**
     *
     * @param  \Illuminate\Http\Request $request 현재 처리중인 Request
     * @param  \Closure                 $next    next middleware
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->checkPermission();

        return $next($request);
    }


    /**
     * checkPermission
     *
     * @return void
     */
    protected function checkPermission()
    {
        $item = $this->getMenuItem();
        $user = Auth::user();
        $rating = $user->getRating();

        if (!$item->activated
            || ($rating !== 'super' && $this->gate->denies('access', $item))) {
            throw new AccessDeniedHttpException;
        }
    }

    /**
     * getMenuItem
     *
     * @return MenuItem
     */
    protected function getMenuItem()
    {
        $instanceConfig = InstanceConfig::instance();

        return $instanceConfig->getMenuItem();
    }
}

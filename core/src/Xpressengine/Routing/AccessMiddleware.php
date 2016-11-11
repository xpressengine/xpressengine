<?php
/**
 * AccessMiddleware class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * 이 클래스 Xpressengine 에서 route middle ware 로 동작한다.
 * Instance 로 연결된 Instance Route 에 접근하는 경우에 접근 권한이 있는지 확인한다.
 * AccessMiddleware 는 route::instance 로 등록된 경우를 위해서 middleware 역활을 수행한다
 * route::instance 로 등록된 경우에는 instance route - menu 로직을 수행하므로
 * 관련 instance route 와 menu 의 정보를 취합하여 Access 권한을 확인한다.
 *
 * @category    Routing
 * @package     Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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

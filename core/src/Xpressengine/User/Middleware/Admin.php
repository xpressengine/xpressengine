<?php
/**
 * This file is account interface
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
namespace Xpressengine\User\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;

/**
 * 관리자 2단계 인증 미들웨어
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Admin
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard $auth authmanager
     *
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  Request $request request
     * @param  Closure $next    next middleware caller
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->auth->check()) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('auth/login');
            }
        }

        if (!$this->auth->checkAdminAuth(true)) {
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                if ($request->isManageRequest() == true) {
                    return redirect()->route('settings.auth.admin', ['redirectUrl' => $request->fullUrl()]);
                } else {
                    return redirect()->route('auth.admin', ['redirectUrl' => $request->fullUrl()]);
                }
            }
        }

        return $next($request);
    }
}

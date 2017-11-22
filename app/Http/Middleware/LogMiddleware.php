<?php
/**
 * SettingsMiddleware class.
 *
 * PHP version 5
 *
 * @category    Settings
 * @package     Xpressengine\Settings
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Settings\AdminLog\LogHandler;
use Xpressengine\User\Models\Guest;

/**
 * 이 클래스는 Xpressengine에서 middleware로 작동한다.
 *
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class LogMiddleware
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var LogHandler
     */
    protected $handler;

    /**
     * 생성자이며, Application을 주입받는다.
     *
     * @param Application $app Application
     */
    public function __construct(Application $app, LogHandler $handler)
    {
        $this->app = $app;
        $this->handler = $handler;
    }

    /**
     * route middleware에서 호출되는 메소드이며, 현재 Request를 로깅한다.
     *
     * @param  \Illuminate\Http\Request $request current request
     * @param  \Closure                 $next    next middleware
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        $result = $next($request);

        $user = $request->user() instanceof Guest ? $user : $request->user();

        if (!$user->isManager()) {
            return $result;
        }

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $loggers = $this->handler->getLoggerIds();

        foreach ($loggers as $logger) {
            $logger = $this->handler->getLogger($logger);
            if ($logger->matches($request)) {
                $logger->run($request);
            }
        }

        return $result;
    }

}

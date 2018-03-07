<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Settings\AdminLog\Loggers;

use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Http\Request;
use Xpressengine\Settings\AdminLog\AbstractLogger;
use Xpressengine\Settings\AdminLog\Models\Log;

/**
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AuthLogger extends AbstractLogger
{
    const ID = 'auth';

    const TITLE = '로그인';

    const LOGIN = 0;
    const LOGOUT = 1;

    protected $app;

    public function initLogger(Application $app)
    {
        $this->app = $app;

        $app['events']->listen('Illuminate\Auth\Events\Login', function() {
            self::writeLog(request(), static::LOGIN);
        });

        $app['events']->listen('auth.logout', function () {
            self::writeLog(request(), static::LOGOUT);
        });
    }

    public function writeLog(Request $request, $type)
    {
        if (!$this->isAdmin($request)) {
            return;
        }

        self::storeLog($request, $type);
    }

    public function storeLog($request, $type)
    {
        $data = $this->loadRequest($request);
        array_set($data['data'], 'route', $request->route()->getName());

        if ($type == static::LOGIN) {
            $data['summary'] = '로그인';
            array_forget($data['parameters'], 'password');
        } else {
            $data['summary'] = '로그아웃';
        }

        $this->log($data);
    }

    /**
     * render log entity to html
     *
     * @param Log $log log entity
     *
     * @return string|null
     */
    public function renderDetail(Log $log)
    {
        return null;
    }
}
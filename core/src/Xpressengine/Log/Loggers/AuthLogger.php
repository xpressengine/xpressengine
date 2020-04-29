<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Log\Loggers;

use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Http\Request;
use Xpressengine\Log\AbstractLogger;
use Xpressengine\Log\Models\Log;

/**
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
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

    /**
     * Logger Init 세팅
     *
     * @param Application $app app
     *
     * @return void
     */
    public function initLogger(Application $app)
    {
        $this->app = $app;

        $app['events']->listen('Illuminate\Auth\Events\Login', function () {
            self::writeLog(request(), static::LOGIN);
        });

        $app['events']->listen('Illuminate\Auth\Events\Logout', function () {
            self::writeLog(request(), static::LOGOUT);
        });
    }

    /**
     * 로그 작성 전 관리자인지 확인
     *
     * @param Request $request request
     * @param integer $type    로그인/로그아웃 구분
     *
     * @return void
     */
    public function writeLog(Request $request, int $type)
    {
        if (!$this->isAdmin($request)) {
            return;
        }

        $this->storeLog($request, $type);
    }

    /**
     * 로그 작성
     *
     * @param Request $request request
     * @param integer $type    로그인/로그아웃 구분
     *
     * @return void
     */
    public function storeLog($request, int $type)
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

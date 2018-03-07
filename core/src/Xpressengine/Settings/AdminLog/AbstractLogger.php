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

namespace Xpressengine\Settings\AdminLog;

use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Http\Request;
use Xpressengine\Settings\AdminLog\Models\Log;

/**
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractLogger
{
    const ID = '';

    const TITLE = '';

    /**
     * @var LogHandler
     */
    protected $handler;

    /**
     * AbstractLogger constructor.
     *
     * @param LogHandler $handler loghandler
     */
    public function __construct(LogHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Application $app
     */
    abstract public function initLogger(Application $app);

    /**
     * render log entity to html
     *
     * @param Log $log log entity
     *
     * @return string|null
     */
    abstract public function renderDetail(Log $log);

    /**
     * @param Request $request
     * @return bool
     */
    protected function isAdmin(Request $request)
    {
        $user = $request->user();

        return $user->isManager();
    }

    /**
     * store log to database
     *
     * @param array $data log information
     *
     * @return void
     */
    protected function log($data)
    {
        $this->handler->log($data);
    }

    /**
     * make log data from request
     *
     * @param Request $request imcoming request
     *
     * @return array
     */
    protected function loadRequest(Request $request)
    {
        return [
            'type' => static::ID,
            'user_id' => $request->user()->getId(),
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'parameters' => $request->except('_method', '_token'),
            'summary' => '',
            'data' => [],
            'ipaddress' => $request->ip()
        ];
    }
}

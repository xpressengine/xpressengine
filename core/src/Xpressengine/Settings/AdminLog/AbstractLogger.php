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
    public static $id;

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
     * run logging request
     *
     * @param Request $request incoming request
     *
     * @return void
     */
    abstract public function run(Request $request);

    /**
     * matches
     *
     * @param Request $request incoming request
     *
     * @return boolean
     */
    abstract public function matches(Request $request);

    /**
     * render log entity to html
     *
     * @param Log $log log entity
     *
     * @return string|null
     */
    abstract public function renderDetail(Log $log);

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
            'type' => static::$id,
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

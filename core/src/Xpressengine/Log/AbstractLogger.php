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

namespace Xpressengine\Log;

use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Http\Request;
use Xpressengine\Log\Models\Log;

/**
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
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
     * logger가 등록될 때 해야될 작업 작성
     *
     * @param Application $app app
     *
     * @return void
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
     * 관리자 여부 확인
     *
     * @param Request $request request
     *
     * @return bool
     */
    protected function isAdmin(Request $request)
    {
        $user = $request->user();

        if ($user == null) {
            return false;
        }

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
            'target_id' => $this->getTargetId($request),
            'ipaddress' => $request->ip()
        ];
    }

    /**
     * Get targetId by log type
     *
     * @param Request $request request
     *
     * @return string
     */
    protected function getTargetId(Request $request)
    {
        return '';
    }
}

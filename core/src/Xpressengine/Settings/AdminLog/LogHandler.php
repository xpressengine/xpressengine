<?php
/**
 * SettingsHandler class.
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

namespace Xpressengine\Settings\AdminLog;

use Xpressengine\Register\Container;
use Xpressengine\Settings\AdminLog\Models\Log;
use Xpressengine\Settings\AdminLog\Repositories\LogRepository;

/**
 * LogHandler는 XpressEngine에서 관리자의 요청을 로깅합니다.
 *
 * @category    Log
 * @package     Xpressengine\Settings\Log
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class LogHandler
{
    /**
     * @var LogRepository
     */
    protected $repository;

    /**
     * @var Container
     */
    protected $register;

    /**
     * @var AbstractLogger[] list of logger instances
     */
    protected $loggers = [];

    /**
     * LogHandler constructor.
     *
     * @param Container     $register   xe register
     * @param LogRepository $repository log repository
     */
    public function __construct(Container $register, LogRepository $repository)
    {
        $this->repository = $repository;
        $this->register = $register;
    }

    /**
     * get Repository
     *
     * @return LogRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * get list of registered logger's id
     *
     * @return string[] logger id list
     */
    public function getLoggerIds()
    {
        $loggers = array_keys($this->register->get('admin/logger', []));
        return $loggers;
    }

    /**
     * get Loggers(id => class name)
     *
     * @return array
     */
    public function getLoggers()
    {
        return $this->register->get('admin/logger', []);
    }

    /**
     * get Logger instance
     *
     * @param string $id logger id
     *
     * @return AbstractLogger
     */
    public function getLogger($id)
    {
        if (array_has($this->loggers, $id)) {
            return $this->loggers[$id];
        }

        $class = array_get($this->register->get('admin/logger'), $id);

        if ($class) {
            $logger = $this->loggers[$id] = new $class($this);
            return $logger;
        }

        return null;
    }

    /**
     * log
     *
     * @param array $data log data
     *
     * @return Log
     */
    public function log($data)
    {
        return $this->repository->create($data);
    }

    /**
     * is triggered when invoking inaccessible methods in an object context.
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        $logs = $this->repository;
        return call_user_func_array([$logs, $name], $arguments);
    }
}

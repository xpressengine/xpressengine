<?php
/**
 * LogHandler class.
 *
 * PHP version 7
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Log;

use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Log\Models\Log;
use Xpressengine\Log\Repositories\LogRepository;
use Xpressengine\Register\Container;

/**
 * LogHandler는 XpressEngine에서 관리자의 요청을 로깅합니다.
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LogHandler
{
    /**
     * admin logger register key
     */
    const ADMIN_LOGGER_KEY = 'admin/logger';

    /**
     * plugin logger register key
     * plugin에 logger를 추가할 경우 사용
     */
    const PLUGIN_LOGGER_KEY = 'plugin/logger';

    protected $loggerKeys = [LogHandler::ADMIN_LOGGER_KEY, LogHandler::PLUGIN_LOGGER_KEY];

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
     * get LoggerKeys
     *
     * @return array
     */
    public function getLoggerKeys()
    {
        return $this->loggerKeys;
    }

    /**
     * 등록된 logger들의 initLogger 호출
     *
     * @param Application $app app
     *
     * @return void
     */
    public function initLoggers($app)
    {
        foreach (self::getLoggerKeys() as $loggerKey) {
            $loggers = $this->getLoggerIds($loggerKey);

            foreach ($loggers as $logger) {
                $logger = $this->getLogger($logger, $loggerKey);

                $logger->initLogger($app);
            }
        }
    }

    /**
     * get list of registered logger's id
     *
     * @param string $loggerKey logger key
     *
     * @return string[] logger id list
     */
    public function getLoggerIds($loggerKey = LogHandler::ADMIN_LOGGER_KEY)
    {
        $loggers = array_keys($this->register->get($loggerKey, []));
        return $loggers;
    }

    /**
     * get Loggers(id => class name)
     *
     * @return array
     */
    public function getLoggers()
    {
        $loggers = [];

        foreach (self::getLoggerKeys() as $loggerKey) {
            $loggers = array_merge($loggers, $this->register->get($loggerKey, []));
        }

        return $loggers;
    }

    /**
     * get Logger instance
     *
     * @param string $id        logger id
     * @param string $loggerKey logger key
     *
     * @return AbstractLogger
     */
    public function getLogger($id, $loggerKey = LogHandler::ADMIN_LOGGER_KEY)
    {
        if (array_has($this->loggers, $id)) {
            return $this->loggers[$id];
        }

        $class = array_get($this->register->get($loggerKey), $id);

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

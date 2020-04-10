<?php
/**
 * XpressengineException class.
 *
 * PHP version 7
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support\Exceptions;

use Exception;
use RuntimeException;

/**
 * 이 Exception 클래스는 Xpressengine에서 범용적으로 사용되는 Exception이다.
 * Xpressengine에서 사용되는 Exception은 모두 이 Exception을 상속받아 사용해야 한다.
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class XpressengineException extends RuntimeException
{
    /**
     * @var array
     */
    protected $args;

    /**
     * 생성자에서는 message 대신 message에서 사용되는 변수 목록을 입력받는다.
     * message는 이 클래스를 상속받는 클래스를 정의할 때 $message 필드에 지정해야 한다
     *
     * @param array     $args     message 변환시 사용될 변수 목록
     * @param int       $code     The Exception code.
     * @param Exception $previous The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct(array $args = [], $code = 0, Exception $previous = null)
    {
        $this->args = $args;

        $message = $this->makeMessage();

        parent::__construct($message, $code, $previous);
    }

    /**
     * 주어진 message를 Exception의 message로 지정한다.
     *
     * @param string $message 지정할 message
     *
     * @return void
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }

    /**
     * 주어진 argument를 기반으로 message를 완성하여 반환한다.
     *
     * @return string 완성된 message
     */
    protected function makeMessage()
    {
        // sort key, longer key is first.
        krsort($this->args);

        // prepend ":" to each key
        $keys = array_map(
            function ($key) {
                return ':'.$key;
            },
            array_keys($this->args)
        );

        $this->message = str_replace($keys, $this->args, $this->message);

        return $this->message;
    }
}

<?php
/**
 * XpressengineException class.
 *
 * PHP version 5
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Support\Exceptions;

use Exception;
use RuntimeException;

/**
 * 이 Exception 클래스는 Xpressengine 에서 범용적으로 사용되는 Exception 이다.
 * Xpressengine 에서 사용되는 Exception 은 모두 이 Exception 을 상속받아 사용해야 한다.
 *
 * @category    Exceptions
 * @package     Xpressengine\Support\Exceptions
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class XpressengineException extends RuntimeException
{
    /**
     * @var array
     */
    protected $args;

    /**
     * 생성자에서는 message 대신 message를 생성시 필요한 argument 목록을 입력받는다.
     * Message 는 \Xpressengine\Translation\Translator 로 변환되어 처리된다.
     *
     * Message 변환은 \App\Exceptions\Handler 에 서 처리된다.
     *
     * @param array     $args     message 변환 시 사용될 argument 목록
     * @param int       $code     The Exception code.
     * @param Exception $previous The previous exception used for the exception chaining. Since 5.3.0
     */
    public function __construct(array $args = [], $code = 0, Exception $previous = null)
    {
        $this->args = $args;
        parent::__construct($this->message, $code, $previous);
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
     * string 타입으로 캐스팅될 때, Exception 의 message 를 출력한다.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getMessage();
    }

    /**
     * @return array
     */
    public function getArgs()
    {
        return $this->args;
    }
}

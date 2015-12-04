<?php
/**
 * NotFoundWidgetException
 *
 * PHP version 5
 *
 * @category  Widget
 * @package   Xpressengine\Widget
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Widget\Exceptions;

use Exception;
use Xpressengine\Widget\WidgetException;

/**
 * NotFoundWidgetException
 *
 * PHP version 5
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class NotFoundWidgetException extends WidgetException
{
    //protected $message = '위젯을 찾을 수 없습니다.';
    /**
     * @var string
     */
    protected $message = 'xe::notFoundWidget';

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
        $this->message .= ' for '.$args['id'];
        parent::__construct($args, $code, $previous);
    }
}

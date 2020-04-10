<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Interception\Proxy;

use Xpressengine\Interception\AdvisorCollection;
use Xpressengine\Interception\AdvisorList;
use Xpressengine\Interception\ProxyInvocationHandler;

/**
 * 이 Trait은 동적으로 생성된 프록시 클래스 사용한다.
 * Interception(AOP)의 처리를 위한 로직을 포함하고 있다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait ProxyTrait
{

    /**
     * Advisor 저장소
     *
     * @var AdvisorCollection
     */
    private $advisorCollection;

    /**
     * AdvisorCollection을 반환한다.
     *
     * @return AdvisorCollection
     */
    private function _getAdvisorCollection()
    {
        if ($this->advisorCollection === null) {
            $this->advisorCollection = app('xe.interception')->getAdvisorCollection();
        }
        return $this->advisorCollection;
    }

    /**
     * 프록시 클래스의 Public 메소드가 호출되면 이 메소드를 호출한다.
     * 이 메소드가 호출되면 interception 처리가 시작된다.
     *
     * @param string $method            호출된 method명
     * @param array  $arguments         호출된 method의 파라메터
     * @param bool   $isCallMagicMethod 호출된 method가 __call() 메소드인지의 여부
     *
     * @return mixed
     */
    private function _proxyMethodCall($method, $arguments, $isCallMagicMethod = false)
    {
        // 생성자일 경우 바로 실행
        if ($method === '__construct') {
            call_user_func_array('parent::__construct', $arguments);
            return;
        }

        /** @var AdvisorList $advisorList */
        $advisorList = $this->_getAdvisorCollection()->getAdvisorList(parent::class.'@'.$method);

        $invocationHandler = new ProxyInvocationHandler($this, $method, $advisorList);

        // 등록된 advisor들을 호출한다. advisor들이 실행되고 마지막으로 called method를 실행한다.
        return $invocationHandler->callProxy(
            $arguments,
            // 등록된 advisor들이 모두 호출된 다음 마지막에 호출되어 target의 origin method를 실행하는 클로저
            function () use ($method, $isCallMagicMethod) {
                $args = func_get_args();

                if ($isCallMagicMethod) {
                    array_unshift($args, $method);
                    $method = '__call';
                }

                return call_user_func_array(
                    [$this, '_proxyTargetCall'],
                    [$method, $args]
                );
            }
        );
    }

    /**
     * 본래 실행하려고 했던 실제 타겟 오브젝트의 메소드를 실행한다.
     *
     * @param string $method    origin method
     * @param array  $arguments argument of method call
     *
     * @return mixed
     */
    private function _proxyTargetCall($method, $arguments)
    {
        return call_user_func_array("parent::$method", $arguments);
    }
}

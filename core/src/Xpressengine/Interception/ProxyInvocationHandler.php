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

namespace Xpressengine\Interception;

use Closure;

/**
 * 이 클래스는 Proxy class의 method가 호출되었을 때 작동한다.
 * target class의 origin method가 실행되기 전에 호출되어야 할 advisor를 호출하는 역할을 한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ProxyInvocationHandler
{

    /**
     * @var Object 이 Proxy에 지정된 대상 오브젝트
     */
    public $proxyObject = null;


    /**
     * @var string 호출된 method 명
     */
    protected $targetMethodName;

    /**
     * @var \Closure 호출된 method의 호출을 담당하는 Closure
     */
    protected $originMethodCall;

    /**
     * ProxyInvocationHandler constructor.
     *
     * @param Object      $proxyObject 호출된 proxy object
     * @param string      $methodName  호출된 method 명
     * @param AdvisorList $advisorList 호출된 proxy object에 지정된 advisor list
     */
    public function __construct($proxyObject, $methodName, AdvisorList $advisorList)
    {
        $this->proxyObject = $proxyObject;
        $this->targetMethodName = $methodName;
        $this->advisorList = $advisorList;
    }

    /**
     * target class의 origin method가 실행되기 전에 호출되어야 할 advisor를 호출한 다음, 마지막으로 origin method를 호출한다.
     *
     * @param array   $args 호출된 메소드가 받은 파라메터 리스트
     * @param Closure $then 호출된 메소드, advisor를 모두 호출한 후 이 Closure가 실행된다.
     *
     * @return mixed
     */
    public function callProxy(array $args, Closure $then)
    {
        $this->originMethodCall = $then;
        return call_user_func_array($this, $args);
    }

    /**
     * proxy object의 메소드가 실행될 경우, 메소드에 지정된 advisor를 모두 실행시킨다.
     * 이때 decorator 패턴으로 advisor들이 실행되는데,
     * 각 advisor들이 next call을 할 때 proxy는 자기 자신을 호출하도록 하여 결국 이 메소드가 실행된다.
     * 이 메소드가 호출되면 다음 advisor를 찾아서 실행시켜주고, 더이상 실행할 advisor가 없을 경우 원래 호출된 proxy object의 메소드를 실행한다.
     *
     * @return mixed
     */
    public function __invoke()
    {
        $args = func_get_args();
        $advisor = $this->advisorList->next();

        if ($advisor) {
            $advice = $advisor->getAdvice();
            $argsWithThis = array_merge([$this], $args);
            return call_user_func_array($advice, $argsWithThis);
        } else {
            $closure = $this->originMethodCall;
            return call_user_func_array($closure, $args);
        }
    }

    /**
     * target object(proxy object)를 반환한다.
     *
     * @return Object
     */
    public function getTargetObject()
    {
        return $this->proxyObject;
    }

    /**
     * 호출된 메소드명을 반환한다.
     *
     * @return string
     */
    public function getTargetMethodName()
    {
        return $this->targetMethodName;
    }
}

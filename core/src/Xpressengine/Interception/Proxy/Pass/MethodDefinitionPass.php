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

namespace Xpressengine\Interception\Proxy\Pass;

use Xpressengine\Interception\Proxy\ProxyConfig;

/**
 * 타겟 클래스의 프록시 클래스 생성을 위해 필요한 코드를 생성할 때, 프록시 클래스의 Method 선언부의 변환을 담당하는 클래스이다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MethodDefinitionPass implements Pass
{
    /**
     * 주어진 프록시 클래스 템플릿 코드의 메소드 선언부를 변환한다.
     *
     * @param string      $code   프록시 클래스 탬플릿 코드
     * @param ProxyConfig $config 동적으로 생성하려는 프록시 클래스 정보
     *
     * @return string
     */
    public function apply($code, ProxyConfig $config)
    {
        foreach ($config->getTargetMethods() as $method) {
            if ($method->isStatic()) {
                continue;
            }

            $name = $method->getName();

            $methodDef = '    public';
            $methodDef .= ' function ';
            $methodDef .= $method->returnsReference() ? ' & ' : '';
            $methodDef .= $name;
            $methodDef .= $this->renderParams($method);
            $methodDef .= $this->renderMethodBody($name === '__call');

            $code = $this->appendToClass($code, $methodDef);
        }

        return $code;
    }

    /**
     * 주어진 메소드의 파라메터 목록을 작성한다.
     *
     * @param \ReflectionMethod $method 메소드
     *
     * @return string
     */
    protected function renderParams(\ReflectionMethod $method)
    {

        $methodParams = array();
        /**
         * @var \ReflectionParameter[] $params
         */
        $params = $method->getParameters();
        foreach ($params as $param) {
            $paramDef = $this->getTypeHintAsString($param);
            $paramDef .= $param->isPassedByReference() ? ' &' : ' ';
            $paramDef .= '$'.$param->getName();

            if (false !== $param->isDefaultValueAvailable()) {
                $paramDef .= ' = '.var_export($param->getDefaultValue(), true);
            } elseif ($param->isOptional()) {
                $paramDef .= ' = null';
            }

            $methodParams[] = $paramDef;
        }
        return '('.implode(', ', $methodParams).')';
    }

    /**
     * 작성한 메소드 목록을 클래스 코드에 추가한다.
     *
     * @param string $class 클래스 코드
     * @param string $code  메소드 선언부 코드
     *
     * @return string
     */
    protected function appendToClass($class, $code)
    {
        $lastBrace = strrpos($class, "}");
        $class = substr($class, 0, $lastBrace).$code."\n}\n";
        return $class;
    }

    /**
     * 메소드 내부 코드를 생성한다. 메소드가 실행될 때, Interception(AOP) 로직을 호출한다.
     *
     * @param bool $isCallMagicMethod __call 메소드일 경우 별도 처리한다.
     *
     * @return string
     */
    private function renderMethodBody($isCallMagicMethod = false)
    {
        $invoke = '$this->_proxyMethodCall';

        if ($isCallMagicMethod) {
            $body = <<<BODY
    {
        \$argv = func_get_args();
        \$method = array_shift(\$argv);
        \$ret = {$invoke}(\$method, \$argv, true);
        return \$ret;
    }
BODY;
        } else {
            $body = <<<BODY
    {
        \$argv = func_get_args();
        \$ret = {$invoke}(__FUNCTION__, \$argv);
        return \$ret;
    }
BODY;
        }
        return $body;
    }

    /**
     * 파라메터의 TypeHint를 반환한다.
     *
     * @param \ReflectionParameter $rfp 파라메터 정보
     *
     * @return string
     */
    protected function getTypeHintAsString(\ReflectionParameter $rfp)
    {
        if (method_exists($rfp, 'getTypehintText')) {
            // Available in HHVM
            $typehint = $rfp->getTypehintText();

            // not exhaustive, but will do for now
            if (in_array($typehint, array('int', 'integer', 'float', 'string', 'bool', 'boolean'))) {
                return '';
            }

            return $typehint;
        }

        if ($rfp->isArray()) {
            return 'array';
        }

        /*
         * PHP < 5.4.1 has some strange behaviour with a typehint of self and
         * subclass signatures, so we risk the regexp instead
         */
        if ((version_compare(PHP_VERSION, '5.4.1') >= 0)) {
            try {
                if ($rfp->getClass()) {
                    return $rfp->getClass()->getName();
                }
            } catch (\ReflectionException $re) {
                // noop
            }
        }

        if (preg_match(
            '/^Parameter #[0-9]+ \[ \<(required|optional)\> (?<typehint>\S+ )?.*\$'.$rfp->getName().' .*\]$/',
            $rfp->__toString(),
            $typehintMatch
        )) {
            if (!empty($typehintMatch['typehint'])) {
                return $typehintMatch['typehint'];
            }
        }

        return '';
    }
}

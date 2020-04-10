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

use ReflectionClass;
use ReflectionMethod;

/**
 * 동적으로 생성할 프록시 클래스에 대한 정보를 저장하는 클래스
 * 프록시 클래스를 작성할 때 사용될 타겟 클래스에 대한 정보를 가지고 있다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ProxyConfig
{
    protected $class;

    /**
     * 타겟 클래스의 ReflectionClass
     *
     * @var \ReflectionClass
     */
    protected $rfc = null;

    /**
     * constructor.
     *
     * @param string $class 타겟 클래스 이름(full name)
     */
    public function __construct($class)
    {
        $this->class = trim($class, '\\');
    }

    /**
     * 타겟클래스의 ReflectionClass를 반환한다.
     *
     * @return ReflectionClass
     */
    public function getReflectionClass()
    {
        return $this->resolveRfc();
    }
    
    /**
     * 프록시 클래스에서 수정해야 할 메소드 목록을 반환한다.
     * Interception은 타겟 클래스의 public 메소드만 대상으로 한다.
     *
     * @return ReflectionMethod[] 수정할 메소드 목록
     */
    public function getTargetMethods()
    {
        $this->resolveRfc();
        $methods = $this->rfc->getMethods(ReflectionMethod::IS_PUBLIC);

        return $methods;
    }

    /**
     * 타겟 클래스 이름을 조회한다.
     *
     * @return string
     */
    public function getTargetName()
    {
        $this->resolveRfc();
        return $this->rfc->getName();
    }

    /**
     * 타겟 클래스의 파일 경로를 조회한다.
     *
     * @return string
     */
    public function getTargetPath()
    {
        $this->resolveRfc();
        return $this->rfc->getFileName();
    }

    /**
     * 동적으로 생성할 프록시 파일의 이름을 조회한다.
     *
     * @return string
     */
    public function getProxyName()
    {
        return 'Proxy_'.str_replace('\\', '_', $this->class);
    }

    /**
     * 타겟클래스의 ReflectionClass를 생성한다.
     *
     * @return ReflectionClass
     */
    private function resolveRfc()
    {
        if ($this->rfc === null) {
            $this->rfc = new \ReflectionClass($this->class);
        }

        return $this->rfc;
    }
}

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

/**
 * 동적으로 생성될 프록시 클래스에 대한 명세
 * 프록시 클래스의 이름과 코드를 저장한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Definition
{
    /**
     * @var ProxyConfig
     */
    protected $config;

    /**
     * @var string
     */
    protected $code;

    /**
     * Definition constructor.
     *
     * @param ProxyConfig $config 프록시 설정
     * @param string      $code   프록시 클래스 코드
     */
    public function __construct(ProxyConfig $config, $code)
    {
        $this->config = $config;
        $this->code = $code;
    }

    /**
     * 프록시 클래스의 이름을 조회한다.
     *
     * @return string
     */
    public function getClassName()
    {
        return $this->config->getProxyName();
    }

    /**
     * 프록시 클래스의 코드를 조회한다.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}

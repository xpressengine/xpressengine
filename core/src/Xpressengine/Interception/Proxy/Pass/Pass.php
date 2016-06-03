<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Interception\Proxy\Pass;

use Xpressengine\Interception\Proxy\ProxyConfig;

/**
 * 타겟 클래스의 프록시 클래스 생성을 위해 필요한 코드를 생성하는 메소드를 구현한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 */
interface Pass
{
    /**
     * 주어진 코드에 ProxyConfig의 정보를 적용한다.
     *
     * @param string      $code   적용할 코드
     * @param ProxyConfig $config Proxy 설정 정보
     *
     * @return mixed
     */
    public function apply($code, ProxyConfig $config);
}

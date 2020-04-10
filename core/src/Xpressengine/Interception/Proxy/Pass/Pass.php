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
 * 타겟 클래스의 프록시 클래스 생성을 위해 필요한 코드를 생성하는 메소드를 구현한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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

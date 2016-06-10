<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Interception\Proxy\Loader;

use Xpressengine\Interception\Proxy\Definition;

/**
 * 이 클래스는 동적으로 생성된 프록시 클래스를 eval()을 사용하여 로딩한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class EvalLoader implements Loader
{
    /**
     * 주어진 프록시 클래스 명세를 eval()을 사용하여 로드한다.
     *
     * @param Definition $definition 동적으로 생성할 프록시 클래스에 대한 명세
     *
     * @return void
     */
    public function load(Definition $definition)
    {
        if (class_exists($definition->getClassName(), false)) {
            return;
        }
        eval("?>".$definition->getCode());
    }
}

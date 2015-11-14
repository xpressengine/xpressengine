<?php
/**
 * Class Translation
 *
 * PHP version 5
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Translation\Loaders;

/**
 * 다국어 데이터를 load 할 수 있는 클래스
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface LoaderInterface
{
    /**
     * @param string $source 데이터 소스
     * @return LangData
     */
    public function load($source);
}

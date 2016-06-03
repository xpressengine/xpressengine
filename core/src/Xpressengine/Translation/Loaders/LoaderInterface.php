<?php
/**
 * Class Translation
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Translation\Loaders;

/**
 * 다국어 데이터를 load 할 수 있는 클래스
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 */
interface LoaderInterface
{
    /**
     * @param string $source 데이터 소스
     * @return LangData
     */
    public function load($source);
}

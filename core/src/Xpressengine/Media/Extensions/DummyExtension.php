<?php
/**
 * This file is dummy extension class
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Extensions;

/**
 * extension 을 사용하지 않을 경우 사용되는 클래스
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DummyExtension implements ExtensionInterface
{
    /**
     * 영상에서 snapshot 추출
     *
     * @param string $content    media content
     * @param int    $fromSecond 영상에서의 시간(초 단위)
     * @return null
     */
    public function getSnapshot($content, $fromSecond = 10)
    {
        return null;
    }
}

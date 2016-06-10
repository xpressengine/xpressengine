<?php
/**
 * This file is extension interface
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
 * extension 의 기능을 정의 함
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
interface ExtensionInterface
{
    /**
     * 영상에서 snapshot 추출
     *
     * @param string $content    media content
     * @param int    $fromSecond 영상에서의 시간(초 단위)
     * @return null|string
     */
    public function getSnapshot($content, $fromSecond = 10);
}

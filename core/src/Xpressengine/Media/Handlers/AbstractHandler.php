<?php
/**
 * This file is abstract media handler
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

namespace Xpressengine\Media\Handlers;

use Xpressengine\Media\Models\Media;
use Xpressengine\Storage\File;

/**
 * Abstract class AbstractHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractHandler
{
    /**
     * 각 미디어 타입에서 사용가능한 확장자 인지 판별
     *
     * @param string $mime mime type
     * @return bool
     */
    public function isAvailable($mime)
    {
        return in_array($mime, $this->getAvailableMimes());
    }

    /**
     * 각 미디어 타입에서 사용가능한 확장자 반환
     *
     * @return array
     */
    abstract public function getAvailableMimes();

    /**
     * media 객체로 반환
     *
     * @param File $file file instance
     * @return mixed
     */
    abstract public function make(File $file);

    /**
     * 미디어에서 사진 추출
     *
     * @param Media $media media instance
     * @return string 이미지 content
     */
    abstract public function getPicture(Media $media);

    /**
     * Create model
     *
     * @param File $file file instance
     * @return Media
     */
    abstract public function createModel(File $file);
}

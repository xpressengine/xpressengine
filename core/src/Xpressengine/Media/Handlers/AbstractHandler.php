<?php
/**
 * This file is abstract media handler
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Media\Handlers;

use Xpressengine\Media\Exceptions\NonExistingPropertyException;
use Xpressengine\Media\Spec\Media;
use Xpressengine\Media\Spec\Image;
use Xpressengine\Storage\File;

/**
 * media 핸들러
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractHandler
{
    /**
     * 각 미디어 타입에서 사용가능한 확장자 인지 판별
     *
     * @param string $mime mime type
     * @return bool
     * @throws NonExistingPropertyException
     */
    public function isAvailable($mime)
    {
        if (property_exists($this, 'mimes') !== true) {
            throw new NonExistingPropertyException(['name' => 'mimes']);
        }

        return in_array($mime, $this->{'mimes'});
    }

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
     * media 정보 삭제
     *
     * @param Media $media media instance
     * @return void
     */
    abstract public function remove(Media $media);
}

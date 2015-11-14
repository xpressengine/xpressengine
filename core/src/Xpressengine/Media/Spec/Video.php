<?php
/**
 * This file is Video model class
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
namespace Xpressengine\Media\Spec;

/**
 * video 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Video extends Media
{
    /**
     * Json type meta data name list
     *
     * @var array
     */
    protected static $jsonType = ['audio', 'video'];

    /**
     * Rendered media
     *
     * @param array $option rendering option
     * @return string
     */
    public function render(array $option = [])
    {
        return '<div class="embed-responsive embed-responsive-16by9">' .
        '<iframe class="embed-responsive-item" src="' . $this->url() . '"></iframe>' .
        '</div>';
    }

    /**
     * Returns media type
     *
     * @return string
     */
    public function getType()
    {
        return Media::TYPE_VIDEO;
    }
}

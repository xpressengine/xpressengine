<?php
/**
 * This file is Video model class
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

namespace Xpressengine\Media\Models;

use Xpressengine\Media\Models\Meta\VideoMeta;

/**
 * video 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 *
 * @property int $id
 * @property string $fileId
 * @property array $audio
 * @property array $video
 * @property int $playtime
 * @property int $bitrate
 */
class Video extends Media
{
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'audio' => 'array',
        'video' => 'array',
    ];

    /**
     * Available mime type
     *
     * @var array
     */
    protected static $mimes = [
        'video/x-flv', 'video/mp4', 'application/x-mpegURL', 'video/MP2T',
        'video/3gpp', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv',
        'video/ogg', 'video/webm'
    ];

    /**
     * Returns meta data model for current model
     *
     * @return string
     */
    public function getMetaModel()
    {
        return VideoMeta::class;
    }

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

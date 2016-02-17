<?php
/**
 * This file is Image model class
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
namespace Xpressengine\Media\Models;

use Xpressengine\Media\Models\Meta\ImageMeta;

/**
 * image 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 *
 * @property int $id
 * @property string $fileId
 * @property string $type
 * @property string $code
 * @property int $width
 * @property int $height
 */
class Image extends Media
{
    /**
     * Available mime type
     *
     * @var array
     */
    protected static $mimes = ['image/jpeg', 'image/png', 'image/gif', 'image/vnd.microsoft.icon', 'image/x-icon'];

    /**
     * Returns meta data model for current model
     *
     * @return string
     */
    public function getMetaModel()
    {
        return ImageMeta::class;
    }

    /**
     * Get a thumbnail image
     *
     * @param Media  $media       media instance
     * @param string $type        thumbnail make type
     * @param string $dimension   dimension code
     * @param bool   $defaultSelf if set true, returns self when thumbnail not exists
     * @return Image|null
     */
    public static function getThumbnail(Media $media, $type, $dimension, $defaultSelf = true)
    {
        $image = static::derives($media)->where('type', $type)->where('code', $dimension)->first();

        return (!$image && $defaultSelf) ? $media : $image;
    }

    /**
     * Get thumbnails
     *
     * @param Media       $media media instance
     * @param null|string $type  thumbnail make type
     * @return Image[]
     */
    public static function getThumbnails(Media $media, $type = null)
    {
        $query = static::derives($media)->with('meta');

        if ($type !== null) {
            $query->where('type', $type);
        }

        return $query->get();
    }

    /**
     * Rendered media
     *
     * @param array $option rendering option
     * @return string
     */
    public function render(array $option = [])
    {
        if (isset($option['responsive']) && $option['responsive'] === true) {
            return '<img src="' . $this->url() . '" style="max-width: 100%" />';
        }

        return '<img src="' . $this->url() . '" width="' . $this->width . '" height="' . $this->height . '" />';
    }

    /**
     * Returns media type
     *
     * @return string
     */
    public function getType()
    {
        return Media::TYPE_IMAGE;
    }
}

<?php
/**
 * This file is Image model class
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

use Illuminate\Support\Arr;
use Xpressengine\Media\Models\Meta\ImageMeta;

/**
 * image 객체
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
     *
     * @deprecated since beta.17. Use ImageRepository::getThumbnail instead.
     */
    public static function getThumbnail(Media $media, $type, $dimension, $defaultSelf = true)
    {
        $image = static::derives($media)
            ->whereHas('meta', function ($query) use ($type, $dimension) {
                $query->where('type', $type)->where('code', $dimension);
            })->with('meta')->first();

        return (!$image && $defaultSelf) ? $media : $image;
    }

    /**
     * Get thumbnails
     *
     * @param Media       $media media instance
     * @param null|string $type  thumbnail make type
     * @return Image[]
     *
     * @deprecated since beta.17. Use ImageRepository::getThumbnails instead.
     */
    public static function getThumbnails(Media $media, $type = null)
    {
        $query = static::derives($media)->with('meta');

        if ($type !== null) {
            $query->whereHas('meta', function ($query) use ($type) {
                $query->where('type', $type);
            });
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

        $width = Arr::get($option, 'width') ?: $this->width;
        $height = Arr::get($option, 'height') ?: $this->height;

        return '<img src="' . $this->url() . '" width="' . $width . '" height="' . $height . '" />';
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

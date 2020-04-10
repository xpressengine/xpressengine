<?php
/**
 * ImageRepository.php
 *
 * PHP version 7
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Repositories;

use Xpressengine\Media\Models\Image;
use Xpressengine\Media\Models\Media;

/**
 * Class ImageRepository
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ImageRepository extends MediaRepository
{
    /**
     * Get a thumbnail image
     *
     * @param Media  $media       media instance
     * @param string $type        thumbnail make type
     * @param string $dimension   dimension code
     * @param bool   $defaultSelf if set true, returns self when thumbnail not exists
     * @return Image|Media|null
     */
    public function getThumbnail(Media $media, $type, $dimension, $defaultSelf = true)
    {
        $image = $this->query()->derives($media)
            ->whereHas('meta', function ($query) use ($type, $dimension) {
                $query->where('type', $type)->where('code', $dimension);
            })->first();

        return (!$image && $defaultSelf) ? $media : $image;
    }

    /**
     * Get thumbnails
     *
     * @param Media       $media media instance
     * @param null|string $type  thumbnail make type
     * @return Image[]
     */
    public function getThumbnails(Media $media, $type = null)
    {
        $query = $this->query()->derives($media);

        if ($type !== null) {
            $query->whereHas('meta', function ($query) use ($type) {
                $query->where('type', $type);
            });
        }

        return $query->get();
    }
}

<?php
/**
 * This file is Image model class
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

namespace Xpressengine\Media\Models;

use Illuminate\Support\Arr;
use Xpressengine\Media\Models\Meta\ImageMeta;

/**
 * image 객체
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

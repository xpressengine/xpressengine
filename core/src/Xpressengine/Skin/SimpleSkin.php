<?php
/**
 * SimpleSkin.php
 *
 * PHP version 7
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Skin;

/**
 * Class SimpleSkin
 *
 * @category    Skin
 * @package     Xpressengine\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SimpleSkin extends GenericSkin
{
    /**
     * @var string 템플릿 파일 보관 디렉토리 경로
     */
    protected static $viewDir = null;

    /**
     * Set path for this skin.
     *
     * @param string $path path from plugin dir
     * @return $this
     */
    public function setPath($path)
    {
        static::$path = $path;

        return $this;
    }
}

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

    protected static $id;

    protected static $path;

    protected static $componentInfo;

    public function __construct($id, $path, $info, array $config = null)
    {
        static::$id = $id;
        static::$path = $path;
        static::$componentInfo = $info;

        parent::__construct($config);
    }
}

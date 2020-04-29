<?php
/**
 * MenuPrintSkin.php
 *
 * PHP version 7
 *
 * @category    Skins
 * @package     App\Skins\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Skins\Widget;

use Xpressengine\Skin\GenericSkin;

/**
 * Class MenuPrintSkin
 *
 * @category    Skins
 * @package     App\Skins\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuPrintSkin extends GenericSkin
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'widget/xpressengine@menuPrint/skin/xpressengine@default';

    /**
     * The information for component
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => 'Menu print default skin',
        'description' => ''
    ];

    /**
     * @var string
     */
    protected static $path = 'widget.widgets.menuPrint';

    /**
     * @var string
     */
    protected static $viewDir = '';

    /**
     * @var array
     */
    protected static $info = [
        'support' => [
            'mobile' => true,
            'desktop' => true
        ]
    ];

    /**
     * get path
     *
     * @return mixed
     */
    public static function getPath()
    {
        $path = property_exists(static::class, 'path') ? static::$path : '';

        return $path;
    }
}

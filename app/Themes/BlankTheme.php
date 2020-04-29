<?php
/**
 * BlankTheme.php
 *
 * PHP version 7
 *
 * @category    Themes
 * @package     App\Themes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Themes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Theme\AbstractTheme;

/**
 * Class BlankTheme
 *
 * @category    Themes
 * @package     App\Themes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class BlankTheme extends AbstractTheme
{
    /**
     * The component id
     *
     * @var string
     */
    public static $id = 'theme/xpressengine@blankTheme';

    /**
     * @var bool
     */
    protected static $supportDesktop = true;

    /**
     * @var bool
     */
    protected static $supportMobile = true;

    /**
     * Indicate if this component has the setting.
     *
     * @return bool
     */
    public static function hasSetting()
    {
        return false;
    }

    /**
     * Returns the title for the component.
     *
     * @return string
     */
    public static function getTitle()
    {
        return xe_trans('xe::theme') . ' ' . xe_trans('xe::disuse');
    }

    /**
     * Returns the description for the component.
     *
     * @return string
     */
    public static function getDescription()
    {
        return '테마를 출력하지 않습니다.';
    }

    /**
     * Returns the screenshot for the component.
     *
     * @return string
     */
    public static function getScreenshot()
    {
        return 'assets/core/common/img/default_image_196x140.jpg';
    }

    /**
     * Bootstrap the component.
     *
     * @return void
     */
    public static function boot()
    {
    }

    /**
     * Get Settings URI
     *
     * @return string
     */
    public static function getSettingsURI()
    {
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return view('themes.blank');
    }

    /**
     * Get the view for the component setting.
     *
     * @param ConfigEntity|null $config config
     * @return string
     */
    public function getSettingView(ConfigEntity $config = null)
    {
        return '';
    }
}

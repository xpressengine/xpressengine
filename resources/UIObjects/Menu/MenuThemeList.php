<?php
/**
 * MenuThemeList
 *
 * PHP version 5
 *
 * @category    UIObjects
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 *
 * @deprecated
 */

namespace Xpressengine\UIObjects\Menu;

use Xpressengine\Theme\ThemeHandler;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class MenuThemeList
 *
 * @category    UIObjects
 * @package     Xpressengine\UIObjects\Menu
 */
class MenuThemeList extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@menuThemeList';

    /**
     * UIObject가 출력될 때 호출되는 메소드이다.
     *
     * @return string
     */
    public function render()
    {
        $args = $this->arguments;
        $prefix = array_get($args, 'prefixName', 'theme_');
        /** @var ThemeHandler $themeHandler */
        $themeHandler = app('xe.theme');
        $themes = $themeHandler->getAllTheme();
        $siteThemes = $themeHandler->getSiteThemeId();

        $selectedThemeId = array_get($args, 'selectedTheme', $siteThemes);

        $this->template = view('uiobjects/theme/themeList', compact('themes', 'selectedThemeId', 'prefix'))->render();

        return parent::render();
    }

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * return settings manage uri
     *
     * @return null|string
     */
    public static function getSettingsURI()
    {
    }
}

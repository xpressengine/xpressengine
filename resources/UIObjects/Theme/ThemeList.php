<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\UIObjects\Theme;

use Xpressengine\Theme\ThemeHandler;
use Xpressengine\UIObject\AbstractUIObject;

class ThemeList extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@themeList';

    public function render()
    {
        $args = $this->arguments;
        $prefix = array_get($args, 'prefixName', 'theme_');
        /** @var ThemeHandler $themeHandler */
        $themeHandler = app('xe.theme');
        $themes = $themeHandler->getAllTheme();
        $siteThemes = $themeHandler->getSiteThemeId();

        $selectedThemeId = array_get($args, 'selectedTheme', $siteThemes);

        $this->template = view(
            'uiobjects.theme.themeList',
            compact('themes', 'selectedThemeId', 'prefix')
        )->render();

        return parent::render();
    }

    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    public static function getSettingsURI()
    {
    }
}

<?php
namespace Xpressengine\UIObjects\Theme;

use Xpressengine\Theme\ThemeHandler;
use Xpressengine\UIObject\AbstractUIObject;

class ThemeSelect extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@themeSelect';

    protected $view = 'uiobjects.theme.themeSelect';

    public function render()
    {
        $args = $this->arguments;
        $prefix = array_get($args, 'prefixName', 'theme_');
        /** @var ThemeHandler $themeHandler */
        $themeHandler = app('xe.theme');

        if (!isset($args['themes'])) {
            $themes = $themeHandler->getAllTheme();
        }

        if (!isset($args['selectedTheme'])) {
            $selectedThemeId = $themeHandler->getSiteThemeId();
        } else {
            $selectedThemeId = array_get($args, 'selectedTheme');
        }

        $previewLink = array_get($args, 'preview', '/');

        if (strpos($previewLink, '?') === false) {
            $previewLink .= '?';
        } else {
            $previewLink .= '&';
        }


        $this->loadFiles();

        $this->template = view($this->view, compact('themes', 'selectedThemeId', 'prefix', 'previewLink'))->render();

        return parent::render();
    }

    /**
     * loadFiles
     *
     * @return void
     */
    protected function loadFiles()
    {
        $frontend = app('xe.frontend');
        $frontend->css('assets/theme/theme-select.css')->load();
        $frontend->js('assets/common/js/form.js')->load();
    }
}

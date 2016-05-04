<?php
namespace App\Sections;

use View;
use Xpressengine\Editor\EditorHandler;

class EditorSection
{
    public function __construct()
    {
    }

    public function setting($instanceId)
    {
        /**
         * @var EditorHandler @handler
         */
        $handler = app('xe.editor');
        $component = $handler->get($instanceId);
        $settingView = $component->getSettingView();

        return View::make('editor.section', [
            'settingView' => $settingView,
        ]);
    }
}

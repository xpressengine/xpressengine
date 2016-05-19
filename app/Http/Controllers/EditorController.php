<?php
namespace App\Http\Controllers;

use Xpressengine\Editor\EditorHandler;
use Xpressengine\Http\Request;
use XeMenu;

class EditorController extends Controller
{
    public function setting(EditorHandler $handler, Request $request, $instanceId)
    {
        $editorId = $request->get('editorId');
        if (empty($editorId)) {
            $editorId = null;
        }

        $handler->setInstance($instanceId, $editorId);

        return redirect(XeMenu::getInstanceSettingURIByItemId($instanceId));
    }
}

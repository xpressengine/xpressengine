<?php

namespace App\Http\Controllers\MediaLibrary\Settings;

use App\Http\Controllers\Controller;
use Xpressengine\Http\Request;
use XeFrontend;

class MediaLibrarySettingsController extends Controller
{
    public function index(Request $request)
    {
        return \XePresenter::make('mediaLibrary.settings.index');
    }

    public function storeFileSetting(Request $request)
    {
        $fileConfig = $request->except('_token');

        app('xe.media_library.configHandler')->storeConfig(['file' => $fileConfig]);

        return redirect()->route('settings.mediaLibrary.index')->with('alert', ['type' => 'success', 'message' => '저장']);
    }

    public function storeContainerSetting(Request $request)
    {
        return redirect()->route('settings.mediaLibrary.index')->with('alert', ['type' => 'success', 'message' => '저장']);
    }

    public function contents()
    {
        XeFrontend::js([
            'assets/vendor/jQuery-File-Upload/js/vendor/jquery.ui.widget.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.iframe-transport.js',
            'assets/vendor/jQuery-File-Upload/js/jquery.fileupload.js',
        ])->before('assets/core/editor/editor.bundle.js')->load();

        return \XePresenter::make('mediaLibrary.contents');
    }
}

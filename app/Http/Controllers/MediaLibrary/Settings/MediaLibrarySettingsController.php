<?php

namespace App\Http\Controllers\MediaLibrary\Settings;

use App\Http\Controllers\Controller;
use Xpressengine\Http\Request;

class MediaLibrarySettingsController extends Controller
{
    public function index(Request $request)
    {
        return \XePresenter::make('mediaLibrary.settings.index');
    }

    public function contents()
    {
        return \XePresenter::make('mediaLibrary.contents');
    }
}

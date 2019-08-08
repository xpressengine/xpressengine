<?php

namespace App\Http\Controllers;

use Xpressengine\Http\Request;

class RegisterSettingsController extends Controller
{
    public function editSetting(Request $request)
    {
        $config = app('xe.config')->get('user.register');

        return \XePresenter::make('settings.register', compact('config'));
    }

    public function updateSetting(Request $request)
    {
        $inputs = $request->except('_token');
        app('xe.user_register')->updateConfig($inputs);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => xe_trans('xe::saved')]);
    }
}

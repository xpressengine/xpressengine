<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use XePresenter;
use Xpressengine\Http\Request;

class PluginSettingsController extends Controller
{

    /**
     * PluginController constructor.
     */
    public function __construct()
    {
        XePresenter::setSettingsSkinTargetId('plugins');
    }

    public function show(Request $request)
    {
        $config = app('xe.config')->get('plugin');
        return XePresenter::make('settings.show', compact('config'));
    }

    public function update(Request $request)
    {
        $config = app('xe.config')->get('plugin');

        $siteToken = $request->get('site_token');
        $config->set('site_token', $siteToken);

        if($composerHome = $request->get('composer_home')) {
            $config->set('composer_home', $composerHome);
        }
        app('xe.config')->modify($config);

        return redirect()->back()->with('alert', ['message'=>'저장되었습니다.', 'type'=>'success']);
    }
}


<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use XePresenter;
use XeStorage;
use XeMedia;
use XeFrontend;
use XeSEO;
use Xpressengine\Http\Request;

class SeoController extends Controller
{
    public function getSetting()
    {
        $ruleName = 'seoSetting';

        XeFrontend::rule($ruleName, $this->getRules());

        return XePresenter::make('seo.setting', [
            'setting' => XeSEO::getSetting(),
            'ruleName' => $ruleName
        ]);
    }

    public function postSetting(Request $request)
    {
        $this->validate($request, $this->getRules());

        $inputs = $request->only([
            'mainTitle',
            'subTitle',
            'keywords',
            'description',
            'twitterUsername',
        ]);
        $setting = XeSEO::getSetting();
        $setting->set($inputs);

        if ($request->file('siteImage') !== null) {
            $file = XeStorage::upload($request->file('siteImage'), 'public/seo');
            $image = XeMedia::make($file);
            $setting->setSiteImage($image);
        }

        return redirect()->route('manage.seo.edit');
    }

    private function getRules()
    {
        return [
            'mainTitle' => 'LangRequired',
            'keywords' => 'Required',
        ];
    }
}

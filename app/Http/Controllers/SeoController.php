<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use XePresenter;
use XeStorage;
use XeMedia;
use XeFrontend;
use Symfony\Component\HttpFoundation\Response;
use Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SeoController extends Controller
{
    public function getSetting()
    {
        $ruleName = 'seoSetting';

        XeFrontend::rule($ruleName, $this->getRules());

        return XePresenter::make('seo.setting', [
            'setting' => app('xe.seo')->getSetting(),
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
        $setting = app('xe.seo')->getSetting();
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

    /**
     * Validate the given request with the given rules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $rules
     * @param  array  $messages
     * @param  array  $customAttributes
     * @return void
     * @throws HttpException
     */
    public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
        /** @var \Illuminate\Validation\Validator $validator */
        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            $request->flash();
            throw new HttpException(Response::HTTP_NOT_ACCEPTABLE, $validator->errors()->first());
        }
    }
}

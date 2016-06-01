<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use XePresenter;
use XeSkin;
use Validator;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\Exceptions\InvalidArgumentException;

class SkinController extends Controller
{
    // 기본정보 보기
    public function postAssign(Request $request, SkinHandler $skinHandler)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'skinId' => 'required',
                'instanceId' => 'required'
            ]
        );
        if ($validation->fails()) {
            throw new InvalidArgumentException();
        }
        $skinInstanceId = $request->get('instanceId');
        $skinId = $request->get('skinId');
        $mode = $request->get('mode', 'desktop');

        $skin = $skinHandler->get($skinId);
        $skinHandler->assign($skinInstanceId, $skin, $mode);

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => '저장되었습니다.', 'skinId' => $skinId, 'skinTitle' => $skin->getTitle()]
        );
    }

    public function getSetting(Request $request, SkinHandler $skinHandler)
    {

        $validation = Validator::make(
            $request->all(),
            [
                'skinId' => 'required',
                'instanceId' => 'required'
            ]
        );

        if ($validation->fails()) {
            throw new InvalidArgumentException();
        }

        $skinInstanceId = $request->get('instanceId');
        $skinId = $request->get('skinId');

        $skinConfig = $skinHandler->getStore()->getConfigs($skinInstanceId, $skinId);

        $skin = $skinHandler->get($skinId, $skinConfig);

        $view = $skin->getSettingView($skinConfig);

        $section = view('skin.setting', compact('skinId', 'skinInstanceId', 'view'));

        return XePresenter::makeApi(['view' => (string) $section]);
    }

    public function postSetting(Request $request, SkinHandler $skinHandler)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'skinId' => 'required',
                'instanceId' => 'required'
            ]
        );
        if ($validation->fails()) {
            throw new InvalidArgumentException();
        }
        $skinInstanceId = $request->get('instanceId');
        $skinId = $request->get('skinId');
        $mode = $request->get('mode', 'desktop');

        $config = $request->except('instanceId', 'skinId', 'mode', '_token');

        $skin = $skinHandler->get($skinId, $config);
        $skinHandler->saveConfig($skinInstanceId, $skin, $mode);

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => '저장되었습니다.', 'skinId' => $skinId, 'skinTitle' => $skin->getTitle()]
        );
    }
}

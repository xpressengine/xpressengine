<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Presenter;
use Skin;
use Validator;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\Exceptions\InvalidArgumentException;

class SkinController extends Controller
{
    // 기본정보 보기
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

        $view = $skin->getSettingView();

        return Presenter::makeApi(['view' => (string) $view]);
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
        $skinHandler->assign($skinInstanceId, $skin, $mode);

        return Presenter::makeApi(
            ['type' => 'success', 'message' => '저장되었습니다.', 'skinId' => $skinId, 'skinTitle' => $skin->getTitle()]
        );
    }
}

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
use XeSkin;
use Validator;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\Exceptions\InvalidArgumentException;

class SkinController extends Controller
{
    // 기본정보 보기
    public function putAssign(Request $request, SkinHandler $skinHandler)
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

        $view = $skin->renderSetting($skinConfig);

        $section = view('skin.setting', compact('skinId', 'skinInstanceId', 'view'));

        //return XePresenter::makeApi(['view' => (string) $section]);
        return XePresenter::makeApi(
            [
                'result' => (string) $section,
                'XE_ASSET_LOAD' => [
                    'css' => \Xpressengine\Presenter\Html\Tags\CSSFile::getFileList(),
                    'js' => \Xpressengine\Presenter\Html\Tags\JSFile::getFileList(),
                ],
            ]
        );
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

        $config = $request->except('instanceId', 'skinId', '_token');

        $skin = $skinHandler->get($skinId);

        // 각 스킨에게 config값을 전처리 할 기회를 준다.
        $config = $skin->resolveSetting($config);

        $skin->setting($config);

        $skinHandler->saveConfig($skinInstanceId, $skin);

        return XePresenter::makeApi(
            ['type' => 'success', 'message' => '저장되었습니다.', 'skinId' => $skinId, 'skinTitle' => $skin->getTitle()]
        );
    }
}

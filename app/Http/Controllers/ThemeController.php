<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use File;
use Xpressengine\Http\Request;
use Xpressengine\Support\Exceptions\FileAccessDeniedHttpException;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;
use Xpressengine\Theme\Exceptions\NotSupportSettingException;
use Xpressengine\Theme\ThemeEntityInterface;
use Xpressengine\Theme\ThemeHandler;

class ThemeController extends Controller
{

    public function auth(Request $request, ThemeHandler $themeHandler)
    {
        $this->validate($request, [
            'password' => 'required'
        ]);

        $credentials = [];
        $credentials['id'] = auth()->id();
        $credentials['password'] = $request->get('password');
        $credentials['status'] = \XeUser::STATUS_ACTIVATED;

        if (auth()->attempt($credentials, false, false)) {
            session(['theme.editable' => true]);
        }

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '인증되었습니다.']);
    }

    public function edit(Request $request, ThemeHandler $themeHandler)
    {
        $editable = session('theme.editable');
        if(!$editable) {
            return \XePresenter::make(
                'theme.edit-auth'
            );
        }

        $themeId = $request->get('theme');
        $fileName = $request->get('file');

        // TODO: validate themeid, fileName
        if($themeId === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('잘못된 요청입니다.');
            throw $e;
        }

        $theme = \XeTheme::getTheme($themeId);

        /** @var ThemeEntityInterface $theme */
        $files = $theme->getEditFiles();

        if(empty($files)) {
            return \XePresenter::make(
                'theme.edit',
                [
                    'theme' => $theme,
                    'files' => $files,
                ]
            );
        }

        if ($fileName === null) {
            $fileName = key($files);
        }

        $filePath = realpath($files[$fileName]);

        $editFile = [
            'fileName' => $fileName,
            'path' => $filePath,
        ];

        if($themeHandler->hasCache($filePath)) {
            $editFile['hasCache'] = true;
            $fileContent = file_get_contents($themeHandler->getCachePath($filePath));
        } else {
            $editFile['hasCache'] = false;
            $fileContent = file_get_contents($filePath);
        }

        $editFile['content'] = $fileContent;

        return \XePresenter::make(
            'theme.edit',
            [
                'theme' => $theme,
                'files' => $files,
                'editFile' => $editFile
            ]
        );
    }

    public function update(Request $request, ThemeHandler $themeHandler)
    {

        $editable = session('theme.editable');
        if(!$editable) {
            return redirect()->back()->with('alert', ['type' => 'danger', 'message' => xe_trans('xe::needAuthForEditingTheme')])->withInput();
        }

        $themeId = $request->get('theme');
        $fileName = $request->get('file');
        $reset = $request->get('reset');

        $content = $request->get('content');

        $theme = $themeHandler->getTheme($themeId);
        $files = $theme->getEditFiles();

        $filePath = realpath($files[$fileName]);

        $cachePath = $themeHandler->getCachePath($filePath);

        $cacheDir = dirname($cachePath);
        File::makeDirectory($cacheDir, 0755, true, true);

        try {
            if($reset === 'Y') {
                File::delete($cachePath);
            } else {
                file_put_contents($cachePath, $content);
            }
        } catch (\Exception $e) {
            throw new FileAccessDeniedHttpException();
        }

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    public function createSetting(Request $request, ThemeHandler $themeHandler)
    {
        $instanceId = $request->get('theme');
        $title = $request->get('title');
        $theme = $themeHandler->getTheme($instanceId);

        if(!$theme->hasSetting()) {
            throw new NotSupportSettingException();
        }

        $configs = $themeHandler->getThemeConfigList($theme->getId());

        $last = array_pop($configs);
        $lastId = $last->name;

        $prefix = $themeHandler->getConfigId($theme->getId());
        $id = str_replace([$prefix, $themeHandler->configDelimiter], '', $lastId);
        $id = (int)$id + 1;
        $newId = $instanceId.$themeHandler->configDelimiter.$id;

        $themeHandler->setThemeConfig($newId, '_configTitle', $title);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '생성되었습니다.']);;
    }

    public function editSetting(Request $request, ThemeHandler $themeHandler)
    {
        $this->validate($request, [
            'theme' => 'required',
        ]);

        $themeId = $request->get('theme');
        $theme = $themeHandler->getTheme($themeId);

        if(!$theme->hasSetting()) {
            throw new NotSupportSettingException();
        }

        $configs = $themeHandler->getThemeConfigList($theme->getId());
        $config = $theme->setting();

        $configList = [];
        foreach ($configs as $id => $item) {
            $configList[$id] = $item->get('_configTitle', '기본');
        }

        return \XePresenter::make('theme.config', compact('theme', 'config', 'configList'));
    }

    public function updateSetting(Request $request, ThemeHandler $themeHandler)
    {
        $this->validate($request, [
            'theme' => 'required',
        ]);

        $themeId = $request->get('theme');
        $theme = $themeHandler->getTheme($themeId);

        if(!$theme->hasSetting()) {
            throw new NotSupportSettingException();
        }

        $configInfo = $request->only('_configTitle', '_configId');

        $inputs =  $request->except('_token');
        $inputs['_configId'] = $themeId;

        // 해당 테마에게 config를 가공할 수 있는 기회를 준다.
        $config = $theme->resolveSetting($inputs);

        $config = array_merge($configInfo, $config);

        $themeHandler->setThemeConfig($config['_configId'], $config);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }

    public function deleteSetting(Request $request, ThemeHandler $themeHandler) {
        $themeId = $request->get('theme');
        $theme = $themeHandler->getTheme($themeId);
        $config = $theme->setting();

        $theme->deleteSetting($config);

        $themeHandler->deleteThemeConfig($themeId);

        return redirect()->route('settings.setting.theme')->with('alert', ['type' => 'success', 'message' => '삭제되었습니다.']);

    }

}


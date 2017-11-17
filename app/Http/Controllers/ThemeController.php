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

    public function edit(Request $request, ThemeHandler $themeHandler)
    {
        $themeId = $request->get('theme');
        $fileName = $request->get('file');

        // TODO: validate themeid, fileName
        if ($themeId === null) {
            $e = new InvalidArgumentHttpException();
            $e->setMessage('잘못된 요청입니다.');
            throw $e;
        }

        $theme = \XeTheme::getTheme($themeId);

        /** @var ThemeEntityInterface $theme */
        $files = $theme->getEditFiles();

        if (empty($files)) {
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

        if ($themeHandler->hasCache($filePath)) {
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
            if ($reset === 'Y') {
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

        if (!$theme->hasSetting()) {
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

        if (!$theme->hasSetting()) {
            throw new NotSupportSettingException();
        }

        $config = $theme->setting();

        return \XePresenter::make('theme.config', compact('theme', 'config'));
    }

    public function updateSetting(Request $request, ThemeHandler $themeHandler)
    {
        $this->validate($request, [
            'theme' => 'required',
        ]);

        // beta.24 에서 laravel 5.5 가 적용된 이후
        // 공백('')값이 "ConvertEmptyStringsToNull" middleware 에 의해
        // null 로 변환됨. config 에 "set" 메서드를 통해 값을 갱신하는 경우
        // null 인 값은 변경사항에서 제외 시키므로 값이 공백상태로 넘겨져야 함.
        // 파일의 경우 $request->all() 호출시 내부적으로 다시 merge 하며
        // null 값이 유지됨.
        $request->merge(array_map(function ($v) {
            return is_null($v) ? '' : $v;
        }, $request->all()));

        $themeId = $request->get('theme');
        $theme = $themeHandler->getTheme($themeId);

        if(!$theme->hasSetting()) {
            throw new NotSupportSettingException();
        }

        $configInfo = $request->only('_configTitle', '_configId');

        $inputs =  $request->except('_token', '_method');
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


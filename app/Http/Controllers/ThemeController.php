<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Xpressengine\Http\Request;
use Xpressengine\Support\Exceptions\FileAccessDeniedHttpException;
use Xpressengine\Support\Exceptions\InvalidArgumentHttpException;
use Xpressengine\Theme\ThemeEntityInterface;
use Xpressengine\Theme\ThemeHandler;

class ThemeController extends Controller
{

    public function edit(Request $request)
    {
        $themeId = $request->get('theme');
        $fileName = $request->get('file');
        $type = $request->get('type', 'views');

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
            $fileName = key($files[$type]);
        }

        if (!is_writable($files[$type][$fileName])) {
            \View::share('_alert', [
                'type' => 'danger',
                'message' => '파일을 수정할 권한이 없습니다. 웹서버의 계정이 편집할 파일의 쓰기(w)권한을 가지고 있어야 합니다.'
            ]);
        }

        $fileContent = file_get_contents($files[$type][$fileName]);
        $editFile = [
            'fileName' => $fileName,
            'path' => $files[$type][$fileName],
            'content' => $fileContent
        ];

        return \XePresenter::make(
            'theme.edit',
            [
                'theme' => $theme,
                'files' => $files,
                'editFile' => $editFile,
                'type' => $type
            ]
        );
    }

    public function update(Request $request, ThemeHandler $themeHandler)
    {
        $themeId = $request->get('theme');
        $fileName = $request->get('file');
        $type = $request->get('type', 'template');

        $content = $request->get('content');

        $theme = $themeHandler->getTheme($themeId);
        $files = $theme->getEditFiles();

        $filePath = $files[$type][$fileName];

        try {
            file_put_contents($filePath, $content);
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
        $configs = $themeHandler->getThemeConfigList($theme->getId());

        $last = array_pop($configs);
        $lastId = $last->name;

        $prefix = $themeHandler->getConfigId($theme->getId());
        $id = str_replace([$prefix, $themeHandler->configDelimiter], '', $lastId);
        $id = (int)$id + 1;
        $newId = $instanceId.$themeHandler->configDelimiter.$id;

        $themeHandler->setThemeConfig($newId, '_configTitle', $title);

        return redirect()->route('settings.theme.config', ['theme'=>$newId])->with('alert', ['type' => 'success', 'message' => '생성되었습니다.']);;
    }

    public function editSetting(Request $request, ThemeHandler $themeHandler)
    {
        $this->validate($request, [
            'theme' => 'required',
        ]);

        $themeId = $request->get('theme');
        $theme = $themeHandler->getTheme($themeId);
        $config = $theme->setting();
        $configs = $themeHandler->getThemeConfigList($theme->getId());

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

        $configInfo = $request->only('_configTitle', '_configId');

        $inputs =  $request->except('_token');
        $inputs['_configId'] = $themeId;

        // 해당 테마에게 config를 가공할 수 있는 기회를 준다.
        $config = $theme->updateSetting($inputs);

        $config = array_merge($configInfo, $config);

        $themeHandler->setThemeConfig($config['_configId'], $config);

        return redirect()->back()->with('alert', ['type' => 'success', 'message' => '저장되었습니다.']);
    }
}


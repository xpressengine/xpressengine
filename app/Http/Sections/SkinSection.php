<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     LGPL-2.1 http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use View;
use Xpressengine\Skin\SkinHandler;

class SkinSection extends Section
{
    protected $target;
    protected $instanceId;

    /**
     * SkinSection constructor.
     *
     * @param string      $target
     * @param string|null $instanceId
     * @param string|null $mode
     */
    public function __construct($target, $instanceId = null)
    {
        $this->target = $target;
        $this->instanceId = $instanceId;
    }

    /**
     * makeView
     *
     * @param $target
     * @param $instanceId
     * @param $mode
     *
     * @return \Illuminate\Contracts\View\View
     */
    protected function makeView($target, $instanceId)
    {
        /** @var SkinHandler $skinHandler */
        $skinHandler = app('xe.skin');

        $skinInstanceId = $skinHandler->mergeKey($target, $instanceId);

        $selectedSkin = [];
        $selectedSkin['desktop'] = $skinHandler->getAssigned([$target, $instanceId], 'desktop');
        $selectedSkin['mobile'] = $skinHandler->getAssigned([$target, $instanceId], 'mobile');

        // get skin list
        $skinList = $skinHandler->getList($target);

        $skins = function ($skinList, $selectedSkin) {
            yield [
                'text' => '선택하세요',
                'selected' => false
            ];

            foreach ($skinList as $id => $skin) {
                $support = [];
                $support[] = $skin->supportDesktop() ? '데스크탑' : '';
                $support[] = $skin->supportMobile() ? '모바일' : '';
                $support = '['.implode('|', $support).']';

                yield [
                    'value' => $id,
                    'text' => $skin->getTitle().$support,
                    'selected' => $selectedSkin === null ? false : $id === $selectedSkin->getId(),
                ];
            }
        };

        $skins = $skins($skinList, $selectedSkin);

        $url = route('settings.skin.section.setting');
        \XeFrontend::html('skin.loadSkinSetting')->content(
            "<script>
                var skinSection = {
                    loadUrl: '$url',
                    'saveUrl': '$url'
                }
            </script>"
        )->load();
        \XeFrontend::js('assets/core/skin/section.js')->load();

        return View::make(
            'skin.section',
            compact('skinInstanceId', 'skinList', 'selectedSkin')
        );
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return $this->makeView($this->target, $this->instanceId)->render();
    }
}

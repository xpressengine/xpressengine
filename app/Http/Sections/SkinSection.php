<?php
/**
 * SkinSection.php
 *
 * PHP version 7
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Sections;

use View;
use Xpressengine\Skin\SkinHandler;

/**
 * Class SkinSection
 *
 * @category    Sections
 * @package     App\Http\Sections
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class SkinSection extends Section
{
    /**
     * The target
     *
     * @var string
     */
    protected $target;

    /**
     * The instance id
     *
     * @var null|string
     */
    protected $instanceId;

    /**
     * SkinSection constructor.
     *
     * @param string      $target     target
     * @param string|null $instanceId instance id
     */
    public function __construct($target, $instanceId = null)
    {
        $this->target = $target;
        $this->instanceId = $instanceId;
    }

    /**
     * Make a view.
     *
     * @param string $target     target
     * @param string $instanceId instance id
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
                'text' => xe_trans('xe::select'),
                'selected' => false
            ];

            foreach ($skinList as $id => $skin) {
                $support = [];
                $support[] = $skin->supportDesktop() ? xe_trans('xe::desktop') : '';
                $support[] = $skin->supportMobile() ? xe_trans('xe::mobile') : '';
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
        \XeFrontend::js([
            'assets/core/xe-ui-component/js/xe-page.js',
            'assets/core/skin/section.js'
        ])->load();

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

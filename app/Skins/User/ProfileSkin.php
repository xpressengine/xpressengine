<?php
/**
 * ProfileSkin.php
 *
 * PHP version 7
 *
 * @category    Skins
 * @package     App\Skins\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Skins\User;

use Xpressengine\Skin\GenericSkin;

/**
 * Class ProfileSkin
 *
 * @category    Skins
 * @package     App\Skins\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ProfileSkin extends GenericSkin
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'user/profile/skin/xpressengine@default';

    /**
     * The information for the component
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => '기본 프로필페이지 스킨',
        'description' => 'Xpressengine의 기본 프로필페이지 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'user.skins.default.profile';

    /**
     * @var array
     */
    protected static $info = [];

    /**
     * @var string
     */
    protected static $viewDir = '';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     * @throws \Exception
     */
    public function render()
    {
        $this->loadAssets();

        $user = $this->data['user'];

        if ($this->data['grant']['modify']) {
            $this->data['profileImageHtml'] = uio(
                'xpressengine@profileImage',
                [
                    'name' => 'profile_img_file',
                    'image' => $user->getProfileImage(),
                    'width' => 120,
                    'height' => 120
                ]
            );
            // todo: 사용하지 않는것으로 보임 확인 필요
            $this->data['bgImageHtml'] = uio(
                'xpressengine@profileBgImage',
                [
                    'name' => 'bgImgFile',
                    'image' => $user->getProfileImage(),
                    'width' => 2048,
                    'height' => 2048
                ]
            );
        }

        return parent::render();
    }

    /**
     * Load assets
     *
     * @return void
     */
    private function loadAssets()
    {
        $frontend = app('xe.frontend');

        if ($this->data['grant']['modify']) {
            $frontend->js('assets/core/user/profile.js')->load();
        }

        $frontend->css(
            [
                'assets/core/xe-ui-component/xe-ui-component.css',
                'assets/core/user/profile.css'
            ]
        )->load();
    }
}

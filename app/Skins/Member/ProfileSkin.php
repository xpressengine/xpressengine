<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Skins\Member;

use Xpressengine\Skin\BladeSkin;

/**
 * @category
 * @package     ${NAMESPACE}
 */
class ProfileSkin extends BladeSkin
{
    protected static $id = 'user/profile/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 프로필페이지 스킨',
        'description' => 'Xpressengine의 기본 프로필페이지 스킨입니다'
    ];

    protected $path = 'user.skins.default.profile';

    public function render()
    {
        $this->loadAssets();

        $user = $this->data['user'];

        if ($this->data['grant']['modify']) {
            $this->data['profileImageHtml'] = uio(
                'xpressengine@profileImage',
                [
                    'name' => 'profileImgFile',
                    'image' => $user->getProfileImage(),
                    'width' => 120,
                    'height' => 120
                ]
            );
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

    private function loadAssets()
    {
        $frontend = app('xe.frontend');

        if ($this->data['grant']['modify']) {
            $frontend->js('assets/core/member/profile.js')->load();
        }

        $frontend->css(
            [
                'assets/core/xe-ui-component/xe-ui-component.css',
                'assets/core/member/profile.css'
            ]
        )->load();
    }

}

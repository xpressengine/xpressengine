<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Skins\Member;

use Xpressengine\Skin\BladeSkin;

/**
 * @category
 * @package     ${NAMESPACE}
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ProfileSkin extends BladeSkin
{
    protected static $id = 'member/profile/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 프로필페이지 스킨',
        'description' => 'Xpressengine의 기본 프로필페이지 스킨입니다'
    ];

    protected $path = 'member.skins.default.profile';

    public function render()
    {
        $this->loadAssets();

        $member = $this->data['member'];

        if ($this->data['grant']['modify']) {
            $this->data['profileImageHtml'] = uio(
                'xpressengine@profileImage',
                [
                    'name' => 'profileImgFile',
                    'image' => $member->getProfileImage(),
                    'width' => 120,
                    'height' => 120
                ]
            );
            $this->data['bgImageHtml'] = uio(
                'xpressengine@profileBgImage',
                [
                    'name' => 'bgImgFile',
                    'image' => $member->getProfileImage(),
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

        if($this->data['grant']['modify']) {
            $frontend->js('assets/member/profile.js')->load();
        }

        $frontend->css([
            'assets/common/css/webfont.css',
            'assets/common/css/grid.css',
            'assets/member/profile.css'
        ])->load();
    }

}

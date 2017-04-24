<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\ToggleMenus\Member;

class ProfileItem extends UserToggleMenu
{
    protected static $id = 'user/toggleMenu/xpressengine@raw';

    protected static $componentInfo = [
        'name' => '프로필',
        'description' => '회원의 프로필 이미지를 출력하고 프로필 페이지로 이동합니다.'
    ];

    public function getText()
    {
        return '프로필 보기';
    }

    public function getType()
    {
        return static::MENUTYPE_RAW;
    }

    public function getAction()
    {
        $user = app('xe.users')->find($this->identifier);
        $link = route('user.profile', $user->getId());
        $profileImage = $user->getProfileImage();
        $content = sprintf('<a href="%s">프로필보기</a>', $link);
        return $content;
    }

    public function getScript()
    {
        return asset('assets/core/sample.js');
    }
}

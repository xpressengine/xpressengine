<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\ToggleMenus\User;

class ProfileItem extends UserToggleMenu
{
    protected static $id = 'user/toggleMenu/xpressengine@profile';

    protected static $componentInfo = [
        'name' => '프로필',
        'description' => '회원의 프로필 페이지로 이동합니다.'
    ];

    public function getText()
    {
        return '프로필보기';
    }



    public function getType()
    {
        return static::MENUTYPE_LINK;
    }

    public function getAction()
    {
        return route('user.profile', $this->identifier);
    }

    public function getScript()
    {
        return asset('assets/core/sample.js');
    }
}

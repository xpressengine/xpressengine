<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\ToggleMenus\User;

class ManageItem extends UserToggleMenu
{
    protected static $id = 'user/toggleMenu/xpressengine@manage';

    protected static $componentInfo = [
        'name' => '회원정보관리',
        'description' => '회원의 관리 페이지로 이동합니다.'
    ];

    public function getText()
    {
        return '회원정보 관리';
    }



    public function getType()
    {
        return static::MENUTYPE_LINK;
    }

    public function getAction()
    {
        return route('settings.user.edit', ['id' => $this->identifier]);
    }

    public function getScript()
    {
        return asset('assets/core/sample.js');
    }

    public function allows()
    {
        return auth()->user()->isAdmin();
    }
}

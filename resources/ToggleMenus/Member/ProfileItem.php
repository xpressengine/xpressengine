<?php
namespace Xpressengine\ToggleMenus\Member;

class ProfileItem extends UserToggleMenu
{
    protected static $id = 'user/toggleMenu/xpressengine@raw';

    protected static $componentInfo = [
        'name' => '프로필',
        'description' => '회원의 프로필 이미지를 출력하고 프로필 페이지로 이동합니다.'
    ];
    /**
     * @var
     */
    private $userId;

    public function __construct($instanceId, $userId)
    {
        $this->userId = $userId;
    }

    public function getText()
    {
        return '프로필 보기';
    }

    public function getType()
    {
        return 'raw';
    }

    public function getAction()
    {
        $user = app('xe.users')->find($this->userId);
        $link = route('member.profile', $user->getId());
        $profileImage = $user->getProfileImage();
        $content = sprintf('<a href="%s"><img src="%s" width="96" height="96"></a>', $link, $profileImage);
        return $content;
    }

    public function getScript()
    {
        return asset('assets/core/sample.js');
    }
    public function getIcon()
    {
        return null;
    }
}

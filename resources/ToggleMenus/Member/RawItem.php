<?php
namespace Xpressengine\ToggleMenus\Member;

class RawItem extends AbstractToggleMenuItem
{
    protected static $id = 'membermenu/xpressengine@raw';

    protected static $componentInfo = [
        'name' => '링크 회원메뉴',
        'description' => '링크 회원메뉴입니다.'
    ];
    /**
     * @var
     */
    private $mid;

    public function __construct($instanceId, $mid)
    {
        $this->mid = $mid;
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
        $member = app('xe.users')->find($this->mid);

        $checked = $member->status === 'activated' ? 'checked' : '';
        $image = "<img src=\"$member->profileImage()\" width=\"96\" height=\"96\"><br>";
        $checkbox = "<label><input type=\"checkbox\" $checked class=\"__xe_membermenu_activate_member\"> 승인</label>";
        return $image.$checkbox;
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

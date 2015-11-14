<?php
namespace Xpressengine\ToggleMenus\Member;

class LinkItem extends AbstractToggleMenuItem
{
    protected static $id = 'membermenu/xpressengine@link';

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
        return 'link';
    }

    public function getAction()
    {
        return '/@'.$this->mid;
    }

    public function getScript()
    {
        return null;
    }
    public function getIcon()
    {
        return null;
    }
}

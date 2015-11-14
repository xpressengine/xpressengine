<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Skins\Member;

use Presenter;
use Xpressengine\Skin\BladeSkin;

/**
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SettingsSkin extends BladeSkin
{

    protected static $id = 'member/settings/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 마이페이지 스킨',
        'description' => 'Xpressengine의 기본 마이페이지 스킨입니다'
    ];

    protected $path = 'member.skins.default.settings';

}

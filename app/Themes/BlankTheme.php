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

namespace App\Themes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Theme\AbstractTheme;

/**
 * @category
 * @package     App\Themes
 */
class BlankTheme extends AbstractTheme
{

    public static $id = 'theme/xpressengine@blankTheme';

    protected static $supportDesktop = true;
    protected static $supportMobile = true;

    public static function hasSetting(){
        return false;
    }

    public static function getTitle()
    {
        return '테마 사용 안함';
    }

    public static function getDescription()
    {
        return '테마를 출력하지 않습니다.';
    }

    public static function getScreenshot()
    {
        return 'assets/core/common/img/default_image_196x140.jpg';
    }

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
    }

    /**
     * Get Settings URI
     *
     * @return string
     */
    public static function getSettingsURI()
    {
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        return view('themes.blank');
    }

    /**
     * 테마 설정 페이지에 출력할 html 텍스트를 출력한다.
     * 설정폼은 자동으로 생성되며 설정폼 내부에 출력할 html만 반환하면 된다.
     *
     * @param ConfigEntity|null $config 기존에 설정된 설정값
     *
     * @return string
     */
    public function getSettingView(ConfigEntity $config = null)
    {
        return '';
    }
}

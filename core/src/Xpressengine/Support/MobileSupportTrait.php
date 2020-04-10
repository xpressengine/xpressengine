<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

/**
 * Theme나 skin과 같이 html을 출력하는 컴포넌트에서 사용할 수 있는 Trait으로서,
 * 컴포넌트가 mobile 버전, desktop 버전을 지원하는지에 대한 정보를 제공한다.
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait MobileSupportTrait
{

    /**
     * @var bool desktop 버전 지원 여부
     */
    protected static $supportDesktop = true;

    /**
     * @var bool mobile 버전 지원 여부
     */
    protected static $supportMobile = false;

    /**
     * desktop 버전 지원 여부를 조사한다.
     *
     * @return bool
     */
    public static function supportDesktop()
    {
        return static::$supportDesktop;
    }

    /**
     * mobile 버전 지원 여부를 조사한다.
     *
     * @return bool
     */
    public static function supportMobile()
    {
        return static::$supportMobile;
    }

    /**
     * 지정된 버전을 지원하는지 조사한다.
     *
     * @param string $version version
     *
     * @return bool
     */
    public static function support($version)
    {
        if ($version === 'desktop') {
            return static::supportDesktop();
        } elseif ($version === 'mobile') {
            return static::supportMobile();
        }
    }
}

<?php
/**
 *  Class AbstractTheme. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Theme;

/**
 * 이 클래스는 Xpressengine에서 테마를 구현할 때 필요한 추상클래스이다. 테마를 Xpressengine에 등록하려면
 * 이 추상 클래스를 상속(extends) 받는 클래스를 작성하여야 한다.
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class GenericTheme extends AbstractTheme
{
    use GenericThemeTrait;

    /**
     * @var string
     */
    protected static $path = null;

    /**
     * @var array
     */
    protected static $info = null;

    /**
     * @var ThemeHandler
     */
    protected static $handler  = null;

    /**
     * @var string
     */
    protected static $viewNamespace = '_theme';

    /**
     * 테마가 desktop 버전을 지원하는지 조사한다.
     *
     * @return bool desktop 버전을 지원할 경우 true
     */
    public static function supportDesktop()
    {
        return static::info('support.desktop');
    }

    /**
     * 테마가 mobile 버전을 지원하는지 조사한다.
     *
     * @return bool mobile 버전을 지원할 경우 true
     */
    public static function supportMobile()
    {
        return static::info('support.desktop');
    }

    public function getPath()
    {
        return static::$path;
    }

    /**
     * get theme info
     *
     * @param null $key
     *
     * @return array
     */
    protected function info($key = null)
    {
        if(static::$info === null) {
            static::$info = include(base_path($this->getPath().'/'.'info.php'));
        }

        if ($key !== null) {
            return array_get(static::$info, $key);
        }
        return static::$info;
    }
}

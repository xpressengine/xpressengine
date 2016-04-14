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

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Support\MobileSupportTrait;

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
abstract class AbstractTheme implements ComponentInterface, Renderable
{
    use ComponentTrait;
    use MobileSupportTrait;

    /**
     * @var ThemeHandler
     */
    protected static $handler  = null;

    protected static $configID = null;

    /**
     * 테마 핸들러를 지정한다.
     *
     * @param ThemeHandler $handler 테마 핸들러
     *
     * @return void
     */
    public static function setHandler(ThemeHandler $handler)
    {
        static::$handler = $handler;
    }

    /**
     * 테마의 이름을 반환한다.
     *
     * @return string
     */
    public static function getTitle()
    {
        return static::getComponentInfo('name');
    }

    /**
     * 테마의 설명을 반환한다.
     *
     * @return string
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

    /**
     * 테마의 스크린샷을 반환한다.
     *
     * @return mixed
     */
    public static function getScreenshot()
    {
        if (static::getComponentInfo('screenshot') === null) {
            return null;
        }
        return asset(static::getComponentInfo('screenshot'));
    }

    /**
     * 테마 편집 페이지에서 편집할 수 있는 파일의 목록을 반환한다.
     *
     * @return array
     */
    public static function getEditFiles()
    {
        return [];
    }

    /**
     * 테마의 설정 데이터를 반환한다.
     *
     * @return array
     */
    protected static function getConfig()
    {
        if(static::$configID === null) {
            $configId = static::getId();
        } else {
            $configId = static::$configID;
        }
        return static::$handler->getThemeConfig($configId);
    }
}

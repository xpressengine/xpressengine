<?php
/**
 * Abstarct ToggleMenu class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\ToggleMenu;

use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * Xpressengine plugin 의 toggle menu base class 정의
 *
 * @category    Support
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class AbstractToggleMenu implements ComponentInterface
{
    use ComponentTrait;

    /**
     * @var string
     */
    protected $componentType;

    /**
     * @var string
     */
    protected $instanceId;

    /**
     * @var string
     */
    protected $identifier;

    const MENUTYPE_EXEC = 'exec';

    const MENUTYPE_LINK = 'link';

    const MENUTYPE_RAW = 'raw';
    
    /**
     * getTitle
     *
     * @return mixed
     */
    public static function getTitle()
    {
        return static::getComponentInfo('name');
    }

    /**
     * getDescription
     *
     * @return mixed
     */
    public static function getDescription()
    {
        return static::getComponentInfo('description');
    }

    /**
     * getScreenshot
     *
     * @return mixed
     */
    public static function getScreenshot()
    {
        return static::getComponentInfo('screenshot');
    }

    /**
     * Set basic arguments
     *
     * @param string $componentType target type, component id
     * @param string $instanceId    instance id
     * @param string $identifier    target identifier
     * @return void
     */
    public function setArguments($componentType, $instanceId, $identifier)
    {
        $this->componentType = $componentType;
        $this->instanceId = $instanceId;
        $this->identifier = $identifier;
    }

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        return;
    }

    /**
     * 메뉴에서 보여질 문자열
     *
     * @return string
     */
    abstract public function getText();

    /**
     * 메뉴의 타입
     * 'exec' or 'link' or 'raw' 중에 하나
     *
     * @return string
     */
    abstract public function getType();

    /**
     * 실행되기 위한 js 문자열
     * 타입이 'raw' 인 경우에는 html
     *
     * @return string
     */
    abstract public function getAction();

    /**
     * 별도의 js 파일을 load 해야 하는 경우 해당 파일의 경로
     * 없는 경우 null 반환
     *
     * @return string|null
     */
    abstract public function getScript();

    /**
     * 아이콘을 표시하기 위한 문자
     * todo: class 명, 이미지 경로 등을 지원 할 예정
     *
     * @return string|null
     */
    public function getIcon()
    {
        return null;
    }

    /**
     * 메뉴에 표시여부 반환
     * 표실 할  경우 true 반환
     *
     * @return bool
     */
    public function allows()
    {
        return true;
    }
}

<?php
/**
 * Abstarct ToggleMenu class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractToggleMenu implements ComponentInterface
{
    use ComponentTrait;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $target;

    /**
     * create instance
     *
     * @param string $type   type
     * @param string $target target
     */
    public function __construct($type, $target)
    {
        $this->type = $type;
        $this->target = $target;
    }

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
     * 'func' or 'exec' or 'link' or 'raw' 중에 하나
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
     * @return string
     */
    abstract public function getIcon();

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

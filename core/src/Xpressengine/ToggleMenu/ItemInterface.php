<?php
/**
 * This file is toggle menu item interface
 *
 * PHP version 5
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\ToggleMenu;

/**
 * 각 메뉴 아이템들의 interface 를 정의 함.
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface ItemInterface
{
    /**
     * 설정 페이지에서 표현될 이름
     *
     * @return string
     */
    public static function getName();

    /**
     * 메뉴아이템에 대한 설명
     *
     * @return string
     */
    public static function getDescription();

    /**
     * 메뉴에서 보여질 문자열
     *
     * @return string
     */
    public function getText();

    /**
     * 메뉴의 타입
     * 'func' or 'exec' or 'link' or 'raw' 중에 하나
     *
     * @return string
     */
    public function getType();

    /**
     * 실행되기 위한 js 문자열
     * 타입이 'raw' 인 경우에는 html
     *
     * @return string
     */
    public function getAction();

    /**
     * 별도의 js 파일을 load 해야 하는 경우 해당 파일의 경로
     * 없는 경우 null 반환
     *
     * @return string|null
     */
    public function getScript();

    /**
     * 아이콘을 표시하기 위한 문자
     * todo: class 명, 이미지 경로 등을 지원 할 예정
     *
     * @return string
     */
    public function getIcon();
}

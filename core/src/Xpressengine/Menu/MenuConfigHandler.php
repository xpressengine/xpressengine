<?php

/**
 * Class MenuConfigHandler
 *
 * PHP version 5
 *
 * @category  Menu
 * @package   Xpressengine\Menu
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Menu;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Config\Exceptions\InvalidArgumentException;
use Xpressengine\Theme\ThemeHandler;

/**
 * MenuConfigHandler
 * Menu 및 MenuItem 과 관련된 Config 를 처리하는 역할을 수행함.
 * 주요 기능은 연관된 Theme 를 지정하고 변경하는 작업을 처리함.
 *
 * ## app binding
 * * xe.menu.config 으로 바인딩 되어 있음
 * * 별도의 Facade 는 제공하지 않음
 *
 * ## 생성자에서 필요한 항목들
 * * Application $app - Laravel Application IoC Container
 * * 내부적으로 xe.config 를 통해서 ConfigManager, xe.theme 를 통해서 ThemeHandler 를 내부 변수로 저장한다.
 *
 * ## 사용법
 *
 * ### MenuEntity 에 설정된
 * * 조회하고자 하는 MenuEntity 의 인스턴스를 인자로 전달한다.
 *
 * ```php
 * $menuConfigHandler->getMenuTheme(MenuEntity $menu);
 * ```
 *
 * ### Menu 의 테마 지정
 * * MenuEntity 와 지정할 DeskTopTheme, MobileTheme 값을 인자로 전달한다.
 *
 * ```php
 * MenuEntity $menu
 * $menuConfigHandler->setMenuTheme(MenuEntity $menu, $deskTopTheme, $mobileTheme)
 * ```
 *
 * ### Menu 의 테마 수정
 * * Menu 의 테마를 수정
 *
 * ```php
 * $menuConfigHandler->updateMenuTheme(MenuEntity $menu, $deskTopTheme, $mobileTheme)
 * ```
 *
 * ### Menu 의 테마 삭제
 * * Menu 의 테마 삭제
 *
 * ```php
 * $menuConfigHandler->deleteMenuTheme(MenuEntity $menu)
 * ```
 *
 * ### MenuItem 의 테마 조회(상속 지정)
 * * 상속이 지정 된 경우에는 자신의 값이 없을 경우에 상위에 값을 상속받은 값이 반환된다.
 * * 조회하고자 하는 MenuItem 의 인스턴스를 인자로 전달한다.
 *
 * ```php
 * $menuConfigHandler->getMenuItemTheme(MenuItem $item)
 * ```
 *
 * ### MenuItem 의 테마 조회(상속 미지정) - PURE
 * * 상속이 미지정 된 경우에는 상위에 값을 상속받은 값이 아니라 자기 자신의 pure 한 고유값을 반환한다.
 * * 조회하고자 하는 MenuItem 의 인스턴스를 인자로 전달한다.
 *
 * ```php
 * $menuConfigHandler->getPureMenuItemTheme(MenuItem $item)
 * ```
 *
 * ### MenuItem 의 테마 지정
 * * MenuItem 와 지정할 TDeskTopTheme, MobileTheme 값을 인자로 전달한다.
 *
 * ```php
 * MenuItem $menu
 * $menuConfigHandler->setMenuItemTheme(MenuItem $item, $deskTopTheme, $mobileTheme)
 * ```
 *
 * ### MenuItem 의 테마 수정
 * * MenuItem 의 테마를 수정
 *
 * ```php
 * $menuConfigHandler->updateMenuItemTheme(MenuItem $item, $deskTopTheme, $mobileTheme)
 * ```
 *
 * ### MenuItem 의 테마 삭제
 * * MenuItem 의 테마 삭제
 *
 * ```php
 * $menuConfigHandler->deleteMenuItemTheme(MenuItem $item)
 * ```
 *
 * ### MenuItem 의 설정 이동
 * * MenuItem 이 이동하면서 설정 또한 이동이 되어야 하기 때문에 이를 처리하는 역할을 담당하는 메소드
 *
 * ```php
 * $menuConfigHandler->moveItemConfig(MenuItem $item, MenuItem $movedItem)
 * ```
 *
 * @category Menu
 * @package  Xpressengine\Menu
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class MenuConfigHandler
{
    /**
     * @var string menuKeyword
     */
    protected $menuKeyword = 'menu';

    /**
     * @var string theme keyword
     */
    protected $themeKeyword = 'theme';

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var ThemeHandler
     */
    protected $themeHandler;

    /**
     * @param ConfigManager $configManager config manager
     * @param ThemeHandler  $themeHandler  theme handler
     *
     */
    public function __construct(ConfigManager $configManager, ThemeHandler $themeHandler)
    {
        $this->configManager = $configManager;
        $this->themeHandler = $themeHandler;
    }

    /**
     * getMenuTheme
     *
     * @param MenuEntity $menu to find theme menu entity instance
     *
     * @return ConfigEntity
     */
    public function getMenuTheme(MenuEntity $menu)
    {
        return $this->configManager->get($this->menuKeyString($menu->id));
    }

    /**
     * setMenuTheme
     *
     * @param MenuEntity $menu         to set theme menu entity instance
     * @param string     $desktopTheme desktop theme value
     * @param string     $mobileTheme  mobile theme value
     *
     * @return void
     */
    public function setMenuTheme(MenuEntity $menu, $desktopTheme, $mobileTheme)
    {
        $this->configManager->add(
            $this->menuKeyString($menu->id),
            [
                'desktopTheme' => $desktopTheme,
                'mobileTheme' => $mobileTheme
            ]
        );
    }

    /**
     * updateMenuTheme
     *
     * @param MenuEntity $menu         to update theme menu entity instance
     * @param string     $desktopTheme desktop theme value
     * @param string     $mobileTheme  mobile theme value
     *
     * @return void
     */
    public function updateMenuTheme(MenuEntity $menu, $desktopTheme, $mobileTheme)
    {
        $keyString = $this->menuKeyString($menu->id);
        $config = $this->configManager->get($keyString);

        $config->set('desktopTheme', $desktopTheme);
        $config->set('mobileTheme', $mobileTheme);

        $this->configManager->modify($config);
    }

    /**
     * deleteMenuTheme
     *
     * @param MenuEntity $menu to delete theme menu entity instance
     *
     * @return void
     */
    public function deleteMenuTheme(MenuEntity $menu)
    {
        $this->configManager->removeByName("{$this->menuKeyword}.{$menu->id}");
    }

    /**
     * getMenuItemTheme
     *
     * @param MenuItem $item to find theme menu item instance
     *
     * @return ConfigEntity
     */
    public function getMenuItemTheme(MenuItem $item)
    {
        $configKeyString = $this->menuKeyString($item->getBreadCrumbsKeyString());
        return $this->configManager->get($configKeyString);
    }

    /**
     * setMenuItemTheme
     *
     * @param MenuItem $item         menuItem
     * @param string   $desktopTheme desktop theme value
     * @param string   $mobileTheme  mobile theme value
     *
     * @throws InvalidArgumentException
     * @return void
     */
    public function setMenuItemTheme(MenuItem $item, $desktopTheme, $mobileTheme)
    {
        $this->configManager->add(
            $this->menuKeyString($item->getBreadCrumbsKeyString()),
            [
                'desktopTheme' => $desktopTheme,
                'mobileTheme' => $mobileTheme
            ]
        );
    }

    /**
     * updateMenuItemTheme
     *
     * @param MenuItem $item         to update theme menu item instance
     * @param string   $desktopTheme desktop theme id
     * @param string   $mobileTheme  mobile theme id
     *
     * @return void
     */
    public function updateMenuItemTheme(MenuItem $item, $desktopTheme, $mobileTheme)
    {
        $configKeyString = $this->menuKeyString($item->getBreadCrumbsKeyString());
        $config = $this->configManager->get($configKeyString);

        $config->set('desktopTheme', $desktopTheme);
        $config->set('mobileTheme', $mobileTheme);

        $this->configManager->modify($config);
    }

    /**
     * deleteMenuItemTheme
     *
     * @param MenuItem $item to delete theme menu item instance
     *
     * @return void
     */
    public function deleteMenuItemTheme(MenuItem $item)
    {
        $configKeyString = $item->getBreadCrumbsKeyString();
        $this->configManager->removeByName("{$this->menuKeyword}.{$configKeyString}");
    }

    /**
     * moveItemConfig
     *
     * @param MenuItem $beforeItem to change theme value for before item moving
     * @param MenuItem $movedItem  to change theme value for after item moving
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function moveItemConfig(MenuItem $beforeItem, MenuItem $movedItem)
    {
        $configEntity = $this->configManager->get($this->menuKeyString($beforeItem->getBreadCrumbsKeyString()));
        $this->configManager->move($configEntity, $this->menuKeyString($movedItem->getBreadCrumbsKeyString(true)));
    }

    /**
     * menuKeyString
     *
     * @param string $keyString to generate config key string
     *
     * @return string
     */
    protected function menuKeyString($keyString)
    {
        return $this->menuKeyword . '.' . $keyString;
    }
}

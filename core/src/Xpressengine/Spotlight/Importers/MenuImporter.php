<?php

namespace Xpressengine\Spotlight\Importers;

use Xpressengine\Menu\Models\Menu;
use Xpressengine\Spotlight\SpotlightItem;

class MenuImporter extends AbstractImporter
{
    public function convert($value)
    {
        if (! $this->checkTarget($value)) {
            throw new \InvalidArgumentException('This is not a Menu.');
        }

        return [
            $this->getEditItem($value),
            $this->getPermissionItem($value),
            $this->getAdditionItem($value),
        ];
    }

    public function checkTarget($value)
    {
        return $value instanceof Menu;
    }

    private function getEditItem(Menu $menu)
    {
        return new SpotlightItem(
            sprintf('site_menu.%s.edit', $menu->id),
            sprintf('%s 메뉴 편집', $menu->title),
            sprintf('%s 메뉴 편집하기', $menu->title),
            route('settings.menu.edit.menu', ['menuId' => $menu->id])
        );
    }

    private function getPermissionItem(Menu $menu)
    {
        return new SpotlightItem(
            sprintf('site_menu.%s.permission', $menu->id),
            sprintf('%s 메뉴 권한 수정', $menu->title),
            sprintf('%s 메뉴 권한 수정하기', $menu->title),
            route('settings.menu.edit.permission.menu', ['menuId' => $menu->id])
        );
    }

    private function getAdditionItem(Menu $menu)
    {
        return new SpotlightItem(
            sprintf('site_menu.%s.add_menu_item', $menu->id),
            sprintf('%s 메뉴 - 메뉴 아이템 추가', $menu->title),
            sprintf('%s 메뉴에 새로운 메뉴 아이템 추가', $menu->title),
            route('settings.menu.select.types', ['menuId' => $menu->id])
        );
    }
}
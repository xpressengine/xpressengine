<?php

namespace Xpressengine\Spotlight\Importers;

use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Spotlight\SpotlightItem;

class MenuItemImporter extends AbstractImporter
{
    public function convert($value)
    {
        if (! $this->checkTarget($value)) {
            throw new \InvalidArgumentException('This is not a Menu.');
        }

        return [
            $this->getEditItem($value),
            $this->getPermissionItem($value)
        ];
    }

    public function checkTarget($value)
    {
        return $value instanceof MenuItem;
    }

    private function getEditItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('site_menu_item.%s.edit', $item->id),
            sprintf('%s 메뉴 아이템 편집', $title),
            sprintf('%s 메뉴 아이템 편집하기', $title),
            route('settings.menu.edit.item', ['menuId' => $item->menu_id, 'itemId' => $item->id])
        );
    }

    private function getPermissionItem(MenuItem $item)
    {
        $title = xe_trans($item->title);

        return new SpotlightItem(
            sprintf('site_menu_item.%s.permission', $item->id),
            sprintf('%s 메뉴 아이템 권한 수정', $title),
            sprintf('%s 메뉴 아이템 권한 수정하기', $title),
            route('settings.menu.edit.permission.item', ['menuId' => $item->menu_id, 'itemId' => $item->id])
        );
    }
}
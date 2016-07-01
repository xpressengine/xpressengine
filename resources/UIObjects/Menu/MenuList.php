<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 *
 * @deprecated
 */

namespace Xpressengine\UIObjects\Menu;

use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuItem;
use Xpressengine\UIObject\AbstractUIObject;

class MenuList extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@menuList';
    protected $maxShowItemDepth;

    public function render()
    {
        /**
         * @var $menus array of \Xpressengine\Menu\Menu
         */

        $args = $this->arguments;

        $menus = $args['menus'];
        $htmlString = [];
        if (sizeof($menus) > 0) {
            /**
             * @var $menu MenuEntity
             */
            foreach ($menus as $menu) {
                $menuHeadString = $this->headHtml($menu);
                $treeString = $this->itemHtml($menu->id, $menu->getItems());

                $bottomString = $this->bottomHtml();
                $htmlString[] = $menuHeadString;
                $htmlString[] = $treeString;
                $htmlString[] = $bottomString;
            }
        }
//        else {
//            $htmlString[] = "<p>등록된 메뉴가 존재하지 않습니다.</p>";
//        }
        $htmlString[] = $this->newMenuHtml();



        $this->template = implode('', $htmlString);

        return parent::render();
    }

    public function headHtml(MenuEntity $menu)
    {
        $treeOption = $this->getTreeOption($menu);

        $headString = [];
        $headString[] = "<ul>";
        $headString[] = "<li data-jstree='{$treeOption}' id='{$menu->id}' node='{$menu->id}'>" . $menu->title;
        $headString[] = "<div class='action'>";

        $headString[] = sprintf('<a href="/manage/menu/selectItemType/%s" onclick="javascript:appendItem(\'%s\')"><i class="fa fa-plus"></i></a>',
            $menu->id, $menu->id);
        $headString[] = sprintf('<a href="/manage/menu/edit/%s" onclick="javascript:editMenu(\'%s\')"><i class="fa fa-pencil"></i></a>',
            $menu->id, $menu->id);
        $headString[] = sprintf('<a href="/manage/menu/editMenuPermission/%s" onclick="javascript:editMenuPermission(\'%s\')"><i class="fa fa-unlock-alt"></i></a>',
            $menu->id, $menu->id);


        $headString[] = "</div>";
        return implode("\n", $headString);
    }

    public function itemHtml($menuId, $menuItems)
    {

        $htmlString = [];
        /**
         * @var $item \Xpressengine\Menu\MenuItem
         */

        $htmlString[] = "<ul>";

        foreach ($menuItems as $item) {

            $treeOption = $this->getTreeOption($item);

            $typeString = explode('@', $item->type);
            $typeString = $typeString[sizeof($typeString) - 1];

            $htmlString[] = "<li data-jstree='{$treeOption}' id='{$item->id}' node='{$menuId}'>";
            $htmlString[] = $item->title;
            $htmlString[] = "<span class='menu_type'>({$typeString})</span>";

            $htmlString[] = "<div class='action'>";

            $htmlString[] = sprintf('<a href="/%s" onclick="javascript:linkTo(\'%s\')"><i class="fa fa-external-link"></i></a>',
                $item->url, $item->url);
            $htmlString[] = sprintf('<a href="/manage/menu/selectSubItemType/%s" onclick="javascript:appendSubItem(\'%s\')"><i class="fa fa-plus"></i></a>',
                $item->id, $item->id);
            $htmlString[] = sprintf('<a href="/manage/menu/editItem/%s" onclick="javascript:editItem(\'%s\')"><i class="fa fa-pencil"></i></a>',
                $item->id, $item->id);

            $htmlString[] = "</div>";

            if ($item->hasChild()) {
                $htmlString[] = $this->itemHtml($menuId, $item->getChildren());
            }

        }

        $htmlString[] = "</ul>";

        return implode("\n", $htmlString);
    }

    public function bottomHtml()
    {
        return "</li></ul>";
    }

    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    public static function getSettingsURI()
    {
    }

    protected function getTreeOption($object)
    {
        $openAll = false;
        if (isset($this->arguments['openAll'])) {
            $openAll = $this->arguments['openAll'];
        }

        $options = [];
        if ($object instanceof MenuEntity) {
            $options['type'] = 'menu';
        } else {
            if ($object instanceof MenuItem) {
                $options['type'] = 'item';
                $options['link'] = $object->url;
            }
        }
        if ($openAll) {
            $options['opened'] = true;
        }


        if ($object->isSelected()) {
            $options['selected'] = true;
        }

        return json_encode($options);
    }

    private function newMenuHtml()
    {

        $treeOption = ['href' => route('manage.menu.create.menu'), 'type' => 'new'];

        $treeOption = json_encode($treeOption);

        $htmlString = [];
        $htmlString[] = "<ul>";
        $htmlString[] = "<li data-jstree='{$treeOption}' id='newMenu' node='newMenu'>";
        $htmlString[] = "새로운 메뉴 추가하기";
        $htmlString[] = "</li>";
        $htmlString[] = "</ul>";

        return implode('', $htmlString);

    }
}

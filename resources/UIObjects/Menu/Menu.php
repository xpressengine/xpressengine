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

use PhpQuery\PhpQuery;
use Xpressengine\UIObject\AbstractUIObject;

class Menu extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@menu';
    protected $maxShowItemDepth;

    public function render()
    {
        /**
         * @var $menu     \Xpressengine\Menu\MenuEntity
         * @var $maxDepth int
         * @var $subRoot  string
         */

        $args = $this->arguments;

        $menu = $args['menu'];
        $maxDepth = isset($args['maxDepth']) ? $args['maxDepth'] : 2;
        $subRoot = isset($args['subRoot']) ? $args['subRoot'] : '';

        $this->maxShowItemDepth = $maxDepth;

        if (isset($args['subRoot'])) {
            $menuItems = $menu->getItem($subRoot)->getChildren();
        } else {
            $menuItems = $menu->getItems();
        }

        $htmlString = $this->generateTreeHtml($menuItems);

        $this->template = $htmlString;

        return parent::render();
    }

    public static function boot()
    {

    }

    public function generateTreeHtml(array $menuItems, $depth = 0)
    {

        if ($depth >= $this->maxShowItemDepth) {
            return '';
        }

        $coverTag = 'ul';
        $htmlString = [];

        /**
         * @var $item \Xpressengine\Menu\MenuItem
         */
        foreach ($menuItems as $item) {
            $htmlString[] = "<{$coverTag}>";

            if (empty($item->getUrl())) {
                $htmlString[] = sprintf("<li>%s</li>", $item->getTitle());
            } else {
                $htmlString[] = sprintf("<li><a id='%s' href='%s' target='%s'>%s</a></li>",
                    $item->id, $item->url, $item->target, $item->title
                );
            }

            if ($item->hasChild() and (($depth + 1) < $this->maxShowItemDepth)) {
                $htmlString[] = $this->generateTreeHtml($item->getChildren(), ($depth + 1));
            }
            $htmlString[] = "</{$coverTag}>";
        }

        return implode('', $htmlString);
    }

    public static function getSettingsURI()
    {
    }
}

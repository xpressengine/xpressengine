<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\UIObjects\Menu;

use XeSite;
use PhpQuery\PhpQuery;
use Xpressengine\Menu\Models\Menu as MenuModel;
use Xpressengine\UIObject\AbstractUIObject;

class MenuSelector extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@menuSelector';

    protected $template = '<div class="form-group">
            <label for="" class="hidden"></label>
            <select class="form-control" id="" name=""></select>
    </div>';

    public function render()
    {
        $args = $this->arguments;
        PhpQuery::newDocument();
        $this->markup = PhpQuery::pq($this->template);

        $label = $this->markup['label'];
        $select = $this->markup['select'];

        // label
        if (isset($args['label'])) {
            $label->removeClass('hidden')->html($args['label']);
        }

        // id
        if (isset($args['id'])) {
            $label->attr('for', $args['id']);
            $select->attr('id', $args['id']);
        }
        // name
        if (isset($args['name'])) {
            $select->attr('name', $args['name']);
        }

        $menus = MenuModel::where('siteKey', XeSite::getCurrentSiteKey())->get();
        foreach ($menus as $menu) {
            $option = PhpQuery::pq('<option></option>');
            $option->appendTo($select)->attr('value', $menu->id)->html($menu->title);
            if(isset($args['selected']) && $menu->id == $args['selected']) {
                $option->attr('selected', 'selected');
            } elseif(isset($args['value']) && $menu->id == $args['value']) {
                $option->attr('selected', 'selected');
            }
        }

        return parent::render();
    }


    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    public static function getSettingsURI()
    {
    }
}

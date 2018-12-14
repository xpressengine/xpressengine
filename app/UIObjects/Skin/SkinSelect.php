<?php
/**
 * SkinSelect.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Skin;

use App\UIObjects\Form\FormSelect;
use XeSkin;

/**
 * Class SkinSelect
 *
 * @category    UIObjects
 * @package     App\UIObjects\Skin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class SkinSelect extends FormSelect
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@skinSelect';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $target = array_get($this->arguments, 'target');

        $skins = XeSkin::getList($target);
        $options = [];
        foreach ($skins as $skin) {
            $options[$skin->getId()] = $skin->getTitle();
        }
        $this->arguments['options'] = $options;

        return parent::render();
    }
}

<?php
/**
 * DefaultSkin.php
 *
 * PHP version 7
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Boolean
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Boolean;

use Xpressengine\DynamicField\AbstractSkin;

/**
 * Class DefaultSkin
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Boolean
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DefaultSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Boolean/fieldSkin/xpressengine@BooleanDefault';

    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Boolean default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/boolean/default';
    }

    /**
     * 다이나믹필스 생성할 때 스킨 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }
}

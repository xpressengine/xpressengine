<?php
/**
 * UrlSkin.php
 *
 * PHP version 7
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Text
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Text;

use Xpressengine\DynamicField\AbstractSkin;

/**
 * Class UrlSkin
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Text
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UrlSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Text/fieldSkin/xpressengine@TextUrl';
    protected $name = 'Text url';
    protected $description = '문자열 URL 스킨';


    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Text url';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/text/url';
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

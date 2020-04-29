<?php
/**
 * DefaultSkin.php
 *
 * PHP version 7
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Url
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\FieldSkins\Url;

use Xpressengine\DynamicField\AbstractSkin;

/**
 * Class DefaultSkin
 *
 * @category    FieldSkins
 * @package     App\FieldSkins\Url
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DefaultSkin extends AbstractSkin
{
    protected static $id = 'fieldType/xpressengine@Url/fieldSkin/xpressengine@UrlDefault';
    protected $name = 'Url default';
    protected $description = 'URL 디폴트 스킨';


    /**
     * get name of skin
     *
     * @return string
     */
    public function name()
    {
        return 'Url default';
    }

    /**
     * get view file directory path
     *
     * @return string
     */
    public function getPath()
    {
        return 'dynamicField/url/default';
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

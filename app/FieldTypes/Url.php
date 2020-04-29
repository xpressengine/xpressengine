<?php
/**
 * Url.php
 *
 * PHP version 7
 *
 * @category    FieldTypes
 * @package     App\FieldTypes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\FieldTypes;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;
use View;

/**
 * Class Url
 *
 * @category    FieldTypes
 * @package     App\FieldTypes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Url extends AbstractType
{
    protected static $id = 'fieldType/xpressengine@Url';

    protected $rules = ['url' => 'url'];

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Url - 도메인 주소';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return 'URL을 등록합니다.';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'url' => (new ColumnEntity('url', ColumnDataType::STRING)),
        ];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 반환
     *
     * @return array
     */
    public function getSettingsRules()
    {
        return [];
    }

    /**
     * Dynamic Field 설정 페이지에서 각 fieldType 에 필요한 설정 등록 페이지 반환
     * return html tag string
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getSettingsView(ConfigEntity $config = null)
    {
        return View::make('dynamicField/url/createType', ['config' => $config])->render();
    }
}

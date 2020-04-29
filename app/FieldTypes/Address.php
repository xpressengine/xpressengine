<?php
/**
 * Address.php
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

use Illuminate\Database\Query\Builder;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;

/**
 * Class Address
 *
 * @category    FieldTypes
 * @package     App\FieldTypes
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Address extends AbstractType
{
    /**
     * @var string
     */
    protected static $id = 'fieldType/xpressengine@Address';

    /**
     * get field type name
     *
     * @return string
     */
    public function name()
    {
        return 'Address - 주소';
    }

    /**
     * get field type description
     *
     * @return string
     */
    public function description()
    {
        return '';
    }

    /**
     * return columns
     *
     * @return ColumnEntity[]
     */
    public function getColumns()
    {
        return [
            'postcode' => (new ColumnEntity('postcode', ColumnDataType::STRING))->setParams([8]),
            'address1' => (new ColumnEntity('address1', ColumnDataType::STRING))->setParams([255]),
            'address2' => (new ColumnEntity('address2', ColumnDataType::STRING))->setParams([255]),
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
        return '';
    }

    /**
     * query where 처리
     * 주소는 like 검색을 제공함
     * like 검색으로 성능에 문제가 발생하게 되므로 주소 검색은 beta 배포 전에 다시 제작
     *
     * @param DynamicQuery $query  query builder
     * @param array        $params parameters for search
     * @return Builder
     */
    public function wheres(DynamicQuery $query, array $params)
    {
        $config = $this->config;
        foreach ($this->getColumns() as $column) {
            $key = sprintf('%s_%s', $config->get('id'), $column->name);

            if (isset($params[$key]) && $params[$key] != '') {
                $columnName = $config->get('id') . '.' . $column->name;
                $query = $query->where($columnName, 'like', '%' . $params[$key] . '%');
            }
        }

        return $query;
    }
}

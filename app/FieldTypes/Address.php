<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\FieldTypes;

use Illuminate\Database\Query\Builder;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\DynamicField\AbstractType;
use Xpressengine\DynamicField\ColumnDataType;
use Xpressengine\DynamicField\ColumnEntity;

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
        return 'Address';
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
     * return rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            'postcode' => 'required',
            'address1' => 'required',
            'address2' => 'required'
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
            $key = camel_case($config->get('id') . '_' . $column->name);

            if (isset($params[$key]) && $params[$key] != '') {
                $query = $query->where($key, 'like', '%' . $params[$key] . '%');
            }
        }

        return $query;
    }

}

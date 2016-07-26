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
use App\FieldSkins\Address\DefaultSkin;

class Address extends AbstractType
{
    /**
     * @var string
     */
    protected static $id = 'FieldType/xpressengine@Address';

    protected $name = 'Address';
    protected $description = '';

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        app('xe.pluginRegister')->add(DefaultSkin::class);
        DefaultSkin::boot();
    }

    /**
     * 스키마 구성을 위한 database column 설정
     *
     * @return void
     */
    public function setColumns()
    {
        $this->columns['postcode'] = (new ColumnEntity('postcode', ColumnDataType::STRING))->setParams([8]);
        $this->columns['address1'] = (new ColumnEntity('address1', ColumnDataType::STRING))->setParams([255]);
        $this->columns['address2'] = (new ColumnEntity('address2', ColumnDataType::STRING))->setParams([255]);
    }

    /**
     * 사용자 페이지 입력할 때 적용될 rule 정의
     *
     * @return void
     */
    public function setRules()
    {
        $this->rules = ['postcode' => 'required'];
        $this->rules = ['address1' => 'required'];
        $this->rules = ['address2' => 'required'];
    }

    /**
     * 다이나믹필스 생성할 때 타입 설정에 적용될 rule 정의
     *
     * @return void
     */
    public function setSettingsRules()
    {
        // TODO: Implement setSettingsRules() method.
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
        // TODO: Implement getSettingsView() method.
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
        foreach ($this->columns() as $column) {
            $key = camel_case($config->get('id') . '_' . $column->name);

            if (isset($params[$key]) && $params[$key] != '') {
                $query = $query->where($key, 'like', '%' . $params[$key] . '%');
            }
        }

        return $query;
    }
}

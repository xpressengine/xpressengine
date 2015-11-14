<?php
/**
 * Column Entity class
 *
 * PHP version 5
 *
 * @category    DyanmicField
 * @package     Xpressengine\DynamidField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\DynamicField;

use Illuminate\Database\Schema\Blueprint;
use Xpressengine\Support\EntityTrait;

/**
 * FieldType 에서 table 스키마 를 정의 하기위해 사용.
 * AbstractFieldType class 의 columns 멤버 변수의 항목들을 ColumnEntity class 로 구성.
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ColumnEntity
{

    use EntityTrait;

    // default Config
    protected $default = [
        'name' => null,
        'dataType' => null,
        'params' => [],
        'unsigned' => false,
        'nullAble' => false,
        'default' => null,
        'description' => null,
    ];

    /**
     * create instance
     *
     * @param string $name     table's column name
     * @param string $dataType ColumnDataType class's member attribute
     */
    public function __construct($name, $dataType)
    {
        $this->__set('name', $name);
        $this->__set('dataType', $dataType);
    }

    /**
     * set params
     *
     * @param array $params param's value
     * @return $this
     */
    public function setParams($params)
    {
        $this->__set('params', $params);
        return $this;
    }

    /**
     * set unsigned attribute to true
     *
     * @return $this
     */
    public function setUnsigned()
    {
        $this->__set('unsigned', true);
        return $this;
    }

    /**
     * set null able attribute to true
     *
     * @return $this
     */
    public function setNullAble()
    {
        $this->__set('nullAble', true);
        return $this;
    }

    /**
     * set default attribute
     *
     * @param string $default table's default value
     * @return $this
     */
    public function setDefault($default)
    {
        $this->__set('default', $default);
        return $this;
    }

    /**
     * set description attribute
     *
     * @param string $description description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->__set('description', $description);
        return $this;
    }

    /**
     * parameter $table 에 설정에 맞는 adding column 구문을 수행한다.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table  schema builder
     * @param string                                $prefix column 이름 앞에 붙일 문자열
     * @return void
     */
    public function add(Blueprint $table, $prefix = '')
    {
        // make all names to camel case
        $this->__set('name', camel_case($prefix . $this->__get('name')));

        if (method_exists($table, $this->__get('dataType')) === false) {
            throw new Exceptions\InvalidColumnEntityException;
        }

        $params = $this->__get('params') != null ? $this->__get('params') : [];
        array_unshift($params, $this->__get('name'));

        $column = call_user_func_array(array($table, $this->__get('dataType')), $params);

        if ($this->__get('nullAble') != null) {
            $column->nullable($this->__get('nullAble'));
        }

        if ($this->__get('unsigned') != null) {
            $column->unsigned($this->__get('unsigned'));
        }
        if ($this->__get('default') != null) {
            $column->default($this->__get('default'));
        }
    }

    /**
     * 컬럼 제거
     *
     * @param \Illuminate\Database\Schema\Blueprint $table  schema builder
     * @param string                                $prefix column 이름 앞에 붙일 문자열
     * @return void
     */
    public function drop(Blueprint $table, $prefix = '')
    {
        $table->dropColumn(camel_case($prefix . $this->__get('name')));
    }
}

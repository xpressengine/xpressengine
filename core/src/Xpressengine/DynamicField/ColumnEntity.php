<?php
/**
 * ColumnEntity
 *
 * PHP version 7
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\DynamicField;

use Illuminate\Database\Schema\Blueprint;
use Xpressengine\Support\Entity;

/**
 * ColumnEntity
 *
 * @category    DynamicField
 * @package     Xpressengine\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ColumnEntity extends Entity
{
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
        $this->{'name'} = $name;
        $this->{'dataType'} = $dataType;
    }

    /**
     * set params
     *
     * @param array $params param's value
     * @return $this
     */
    public function setParams($params)
    {
        $this->{'params'} = $params;

        return $this;
    }

    /**
     * set unsigned attribute to true
     *
     * @return $this
     */
    public function setUnsigned()
    {
        $this->{'unsigned'} = true;

        return $this;
    }

    /**
     * set null able attribute to true
     *
     * @return $this
     */
    public function setNullAble()
    {
        $this->{'nullAble'} = true;

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
        $this->{'default'} = $default;

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
        $this->{'description'} = $description;

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
        if ($prefix) {
            $this->{'name'} = snake_case($prefix . '_' .  $this->{'name'});
        }

        if (method_exists($table, $this->{'dataType'}) === false) {
            throw new Exceptions\InvalidColumnEntityException;
        }

        $params = $this->{'params'} != null ? $this->{'params'} : [];
        array_unshift($params, $this->{'name'});

        $column = call_user_func_array(array($table, $this->{'dataType'}), $params);

        if ($this->get('nullAble') != null) {
            $column->nullable($this->get('nullAble'));
        }
        if ($this->get('unsigned') != null) {
            $column->unsigned($this->get('unsigned'));
        }
        if ($this->get('default') != null) {
            $column->default($this->get('default'));
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
        $table->dropColumn(snake_case($prefix . '_' .  $this->{'name'}));
    }
}

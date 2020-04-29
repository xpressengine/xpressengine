<?php
/**
 * DynamicModel
 *
 * PHP version 7
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database\Eloquent;

use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Xpressengine\Database\DynamicQuery;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Xpressengine\Database\Exceptions\KeyGeneratorNotFoundException;
use Illuminate\Database\Eloquent\Builder as OriginBuilder;
use Xpressengine\Keygen\Keygen;

/**
 * DynamicModel
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class DynamicModel extends Model
{
    /**
     * @var Keygen key generator
     */
    protected static $keyGenerator;

    /**
     * The connection resolver instance.
     *
     * @var Resolver
     */
    protected static $resolver;

    /**
     * The registered macros.
     *
     * @var array
     */
    protected static $macros = [];

    /**
     * @var array proxy options for database proxy
     */
    protected $proxyOptions = [];

    /**
     * @var bool use dynamic query
     */
    protected $dynamic = false;

    /**
     * dynamic mode 애서 사용될 attributes
     *
     * @var array
     */
    protected $dynamicAttributes = [];

    /**
     * $args 로 넘어온 데이터와 $columns 를 비교해서 $args 값을 거른다.
     * 처리중인 $columns 와 같은 이름을 데이터만 리턴됨
     * 이 처리는 dynamic 을 통해 proxy 를 처리 할 경우에 대해서 동작됨
     *
     * @param array $args    insert, update data
     * @param array $columns table columns
     * @return array
     */
    public function filter(array $args, array $columns = [])
    {
        if (count($columns) === 0) {
            $columns = $this->schema();
        }
        $pure = [];
        foreach ($args as $column => $value) {
            // 컬럼 이름은 문자열만 가능.
            if (is_string($column) && in_array($column, $columns)) {
                $pure[$column] = $args[$column];
            }
        }

        return $pure;
    }

    /**
     * get table schema
     *
     * @return array
     */
    private function schema()
    {
        return $this->getConnection()->getSchema($this->getTable());
    }

    /**
     * fill
     *
     * @param array $attributes attributes
     * @return $this
     */
    public function fill(array $attributes)
    {
        if ($this->dynamic === true) {
            $this->dynamicAttributes = $attributes;
            $attributes = $this->filter($attributes);
        }

        return parent::fill($attributes);
    }

    /**
     * get key generator
     *
     * @return Keygen
     */
    public function getKeyGen()
    {
        if (self::$keyGenerator === null) {
            throw new KeyGeneratorNotFoundException;
        }
        return self::$keyGenerator;
    }

    /**
     * Set key generator
     *
     * @param Keygen $keyGenerator key generator
     * @return void
     */
    public static function setKeyGen(Keygen $keyGenerator)
    {
        static::$keyGenerator = $keyGenerator;
    }

    /**
     * dynamic query 사용하도록 설정
     *
     * @param bool $use use dynamic query
     * @return $this
     */
    public function setDynamic($use)
    {
        $this->dynamic = $use;

        return $this;
    }

    /**
     * proxy option 설정
     *
     * @param array $options proxy options
     * @return $this
     */
    public function setProxyOptions(array $options)
    {
        $this->proxyOptions = $options;
        $this->setDynamic(true);

        return $this;
    }

    /**
     * get proxy option
     *
     * @return array
     */
    public function getProxyOptions()
    {
        return $this->proxyOptions;
    }

    /**
     * get dynamic attributes
     *
     * @return array
     */
    public function getDynamicAttributes()
    {
        return $this->dynamicAttributes;
    }

    /**
     * Create a new Eloquent query builder for the model.
     * Xpressengine\Database\Eloquent\Builder 울 사용하도록 변경
     *
     * @param  DynamicQuery $query dynamic query builder
     * @return \Xpressengine\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }

    /**
     * Illuminate Model 의 newBaseQueryBuilder 변경
     * VirtualConnection 을 통해 DynamicQuery 를 사용하도록 처리
     *
     * @return \Xpressengine\Database\DynamicQuery
     */
    protected function newBaseQueryBuilder()
    {
        /** @var \Xpressengine\Database\VirtualConnection $conn */
        $conn = $this->getConnection();

        $table = parent::getTable();

        if ($this->dynamic === true) {
            return $conn->dynamic($table, $this->getProxyOptions());
        } else {
            return $conn->table($table);
        }
    }

    /**
     * @param OriginBuilder $query   Illuminate database eloquent buildere
     * @param array         $options options
     * @return bool
     */
    protected function performInsert(OriginBuilder $query, array $options = [])
    {
        if ($this->incrementing !== true && is_null($this->{$this->getKeyName()}) === true) {
            $this->{$this->getKeyName()} = $this->getKeyGen()->generate();
        }
        return parent::performInsert($query, $options);
    }

    /**
     * Save the model to the database.
     *
     * @param array $options options
     * @return bool
     */
    public function save(array $options = [])
    {
        if ($this->dynamic === true) {
            $this->attributes = array_merge($this->attributes, $this->dynamicAttributes);
        }

        return parent::save($options);
    }

    /**
     * Determine if the model or given attribute(s) have been modified.
     *
     * @param array|string|null $attributes attributes
     * @return bool
     */
    public function isDirty($attributes = null)
    {
        if ($attributes) {
            return parent::isDirty($attributes);
        }

        return count($this->dynamicAttributes) > 0 ? true : parent::isDirty();
    }

    /**
     * Register a custom macro.
     *
     * @param string   $name  macro name
     * @param callable $macro callable
     * @return void
     */
    public static function macro($name, callable $macro)
    {
        array_set(static::$macros, static::class . '.' . $name, $macro);
    }

    /**
     * Checks if macro is registered.
     *
     * @param string $name macro name
     * @return bool
     */
    public static function hasMacro($name)
    {
        return array_get(static::$macros, static::class . '.' . $name);
    }

    /**
     * call macro
     * @param string $name       macro name
     * @param array  $parameters parameters
     * @return mixed
     */
    public function callMacro($name, $parameters = [])
    {
        $macro = array_get(static::$macros, static::class . '.' . $name);
        if ($macro instanceof Closure) {
            return call_user_func_array($macro->bindTo($this, get_class($this)), $parameters);
        } else {
            return call_user_func_array($macro, $parameters);
        }
    }

    /**
     * get macro value
     *
     * @param string $name macro name
     * @return mixed
     */
    public function getMacroValue($name)
    {
        $result = $this->callMacro($name);
        if ($result instanceof Relation) {
            $result = $result->getResults();
        }

        return $result;
    }

    /**
     * Handle dynamic method calls into the model.
     *
     * @param string $method     method
     * @param array  $parameters parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->callMacro($method, $parameters);
        }

        return parent::__call($method, $parameters);
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param string $key key
     * @return mixed
     */
    public function __get($key)
    {
        if (static::hasMacro($key)) {
            return $this->getMacroValue($key);
        }

        return parent::__get($key);
    }
}

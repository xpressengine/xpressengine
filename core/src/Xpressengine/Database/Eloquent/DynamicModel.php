<?php
/**
 * DynamicModel
 *
 * PHP version 5
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Database\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Xpressengine\Database\DynamicQuery;
use Illuminate\Database\ConnectionResolverInterface as Resolver;
use Xpressengine\Database\Exceptions\KeyGeneratorNotFoundException;
use Xpressengine\Database\Exceptions\ModelNotSupportDynamicModeException;
use Xpressengine\Keygen\Keygen;

/**
 * DynamicModel
 *
 * * Illuminate\Database\Eloquent\Builder wrapping class
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
     * @var bool use dynamic query
     */
    protected $dynamic = false;

    /**
     * @var array proxy options for database proxy
     */
    protected $proxyOptions = [];

    /**
     * dynamic mode 애서 사용될 attributes
     *
     * @var array
     */
    protected $dynamicAttributes = [];

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

    public function __construct(array $attributes = [])
    {

        //$this->setDynamicAttribute($attributes);
        if ($this->dynamic === true) {

            $this->bootIfNotBooted();
            $this->syncOriginal();
            $this->dynamicFill($attributes);
        } else {

        }

        parent::__construct($attributes);

    }

    public function setDynamicAttribute($key, $value)
    {
        $this->dynamicAttributes[$key] = $value;
        return $this;
    }

    public function dynamicFill(array $attributes= [])
    {
        if ($this->dynamic === false) {
            throw new ModelNotSupportDynamicModeException;
        }

        $attributes = $this->filter($attributes, $this->schema());

        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            $this->setAttribute($key, $value);
        }
    }

    /**
     * $args 로 넘어온 데이터와 $columns 를 비교해서 $args 값을 거른다.
     * 처리중인 $columns 와 같은 이름을 데이터만 리턴됨
     * 이 처리는 dynamic 을 통해 proxy 를 처리 할 경우에 대해서 동작됨
     *
     * @param array $args    insert, update data
     * @param array $columns table columns
     * @return array
     */
    private function filter(array $args, array $columns)
    {
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
     * get key generator
     *
     * @return Keygen
     */
    public function getKeyGenerator()
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
    public static function setKeyGenerator(Keygen $keyGenerator)
    {
        static::$keyGenerator = $keyGenerator;
        self::creating(function(DynamicModel $model) {
            if ($model->incrementing !== true && is_null($model->{$model->getKeyName()}) === true) {
                $model->{$model->getKeyName()} = $model->getKeyGenerator()->generate();
            }
        });
    }

    /**
     * Resolve a connection instance.
     *
     * @param  string|null  $connection
     * @return \Illuminate\Database\Connection
     */
    public static function resolveConnection($connection = null)
    {
        return static::$resolver->connection($connection);
    }

    /**
     * Get the connection resolver instance.
     *
     * @return Resolver
     */
    public static function getConnectionResolver()
    {
        return static::$resolver;
    }

    /**
     * Set the connection resolver instance.
     *
     * @param  Resolver  $resolver
     * @return void
     */
    public static function setConnectionResolver(Resolver $resolver)
    {
        static::$resolver = $resolver;
    }

    /**
     * Unset the connection resolver for models.
     *
     * @return void
     */
    public static function unsetConnectionResolver()
    {
        static::$resolver = null;
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
        if (empty($options['table'])) {
            $options['table'] = $this->getTable();
        }
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
}

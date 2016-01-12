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

    const CREATED_AT = 'createdAt';

    const UPDATED_AT = 'updatedAt';

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
                $model->{$model->getKeyName()} =$model->getKeyGenerator()->generate();
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

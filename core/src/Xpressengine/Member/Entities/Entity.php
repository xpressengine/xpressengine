<?php
/**
 * Abstract Entity class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Member\Entities;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * 이 클래스는 Member package에서 구현되는 Entity class들이 상속받아야 하는 추상클래스이다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @deprecated
 */
abstract class Entity implements Arrayable, Jsonable
{
    /**
     * Entity object를 생성할 당시의 attributes 정보. 현재 저장소에 저장돼 있는 값을 나타낸다.
     *
     * @var array
     */
    protected $original = [];

    /**
     * Entity object를 수정할 경우, 변경되는 attributes 정보
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * Entity 와 연관된 attribute의 key 리스트
     *
     * @var string[]
     */
    protected static $relationFields = [];

    /**
     * 해당 Entity object와 연관된 attribute의 object 리스트
     *
     * @var Entity[]
     */
    protected $relations = [];

    /**
     * toArray를 통해 Entity object를 출력할 때, 출력되지 말아야할 attribute의 key리스트
     *
     * @var string[]
     */
    protected $hidden = [];

    /**
     * date 형식의 attribute의 key 리스트. 지정된 attribute는 출력될 때 Carbon 클래스의 object로 변환되어 출력된다.
     *
     * @var string[]
     */
    protected $dates = ['createdAt', 'updatedAt'];

    /**
     * constructor. attribute 정보를 입력받는다.
     *
     * @param array $attributes attribute 정보
     */
    public function __construct(array $attributes = [])
    {
        $this->fill($attributes);
        $this->syncOriginal();
    }

    /**
     * Entity의 relation field를 추가한다.
     *
     * @param string $key 추가할 relation field
     *
     * @return void
     */
    public static function addRelationField($key)
    {
        static::$relationFields[$key] = $key;
    }

    /**
     * original attributes를 반환한다.
     *
     * @return array
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * original을 attributes 정보로 동기화시킨다.
     *
     * @return void
     */
    public function syncOriginal()
    {
        $this->original = $this->attributes;
    }

    /**
     * 현재 attribute 리스트를 출력한다.
     *
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * 주어진 key에 해당하는 attribute 값을 반환한다.
     *
     * @param string $key 반환할 attribute의 key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if ($this->isRelationField($key)) {
            return array_get($this->relations, $key);
        } else {
            $value = array_get($this->attributes, $key);
            if (in_array($key, $this->dates)) {
                return $this->createDateAttribute($value);
            }
            return $value;
        }
    }

    /**
     * 주어진 key의 attribute에 주어진 value를 저장한다.
     *
     * @param string $key   저장할 key
     * @param mixed  $value 저장할 값
     *
     * @return void
     */
    public function setAttribute($key, $value)
    {
        if ($this->isRelationField($key)) {
            $this->relations[$key] = $value;
        } else {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Entity가 생성된 후 변경된 attribute의 정보를 반환한다.
     *
     * @return array
     */
    public function diff()
    {
        return array_diff_assoc($this->attributes, $this->original);
    }

    /**
     * 주어진 key에 해당하는 original attribute의 값을 조회하여 반환한다.
     *
     * @param string $key 조회할 attribute의 key
     *
     * @return mixed
     */
    public function raw($key)
    {
        return array_get($this->original, $key);
    }

    /**
     * 주어진 attributes를 Entity에 적용한다.
     *
     * @param array $attributes 적용할 attributes
     *
     * @return void
     */
    public function fill(array $attributes)
    {
        $relations = array_intersect_key($attributes, array_flip($this::$relationFields));
        $this->relations = array_merge($this->relations, $relations);

        $attributes = array_diff_key($attributes, array_flip($this::$relationFields));
        $this->attributes = array_merge($this->attributes, $attributes);
    }

    /**
     * 주어진 key에 해당하는 Entity object의 attribute value를 반환한다.
     *
     * @param string $key 조회할 attribute key
     *
     * @return mixed
     */
    public function __get($key)
    {
        $value = $this->getAttribute($key);
        if ($value === null) {
            return null;
        }

        if ($this->hasGetMutator($key)) {
            return $this->mutateAttribute($key, $value);
        }

        return $this->getAttribute($key);
    }

    /**
     * 주어진 attribute에 해당하는 Mutator가 있는지 조회한다.
     *
     * @param string $key 조회할 attribute의 key
     *
     * @return bool Mutator가 있으면 true, 없으면 false
     */
    protected function hasGetMutator($key)
    {
        return method_exists($this, 'get'.studly_case($key));
    }

    /**
     * 주어진 attribute에 해당하는 Mutator를 실행하여 반환한다.
     *
     * @param string $key   조회할 attribute의 key
     * @param mixed  $value Mutator 실행시 전달할 attribute의 value
     *
     * @return mixed
     */
    protected function mutateAttribute($key, $value)
    {
        return $this->{'get'.studly_case($key)}();
    }

    /**
     * Entity object의 attribute에 주어진 key, value를 저장한다.
     *
     * @param string $key 저장할 attribute의 key
     * @param mixed  $val 저장할 attribute의 value
     *
     * @return void
     */
    public function __set($key, $val)
    {
        $this->setAttribute($key, $val);
    }

    /**
     * Entity object에 주어진 attribute가 있는지 체크한다.
     *
     * @param string $key attribute의 key
     *
     * @return bool
     */
    public function __isset($key)
    {
        if ($this->isRelationField($key)) {
            return isset($this->relations[$key]);
        } else {
            return isset($this->attributes[$key]);
        }
    }

    /**
     * 주어진 attribute를 unset시킨다.
     *
     * @param string $key unset시킬 attribute key
     *
     * @return void
     */
    public function __unset($key)
    {
        if ($this->isRelationField($key)) {
            unset($this->relations[$key]);
        } else {
            unset($this->attributes[$key]);
        }
    }

    /**
     * 주어진 key에 해당하는 relation 정보가 있는지 조회한다.
     *
     * @param string $key relation field key
     *
     * @return bool
     */
    protected function isRelationField($key)
    {
        return in_array($key, $this::$relationFields);
    }

    /**
     * Entity object를 array 형식으로 반환한다.
     *
     * @return array
     */
    public function toArray()
    {
        $all = array_merge($this->attributes, $this->relations);

        foreach ($all as $attr) {
            $filterd = array_diff_key($all, array_flip($this->hidden));
        }
        return $filterd;
    }

    /**
     * Entity object를 json 형식으로 반환한다.
     *
     * @param int $options json encode option
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * date type의 attribute를 반환할 때 사용되는 포멧 변환기
     *
     * @param string $value time
     *
     * @return string
     */
    protected function createDateAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value);
    }
}

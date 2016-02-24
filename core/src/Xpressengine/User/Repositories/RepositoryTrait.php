<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User\Repositories;

use Xpressengine\Database\Eloquent\DynamicModel as Model;

/**
 * @category
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @method      create(array $attributes = [])
 * @method      where($column, $operator = null, $value = null, $boolean = 'and') Illuminate\Database\Query\Builder
 * @method      whereIn($column, $values, $boolean = 'and', $not = false) Illuminate\Database\Query\Builder
 */
trait RepositoryTrait
{
    /**
     * @var string model name. Xpressengine\Database\Eloquent\DynamicModel를 상속받은 class의 이름이어야 한다
     */
    protected $model;

    /**
     * update
     *
     * @param Model $item
     * @param array $data
     *
     * @return Model
     */
    public function update(Model $item, array $data = [])
    {
        if($data === null) {
            $item->update($data);
        }
        return $item;
    }

    /**
     * delete
     *
     * @param Model $item
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Model $item)
    {
        return $item->delete();
    }

    /**
     * The name of Category model class
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the name of Category model
     *
     * @param string $model model class
     * @return void
     */
    public function setModel($model)
    {
        $this->model = '\\' . ltrim($model, '\\');
    }

    /**
     * Create model instance
     *
     * @return Model
     */
    public function newModel()
    {
        $class = $this->getModel();

        return new $class;
    }

    /**
     * query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(){
        return $this->newModel()->newQuery();
    }

    public function __call($method, $parameters)
    {
        $model = $this->newModel();
        return call_user_func_array([$model, $method], $parameters);
    }
}

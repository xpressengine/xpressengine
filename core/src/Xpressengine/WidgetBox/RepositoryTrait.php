<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    WidgetBox
 * @package     Xpressengine\WidgetBox
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\WidgetBox;

use Xpressengine\Database\Eloquent\DynamicModel as Model;

/**
 * @category    WidgetBox
 * @package     Xpressengine\WidgetBox
 */
trait RepositoryTrait
{
    /**
     * @var string model name.
     * Xpressengine\Database\Eloquent\DynamicModel를 상속받은 class의 이름이어야 한다
     */
    protected $model;

    /**
     * constructor.
     *
     * @param mixed $model model
     */
    public function __construct($model)
    {
        $this->setModel($model);
    }

    /**
     * update
     *
     * @param Model $item item
     * @param array $data data
     *
     * @return Model
     */
    public function update(Model $item, array $data = [])
    {
        $item->update($data);
        return $item;
    }

    /**
     * delete
     *
     * @param Model $item item
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
    public function createModel()
    {
        $class = $this->getModel();

        return new $class;
    }

    /**
     * query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->createModel()->newQuery();
    }

    /**
     * __call
     *
     * @param string $method     method name
     * @param array  $parameters parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $model = $this->createModel();
        return call_user_func_array([$model, $method], $parameters);
    }
}

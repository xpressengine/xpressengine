<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Log\Repositories;

use Xpressengine\Log\Models\Log;

/**
 * 어드민 접속 로그를 저장하는 Repository
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LogRepository
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
     * create log
     *
     * @param array $data log data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        $model = $this->createModel();
        return $model->create($data);
    }

    /**
     * update
     *
     * @param Log   $item item
     * @param array $data data
     *
     * @return Log
     */
    public function update(Log $item, array $data = [])
    {
        $item->update($data);
        return $item;
    }

    /**
     * delete
     *
     * @param Log $item item
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Log $item)
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
     * @return Log
     */
    public function createModel()
    {
        $class = $this->getModel();

        return new $class;
    }

    /**
     * get query
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

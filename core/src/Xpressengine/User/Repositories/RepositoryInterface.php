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

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{

    /**
     * update
     *
     * @param Model $item item
     * @param array $data data
     *
     * @return Model
     */
    public function update(Model $item, array $data = []);

    /**
     * delete
     *
     * @param Model $item item
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete($item);

    /**
     * The name of Category model class
     *
     * @return string
     */
    public function getModel();

    /**
     * Set the name of Category model
     *
     * @param string $model model class
     * @return void
     */
    public function setModel($model);

    /**
     * Create model instance
     *
     * @return Model
     */
    public function createModel();

    /**
     * query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query();
}

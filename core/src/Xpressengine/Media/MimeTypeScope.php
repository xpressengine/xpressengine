<?php
/**
 * This file is MimeTypeScope class
 *
 * PHP version 7
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class MimeTypeScope
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MimeTypeScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder query builder instance
     * @param Model   $model   model instance
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->whereIn('mime', $model->getMimes());
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param Builder $builder query builder instance
     * @param Model   $model   model instance
     * @return void
     */
    public function remove(Builder $builder, Model $model)
    {
        $query = $builder->getQuery();
        $bindings = $query->getRawBindings();

        foreach ((array) $query->wheres as $key => $where) {
            if (strtolower($where['type']) == 'in' && $where['column'] == 'mime') {
                unset($query->wheres[$key]);

                $query->wheres = array_values($query->wheres);
                $query->setBindings(array_diff($bindings['where'], $model->getMimes()), 'where');

                break;
            }
        }
    }
}

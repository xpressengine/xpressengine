<?php
/**
 * This file is MimeTypeScope class
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Media;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ScopeInterface;

/**
 * Class MimeTypeScope
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MimeTypeScope implements ScopeInterface
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

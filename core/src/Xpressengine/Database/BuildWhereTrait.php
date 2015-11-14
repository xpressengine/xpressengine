<?php
/**
 * This file is build where clause for query
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
namespace Xpressengine\Database;

/**
 * repository 에서 유연하게 query 를 수행하기위해 지원 됨.
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait BuildWhereTrait
{
    /**
     * Build where clause
     *
     * @param DynamicQuery $query  query builder instance
     * @param array        $wheres where clause
     * @return DynamicQuery
     */
    protected function buildWhere(DynamicQuery $query, array $wheres)
    {
        foreach ($wheres as $column => $value) {
            $or = false;
            $method = 'where';
            $arguments = [$column, $value];

            if (is_array($value) === true) {
                $operator = array_shift($value);

                if (strtolower($operator) == 'or') {
                    $or = true;
                    $operator = array_shift($value);
                }

                if (strtolower($operator) === 'between') {
                    $method = 'whereBetween';
                    $arguments = [$column, $value];
                } elseif (strtolower($operator) === 'not' && $value[0] === null) {
                    $method = 'whereNotNull';
                    $arguments = [$column];
                } else {
                    $arguments = [$column, $operator, $value];
                }
            } elseif ($value instanceof \Closure) {
                $arguments = [$value];
            }

            if ($or === true) {
                $method = 'or' . ucfirst($method);
            }

            $query = call_user_func_array([$query, $method], $arguments);
        }

        return $query;
    }
}

<?php
/**
 * Builder
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

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder as OriginBuilder;
use Xpressengine\Database\DynamicQuery;

/**
 * Builder
 *
 * * Illuminate\Database\Eloquent\Builder wrapping class
 *
*@category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Builder extends OriginBuilder
{
    /**
     * Create a new Eloquent query builder instance.
     *
     * @param DynamicQuery $query dynamic query builder
     */
    public function __construct(DynamicQuery $query)
    {
        $this->query = $query;
    }
}

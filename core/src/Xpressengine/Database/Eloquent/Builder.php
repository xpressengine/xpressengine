<?php
/**
 * Builder
 *
 * PHP version 7
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Database\Eloquent;

use Illuminate\Database\Eloquent\Builder as OriginBuilder;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\Database\ProxyManager;

/**
 * Builder
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Builder extends OriginBuilder
{
    /**
     * @var DynamicQuery
     */
    protected $query;

    /**
     * get proxy manager
     *
     * @return ProxyManager|null
     */
    public function getProxyManager()
    {
        return $this->query->getProxyManager();
    }
}

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

use Illuminate\Database\Eloquent\Builder as OriginBuilder;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\Database\ProxyManager;

/**
 * Builder
 *
 * * DynamicQuery 인터페이스 지원
 *
 * @category    Database
 * @package     Xpressengine\Database
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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

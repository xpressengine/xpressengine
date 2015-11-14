<?php
/**
 * Instance Route Repository
 *
 * PHP version 5
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */
namespace Xpressengine\Routing;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Routing\Exceptions\UnusableInstanceIdException;
use Xpressengine\Routing\Exceptions\UnusableUrlException;
use Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException;

/**
 * Instance Route Repository
 *
 * @category Routing
 * @package  Xpressengine\Routing
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class InstanceRouteRepository
{
    /**
     * @var string
     */
    public static $instanceRouteCacheName = 'xe.cached.instance.routes';
    /**
     * Database table name of to store instance route
     *
     * @var string $table
     */
    protected $table = 'instanceRoute';

    /**
     * database connection instance
     *
     * @var VirtualConnectionInterface
     */
    protected $conn;

    /**
     * constructor
     * 모든 instanceRoute 리스트를 가져와 저정해둠.
     *
     * @param VirtualConnectionInterface $conn database connection instance
     *
     */
    public function __construct(VirtualConnectionInterface $conn)
    {
        $this->conn = $conn;
    }

    /**
     * Get All InstanceRoute list
     * 생성 시점에 가져온 모든 instanceRoute 의 리스트를 반환
     *
     * @param string $siteKey site key
     *
     * @return InstanceRoute[]
     */
    public function all($siteKey)
    {
        $instanceRouteRows = $this->conn->table($this->table)
            ->where('site', '=', $siteKey)
            ->get();

        $instanceRoutes = [];
        foreach ($instanceRouteRows as $row) {
            $instanceRoute = $this->createModel($row);
            $instanceRoutes[$row['instanceId']] = $instanceRoute;
        }

        return $instanceRoutes;
    }

    /**
     * Find one InstanceRoute by InstanceId
     *
     * @param string $instanceId instance id
     *
     * @return InstanceRoute
     */
    public function find($instanceId)
    {
        $row = $this->conn->table($this->table)
            ->where('instanceId', '=', $instanceId)
            ->first();

        if ($row === null) {
            throw new NotFoundInstanceRouteException($instanceId);
        }

        $instanceRoute = $this->createModel($row);
        return $instanceRoute;
    }

    /**
     * Find one InstanceRoute by url (not included '/') and site key
     *
     * @param string $siteKey site key
     * @param string $url     instance at InstanceRoute ex) notice
     *
     * @return InstanceRoute
     */
    public function findBySiteAndUrl($siteKey, $url)
    {
        $row = $this->conn->table($this->table)
            ->where('url', '=', $url)
            ->where('site', '=', $siteKey)
            ->first();

        if ($row === null) {
            throw new NotFoundInstanceRouteException($url);
        }

        $instanceRoute = $this->createModel($row);
        return $instanceRoute;
    }

    /**
     * fetch
     *
     * @param callable $filter filter
     *
     * @return InstanceRoute[]
     */
    public function fetch(callable $filter)
    {
        $instanceRouteRows = $this->conn->table($this->table)
            ->where($filter)
            ->get();

        $instanceRoutes = [];
        foreach ($instanceRouteRows as $row) {
            $instanceRoute = $this->createModel($row);
            $instanceRoutes[$row['instanceId']] = $instanceRoute;
        }

        return $instanceRoutes;
    }

    /**
     * Insert one InstanceRoute
     *
     * @param InstanceRoute $newInstanceRoute new InstanceRoute
     *
     * @return bool
     */
    public function insert(InstanceRoute $newInstanceRoute)
    {
        return $this->conn->table($this->table)->insert(
            [
                'url' => $newInstanceRoute->url
                ,'module' => $newInstanceRoute->module
                ,'instanceId' => $newInstanceRoute->instanceId
                ,'menuId' => $newInstanceRoute->menuId
                ,'site' => $newInstanceRoute->site
            ]
        );
    }

    /**
     * Update one InstanceRoute
     *
     * @param InstanceRoute $modifiedInstanceRoute an InstanceRoute that modified
     *
     * @return int affected row count
     */
    public function update(InstanceRoute $modifiedInstanceRoute)
    {
        return $this->conn->table($this->table)
            ->where('instanceId', $modifiedInstanceRoute->instanceId)
            ->update([
                'url' => $modifiedInstanceRoute->url
            ]);
    }

    /**
     * Delete one InstanceRouteRoute
     *
     * @param string $instanceId instance id
     *
     * @return int $affectedRow
     */
    public function delete($instanceId)
    {
        return $this->conn->table($this->table)->where('instanceId', '=', $instanceId)->delete();
    }

    /**
     * countByUrl
     *
     * @param string   $siteKey site key
     * @param string   $url     url
     * @param callable $filter  filter
     *
     * @return int
     */
    public function countByUrl($siteKey, $url, callable $filter = null)
    {
        $query = $this->conn->table($this->table)
            ->where('url', '=', $url)
            ->where('site', '=', $siteKey);

        if ($filter !== null) {
            $query->where($filter);
        }

        return $query->count();
    }

    /**
     * countByInstanceId
     *
     * @param string   $instanceId instance Id
     * @param callable $filter     filter
     *
     * @return int
     */
    public function countByInstanceId($instanceId, callable $filter = null)
    {
        $query = $this->conn->table($this->table)->where('instanceId', '=', $instanceId);
        if ($filter !== null) {
            $query->where($filter);
        }

        return $query->count();
    }

    /**
     * create a new node model
     *
     * @param array $attributes model's attributes
     *
     * @return InstanceRoute
     */
    protected function createModel(array $attributes)
    {
        return new InstanceRoute($attributes);
    }
}

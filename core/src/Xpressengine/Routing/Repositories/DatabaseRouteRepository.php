<?php
/**
 * DatabaseRouteRepository
 *
 * PHP version 5
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Routing\Repositories;

use Illuminate\Contracts\Config\Repository as IlluminateConfig;
use Xpressengine\Routing\Exceptions\UnusableUrlException;
use Xpressengine\Routing\RouteRepository;
use Xpressengine\Routing\InstanceRoute;

/**
 * class DatabaseRouteRepository
 *
 * @category  Routing
 * @package   Xpressengine\Routing
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DatabaseRouteRepository implements RouteRepository
{
    /**
     * Protected keyword for url first segment
     *
     * @var array
     */
    public $protectedUrl = [
        'locale',
        'auth',
        'user',
        'file',
        'tag',
        'fieldType',
        'temporary',
    ];

    /**
     * Laravel config instance
     *
     * @var IlluminateConfig
     */
    protected $configs;

    /**
     * The route model
     *
     * @var string
     */
    protected $model;

    /**
     * DatabaseRouteRepository constructor.
     *
     * @param IlluminateConfig $configs Laravel config instance
     * @param string           $model   The route model
     */
    public function __construct(IlluminateConfig $configs, $model)
    {
        $this->configs = $configs;
        $this->model = $model;
    }

    /**
     * Returns all route items
     *
     * @return InstanceRoute[]
     */
    public function all()
    {
        return $this->createModel()->newQuery()->get();
    }

    /**
     * Retrieve a route by url segment and site key
     *
     * @param string $url     first segment of url
     * @param string $siteKey site key
     * @return InstanceRoute
     */
    public function findByUrlAndSiteKey($url, $siteKey)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('url', $url)->where('site_key', $siteKey)->first();
    }

    /**
     * Retrieve a route by instance identifier
     *
     * @param string $instanceId instance identifier
     * @return InstanceRoute
     */
    public function findByInstanceId($instanceId)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('instance_id', $instanceId)->first();
    }

    /**
     * Retrieve routes by site key
     *
     * @param string $siteKey site key
     * @return InstanceRoute[]
     */
    public function fetchBySiteKey($siteKey)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('site_key', $siteKey)->get();
    }

    /**
     * Retrieve routes by module name
     *
     * @param string $module module name
     * @return InstanceRoute[]
     */
    public function fetchByModule($module)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('module', $module)->get();
    }

    /**
     * Save a new route item and return the instance
     *
     * @param array $input route item attributes
     * @return InstanceRoute
     */
    public function create(array $input)
    {
        /** @var InstanceRoute $model */
        $model = $this->createModel();
        $model->fill($input);

        return $this->put($model);
    }

    /**
     * Save the route item
     *
     * @param InstanceRoute $route route instance
     * @return InstanceRoute
     */
    public function put(InstanceRoute $route)
    {
        if (!$this->validateUrl($route->site_key, $route->url, $route->exists === false)) {
            throw new UnusableUrlException(['url' => $route->url]);
        }

        $route->save();

        return $route;
    }

    /**
     * Check validate given url
     *
     * @param string $siteKey site key
     * @param string $url     first segment of url
     * @param bool   $isNew   if create new route then given true
     * @return bool
     */
    protected function validateUrl($siteKey, $url, $isNew)
    {
        $checkIncludingSlash = strpos($url, '/');
        if ($checkIncludingSlash !== false) {
            return false;
        }

        $configUrl = $this->configs->get('xe.routing');

        if ($isNew && $this->findByUrlAndSiteKey($url, $siteKey) !== null) {
            return false;
        }

        if (in_array($url, $this->protectedUrl) or in_array($url, $configUrl)) {
            return false;
        }

        return true;
    }

    /**
     * Delete the route item from the repository
     *
     * @param InstanceRoute $route route instance
     * @return bool|null
     */
    public function delete(InstanceRoute $route)
    {
        return $route->delete();
    }

    /**
     * Create a new instance of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function createModel()
    {
        $class = '\\'.ltrim($this->model, '\\');

        return new $class;
    }

    /**
     * Gets the name of the Eloquent user model.
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Sets the name of the Eloquent user model.
     *
     * @param string $model model class
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}

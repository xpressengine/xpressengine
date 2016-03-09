<?php
namespace Xpressengine\Routing\Repositories;

use Illuminate\Contracts\Config\Repository as IlluminateConfig;
use Xpressengine\Routing\Exceptions\UnusableUrlException;
use Xpressengine\Routing\RouteRepository;
use Xpressengine\Routing\InstanceRoute;

class DatabaseRouteRepository implements RouteRepository
{
    public $protectedUrl = [
        'locale',
        'auth',
        'member',
        'file',
        'tag',
        'fieldType',
        'temporary',
    ];

    protected $configs;

    protected $model;

    public function __construct(IlluminateConfig $configs, $model)
    {
        $this->configs = $configs;
        $this->model = $model;
    }

    public function all()
    {
        return $this->createModel()->newQuery()->get();
    }

    public function findByUrlAndSiteKey($url, $siteKey)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('url', $url)->where('siteKey', $siteKey)->first();
    }

    public function findByInstanceId($instanceId)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('instanceId', $instanceId)->first();
    }

    public function fetchBySiteKey($siteKey)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('siteKey', $siteKey)->get();
    }

    public function fetchByModule($module)
    {
        $model = $this->createModel();

        return $model->newQuery()->where('module', $module)->get();
    }

    public function create(array $input)
    {
        /** @var InstanceRoute $model */
        $model = $this->createModel();
        $model->fill($input);

        return $this->put($model);
    }

    public function put(InstanceRoute $model)
    {
        if (!$this->validateUrl($model->siteKey, $model->url, $model->exists === false)) {
            throw new UnusableUrlException(['url' => $model->url]);
        }

        $model->save();

        return $model;
    }

    protected function validateUrl($siteKey, $url, $isNew)
    {
        $checkIncludingSlash = strpos($url, '/');
        if ($checkIncludingSlash !== false) {
            return false;
        }

        $configUrl = [
            $this->configs->get('xe.routing.fixedPrefix'),
            $this->configs->get('xe.routing.settingsPrefix')
        ];

        if ($isNew && $this->findByUrlAndSiteKey($url, $siteKey) !== null) {
            return false;
        }

        if (in_array($url, $this->protectedUrl) or in_array($url, $configUrl)) {
            return false;
        }

        return true;
    }

    public function delete(InstanceRoute $model)
    {
        return $model->delete();
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
     * @param  string  $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }
}

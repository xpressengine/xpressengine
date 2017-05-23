<?php
/**
 * CacheableEloquentRepositoryTrait.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

use Illuminate\Database\Eloquent\Model;

trait CacheableEloquentRepositoryTrait
{
    use EloquentRepositoryTrait {
        update as eloquentUpdate;
        delete as eloquentDelete;
        __call as eloquentCall;
    }

    public function cacheCall($method, $arguments, \Closure $closure)
    {
        $class = get_called_class();
        $hash = $this->makeHash($arguments);
        $cacheKey = $class.'@'.$method.'.'.$hash;
        $cache = $this->resolveContainer('cache');

        if (!$data = $cache->get($cacheKey)) {
            $data = $cache->remember($cacheKey, $this->getLifetime(), $closure);
            $this->storeCacheKey($class, $cacheKey);
        }

        return $data;
    }

    protected function storeCacheKey($class, $cacheKey)
    {
        $cacheKeys = $this->getCacheKeys();

        if (!isset($cacheKeys[$class]) || !in_array($cacheKey, $cacheKeys[$class])) {
            $cacheKeys[$class][] = $cacheKey;
            $this->resolveContainer('filesystem.disk')->put($this->getKeyfile(), json_encode($cacheKeys));
        }
    }

    protected function clearCache()
    {
        $cache = $this->resolveContainer('cache');
        $cacheKeys = $this->getCacheKeys();

        if ($this->getNamespace()) {
            foreach ($cacheKeys as $keys) {
                foreach ($keys as $key) {
                    $cache->forget($key);
                }
            }
            $cacheKeys = null;
        } else {
            $class = get_called_class();
            if (isset($cacheKeys[$class])) {
                foreach ($cacheKeys[$class] as $key) {
                    $cache->forget($key);
                }
                unset($cacheKeys[$class]);
            }
        }

        $this->resolveContainer('filesystem.disk')->put($this->getKeyfile(), json_encode($cacheKeys));
    }

    protected function makeHash($args)
    {
        return hash('sha1', json_encode($args));
    }

    protected function resolveContainer($service = null)
    {
        return app($service);
    }

    protected function getCacheKeys()
    {
        $filesystem = $this->resolveContainer('filesystem.disk');
        if (!$filesystem->exists($this->getKeyfile())) {
            $filesystem->put($this->getKeyfile(), null);
        }

        return json_decode($filesystem->get($this->getKeyfile()), true) ?: [];
    }

    protected function getKeyfile()
    {
        $namespace = $this->getNamespace();
        $filename = $namespace ? $namespace.'_keys' : 'keys';
        return 'cachekeys/' . $filename;
    }

    protected function getNamespace()
    {
        return property_exists($this, 'namespace') ? $this->namespace : null;
    }

    protected function getLifetime()
    {
        return 60;
    }

    public function create(array $attributes = [])
    {
        $item = $this->createModel()->create($attributes);

        $this->clearCache();

        return $item;
    }

    /**
     * update
     *
     * @param Model $item item
     * @param array $data data
     *
     * @return Model
     */
    public function update(Model $item, array $data = [])
    {
        $item = $this->eloquentUpdate($item, $data);

        $this->clearCache();

        return $item;
    }

    /**
     * delete
     *
     * @param Model $item item
     *
     * @return bool|null
     * @throws \Exception
     */
    public function delete(Model $item)
    {
        $result = $this->eloquentDelete($item);

        $this->clearCache();

        return $result;
    }

    public function __call($name, $arguments)
    {
        return $this->cacheCall($name, $arguments, function () use ($name, $arguments) {
            return call_user_func([$this, 'eloquentCall'], $name, $arguments);
        });
    }
}

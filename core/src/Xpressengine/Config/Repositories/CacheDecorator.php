<?php
/**
 * Cache Decorator class
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Support\CacheInterface;

/**
 * 저장소를 wrapping 하여 cache 에 있는 정보는
 * 저장소에 요청되지 않고 cache 에서 반환 되도록 함
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CacheDecorator implements RepositoryInterface
{
    /**
     * repository instance
     *
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * cache instance
     *
     * @var CacheInterface
     */
    protected $cache;

    /**
     * Prefix for cache key
     *
     * @var string
     */
    protected $prefix = 'config';

    /**
     * memory cache
     *
     * @var array
     */
    protected $bag = [];

    /**
     * create instance
     *
     * @param RepositoryInterface $repo  repository instance
     * @param CacheInterface      $cache cache instance
     */
    public function __construct(RepositoryInterface $repo, CacheInterface $cache)
    {
        $this->repo = $repo;
        $this->cache = $cache;
    }

    /**
     * search getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return ConfigEntity
     */
    public function find($siteKey, $name)
    {
        list($head, $segments) = $this->parseName($name);
        $data = $this->getData($siteKey, $head);

        return is_null($data) ? null : $this->retrieve($data, $segments);
    }

    /**
     * Retrieve cache data
     *
     * @param array $data     config data
     * @param array $segments name segments
     * @return ConfigEntity|null
     */
    protected function retrieve(array $data, $segments)
    {
        foreach ($segments as $idx => $segment) {
            $name = implode('.', array_slice($segments, 0, $idx + 1));
            $data = &$data[$name];

            if ($idx < count($segments) - 1) {
                $data = &$data['children'];
            }
        }

        return isset($data['value']) ? $data['value'] : null;
    }

    /**
     * search ancestors getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return array
     */
    public function fetchParent($siteKey, $name)
    {
        list($head, $segments) = $this->parseName($name);
        $data = $this->getData($siteKey, $head);

        return is_null($data) ? [] : $this->getParentRecursive($data, $name);
    }

    /**
     * search ancestors recursive
     *
     * @param array  $tree data tree
     * @param string $name the name
     * @return array
     */
    private function getParentRecursive($tree, $name)
    {
        $arr = [];
        foreach ($tree as $nodeName => $node) {
            if (Str::startsWith($name, $nodeName) && $name !== $nodeName) {
                $arr = array_merge([$node['value']], $this->getParentRecursive($node['children'], $name));

                break;
            }
        }

        return $arr;
    }

    /**
     * search descendants getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return array
     */
    public function fetchChildren($siteKey, $name)
    {
        list($head, $segments) = $this->parseName($name);
        $data = $this->getData($siteKey, $head);

        return is_null($data) ? [] : $this->getChildrenRecursive($data, $name);
    }

    /**
     * search descendants recursive
     *
     * @param array  $tree data tree
     * @param string $name the name
     * @return array
     */
    private function getChildrenRecursive($tree, $name)
    {
        $arr = [];
        foreach ($tree as $nodeName => $node) {
            if (Str::startsWith($name, $nodeName)) {
                if ($name === $nodeName) {
                    $arr = $this->flattenChildren($node['children']);
                } else {
                    $arr = $this->getChildrenRecursive($node['children'], $name);
                }

                break;
            }
        }

        return $arr;
    }

    /**
     * flatten children tree into a single level
     *
     * @param array $tree data tree
     * @return array
     */
    private function flattenChildren($tree)
    {
        $arr = [];
        foreach ($tree as $nodeName => $node) {
            $arr[] = $node['value'];
            $arr = array_merge($arr, $this->flattenChildren($node['children']));
        }

        return $arr;
    }

    /**
     * save
     *
     * @param ConfigEntity $config config object
     * @return ConfigEntity
     */
    public function save(ConfigEntity $config)
    {
        $this->erase($config->siteKey, $config->name);

        return $this->repo->save($config);
    }

    /**
     * clear all just descendants vars
     *
     * @param ConfigEntity $config  config object
     * @param array        $excepts target to the except
     * @return void
     */
    public function clearLike(ConfigEntity $config, $excepts = [])
    {
        $this->erase($config->siteKey, $config->name);

        $this->repo->clearLike($config, $excepts);
    }

    /**
     * remove
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return void
     */
    public function remove($siteKey, $name)
    {
        $this->erase($siteKey, $name);

        $this->repo->remove($siteKey, $name);
    }

    /**
     * Parent Changing with descendant
     *
     * @param ConfigEntity $config config object
     * @param string       $to     to config prefix
     * @return void
     */
    public function foster(ConfigEntity $config, $to)
    {
        $this->erase($config->siteKey, $config->name);

        $this->repo->foster($config, $to);
    }

    /**
     * affiliated to another config
     *
     * @param ConfigEntity $config config object
     * @param string       $to     parent name
     * @return void
     */
    public function affiliate(ConfigEntity $config, $to)
    {
        $this->erase($config->siteKey, $config->name);

        $this->repo->affiliate($config, $to);
    }

    /**
     * get cached data
     *
     * @param string $siteKey site key
     * @param string $head    root name
     * @return array|null
     */
    protected function getData($siteKey, $head)
    {
        $key = $this->makeKey($siteKey, $head);

        if (!isset($this->bag[$key])) {
            $cacheKey = $this->getCacheKey($key);
            if (!$data = $this->cache->get($cacheKey)) {
                if (!$config = $this->repo->find($siteKey, $head)) {
                    return null;
                }

                $descendant = $this->repo->fetchChildren($siteKey, $head);
                $data = $this->make($config, $descendant);
                $this->cache->put($cacheKey, $data);
            }

            $this->bag[$key] = $data;
        }

        return $this->bag[$key];
    }

    /**
     * Make data for cache store
     *
     * @param ConfigEntity   $parent parent config
     * @param ConfigEntity[] $items  config list
     * @return array
     */
    protected function make(ConfigEntity $parent, array $items)
    {
        $children = Arr::where($items, function ($key, $child) use ($parent) {
            return $parent->getDepth() + 1 == $child->getDepth() && Str::startsWith($child->name, $parent->name);
        });

        $arr = [];
        foreach ($children as $child) {
            $arr = array_merge($arr, $this->make($child, $items));
        }

        return [
            $parent->name => [
                'value' => $parent,
                'children' => $arr,
            ]
        ];
    }

    /**
     * Remove cache data
     *
     * @param string $siteKey site key
     * @param string $name    config name
     * @return void
     */
    protected function erase($siteKey, $name)
    {
        list($head, $segments) = $this->parseName($name);
        $key = $this->makeKey($siteKey, $head);

        unset($this->bag[$key]);
        $this->cache->forget($this->getCacheKey($key));
    }

    /**
     * parse name to head and segments
     *
     * @param string $name the name
     * @return array
     */
    private function parseName($name)
    {
        $segments = explode('.', $name);

        return [reset($segments), $segments];
    }

    /**
     * Make key by combination of site key and config name
     *
     * @param string $siteKey site key
     * @param string $name    config name
     * @return string
     */
    public function makeKey($siteKey, $name)
    {
        return $siteKey . ':' . $name;
    }

    /**
     * String for cache key
     *
     * @param string $keyword keyword
     * @return string
     */
    protected function getCacheKey($keyword)
    {
        return $this->prefix . '@' . $keyword;
    }
}

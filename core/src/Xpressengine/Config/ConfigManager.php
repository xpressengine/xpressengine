<?php
/**
 * This file is config management class
 *
 * PHP version 7
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Config;

use XeSite;
use Closure;
use Xpressengine\Config\Exceptions\DuplicateException;
use Xpressengine\Config\Exceptions\InvalidArgumentException;
use Xpressengine\Config\Exceptions\NoParentException;
use Xpressengine\Config\Exceptions\NotExistsException;
use Xpressengine\Config\Exceptions\ValidationException;

/**
 * Class ConfigManager
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ConfigManager
{
    /**
     * repository instance
     *
     * @var ConfigRepository
     */
    protected $repo;

    /**
     * closure list
     *
     * @var array
     */
    protected $closures = [];

    /**
     * minimum name length
     *
     * @var int
     */
    protected $minNameLength = 3;

    /**
     * maximum name length
     *
     * @var int
     */
    protected $maxNameLength = 255;

    /**
     * constructor
     *
     * @param ConfigRepository $repo repository instance
     */
    public function __construct(ConfigRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * create new config
     *
     * @param string $group      the name of target
     * @param array  $collection entity value list
     * @param string $siteKey    site key
     * @return ConfigEntity
     * @throws DuplicateException
     */
    public function add($group, array $collection, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        if ($this->repo->find($siteKey, $group) !== null) {
            throw new DuplicateException(['name' => $group]);
        }

        $config = new ConfigEntity();
        $config->site_key = $siteKey;
        $config->name = $group;
        foreach ($collection as $item => $value) {
            $config = $this->share($config, $item, $value);
        }

        $config = $this->setAncestors($config);

        $this->validating($config);

        return $this->build($this->repo->save($config));
    }

    /**
     * returns config value
     *
     * @param string $key     the name of target including entity name
     * @param mixed  $default if not exists, be return
     * @param bool   $pure    Do not see the parents
     * @param string $siteKey site key
     * @return mixed
     */
    public function getVal($key, $default = null, $pure = false, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        list($group, $item) = $this->parseKey($key);

        $config = $this->get($group, false, $siteKey);

        if ($config !== null) {
            if ($pure === true) {
                return $config->getPure($item, $default);
            } else {
                return $config->get($item, $default);
            }
        }

        return $default;
    }

    /**
     * returns config pure value
     *
     * @param string $key     the name of target including entity name
     * @param mixed  $default if not exists, be return
     * @param string $siteKey site key
     * @return mixed
     */
    public function getPureVal($key, $default = null, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        return $this->getVal($key, $default, true, $siteKey);
    }

    /**
     * returns config object by target name
     *
     * @param string $group   the name of target
     * @param bool   $create  if not exists, create new entity object
     * @param string $siteKey site key
     * @return ConfigEntity
     */
    public function get($group, $create = false, $siteKey = null)
    {
        $defaultGroups = array(
//            'plugin',
            'site'
        );
        if(in_array(explode(".",$group)[0],$defaultGroups)) $siteKey = 'default';
        else if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();

        $config = $this->repo->find($siteKey, $group);

        $config = $config ?: ($create === true ? new ConfigEntity() : null);

        if ($config !== null) {
            $config->site_key = $siteKey;
            $config->name = $group;

            return $this->build($config);
        }

        return null;
    }

    /**
     * if not exists, create new entity object by target name
     *
     * @param string $group   the name of target
     * @param string $siteKey site key
     * @return ConfigEntity
     */
    public function getOrNew($group, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        return $this->get($group, true, $siteKey);
    }

    /**
     * set config value
     *
     * @param string   $key     the name of target including entity name
     * @param mixed    $value   the value to be set
     * @param bool     $toDesc  descendants modify if true
     * @param callable $filter  filter function
     * @param string   $siteKey site key
     * @return void
     */
    public function setVal($key, $value, $toDesc = false, callable $filter = null, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        list($group, $item) = $this->parseKey($key);

        if ($config = $this->get($group, false, $siteKey)) {
            $config = $this->share($config, $item, $value);
            $config = $this->build($this->repo->save($config));
        } else {
            $config = $this->add($group, [$item => $value], $siteKey);
        }

        if ($toDesc === true) {
            $this->convey($config, $filter, [$item]);
        }
    }

    /**
     * multiple set config values
     *
     * @param string   $group      the name of target
     * @param array    $collection items and values to be set
     * @param bool     $toDesc     descendants modify if true
     * @param callable $filter     filter function
     * @param string   $siteKey    site key
     * @return ConfigEntity
     */
    public function set($group, array $collection, $toDesc = false, callable $filter = null, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        if ($config = $this->get($group, false, $siteKey)) {
            foreach ($collection as $item => $value) {
                $config = $this->share($config, $item, $value);
            }

            $config = $this->build($this->repo->save($config));
        } else {
            $config = $this->add($group, $collection, $siteKey);
        }

        if ($toDesc === true) {
            $this->convey($config, $filter, array_keys($collection));
        }

        return $config;
    }

    /**
     * config change
     *
     * @param string   $group      the name of target
     * @param array    $collection items and values to be set
     * @param bool     $toDesc     descendants modify if true
     * @param callable $filter     filter function
     * @param string   $siteKey    site key
     * @return ConfigEntity
     * @throws NotExistsException
     */
    public function put($group, array $collection, $toDesc = false, callable $filter = null, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        if (!$config = $this->get($group, false, $siteKey)) {
            throw new NotExistsException(['name' => $group]);
        }

        $config->clear();
        foreach ($collection as $item => $value) {
            $config = $this->share($config, $item, $value);
        }

        $config = $this->build($this->repo->save($config));

        if ($toDesc === true) {
            $this->convey($config, $filter);
        }

        return $config;
    }

    /**
     * modify config information
     *
     * @param ConfigEntity $config config entity instance
     * @return ConfigEntity
     * @throws NotExistsException
     */
    public function modify(ConfigEntity $config)
    {
        if ($this->get($config->name, false, $config->site_key) === null) {
            throw new NotExistsException(['name' => $config->name]);
        }

        return $this->build($this->repo->save($config));
    }

    /**
     * shared when closure value
     *
     * @param ConfigEntity $config config instance
     * @param string       $item   configure key
     * @param mixed        $value  configure value
     * @return ConfigEntity
     */
    protected function share(ConfigEntity $config, $item, $value)
    {
        if ($value instanceof Closure) {
            if (isset($this->closures[$config->site_key]) === false) {
                $this->closures[$config->site_key] = [];
            }
            if (isset($this->closures[$config->site_key][$config->name]) === false) {
                $this->closures[$config->site_key][$config->name] = [];
            }
            $this->closures[$config->site_key][$config->name][$item] = $value;
        } else {
            $config->set($item, $value);
        }

        return $config;
    }

    /**
     * build config object
     *
     * @param ConfigEntity $config config instance
     * @return ConfigEntity
     */
    protected function build(ConfigEntity $config)
    {
        $this->bindClosure($config);

        return $this->setAncestors($config);
    }

    /**
     * binding registered closure to config
     *
     * @param ConfigEntity $config config instance
     * @return void
     */
    protected function bindClosure(ConfigEntity &$config)
    {
        if (isset($this->closures[$config->site_key])
            && isset($this->closures[$config->site_key][$config->name])) {
            $closures = $this->closures[$config->site_key][$config->name];

            foreach ($closures as $item => $closure) {
                $config->set($item, $closure);
            }
        }
    }

    /**
     * convey to descendants
     *
     * @param ConfigEntity $config config instance
     * @param callable     $filter filter function
     * @param array        $items  item key list
     * @return void
     */
    protected function convey(ConfigEntity $config, callable $filter = null, array $items = null)
    {
        $descendants = $this->repo->fetchDescendant($config->site_key, $config->name);

        /** @var ConfigEntity $descendant */
        foreach ($descendants as $descendant) {
            if ($filter === null || call_user_func($filter, $descendant) === true) {
                if ($items === null) {
                    $descendant->clear();
                } else {
                    foreach ($items as $item) {
                        $val = $config->getPure($item);
                        if ($val instanceof Closure) {
                            continue;
                        }

                        $descendant->set($item, $val);
                    }
                }

                $this->repo->save($descendant);
            }
        }
    }

    /**
     * remove config
     *
     * @param ConfigEntity $config config instance
     * @return void
     */
    public function remove(ConfigEntity $config)
    {
        $this->repo->remove($config->site_key, $config->name);
    }

    /**
     * remove config by group name
     *
     * @param string $name    config group name
     * @param string $siteKey site key
     * @return void
     */
    public function removeByName($name, $siteKey = null)
    {
        if($siteKey == null) $siteKey = XeSite::getCurrentSiteKey();
        if ($config = $this->get($name, false, $siteKey)) {
            $this->remove($config);
        }
    }

    /**
     * get next level configs
     *
     * @param ConfigEntity $config config instance
     * @return array
     */
    public function children(ConfigEntity $config)
    {
        $descendants = $this->repo->fetchDescendant($config->site_key, $config->name);

        $children = [];

        /** @var ConfigEntity $descendant */
        foreach ($descendants as $descendant) {
            if ($descendant->getDepth() == $config->getDepth() + 1) {
                $children[] = $this->build($descendant);
            }
        }

        return $children;
    }

    /**
     * parse a key into group and item
     *
     * @param string $key key string
     * @return array
     * @throws InvalidArgumentException
     */
    private function parseKey($key)
    {
        $depths = explode('.', $key);
        $item = array_pop($depths);
        $group = implode('.', $depths);

        if (empty($item) || empty($group)) {
            throw new InvalidArgumentException(['arg' => $key]);
        }

        return [$group, $item];
    }

    /**
     * ancestors setter
     *
     * @param ConfigEntity $config config instance
     * @return ConfigEntity
     */
    private function setAncestors(ConfigEntity $config)
    {
        $ancestors = $this->repo->fetchAncestor($config->site_key, $config->name);

        $ancestors = $this->sort($ancestors, 'desc');

        foreach ($ancestors as $ancestor) {
            $this->bindClosure($ancestor);

            $config->setParent($ancestor);
        }

        return $config;
    }

    /**
     * validation config
     *
     * @param ConfigEntity $config config instance
     * @return void
     * @throws ValidationException
     */
    protected function validating(ConfigEntity $config)
    {
        $len = strlen($config->name);
        if ($len < $this->minNameLength || $len > $this->maxNameLength) {
            throw new ValidationException([
                'message' => sprintf(
                    'The config group name must be between %s and $s.',
                    $this->minNameLength,
                    $this->maxNameLength
                )
            ]);
        }

        if ($config->getDepth() > 1 && $config->getParent() === null) {
            throw new ValidationException(['message' => $config->name . 'The config must be has parent']);
        }
    }

    /**
     * sort list
     *
     * @param array  $configs config instance list
     * @param string $flag    asc or desc
     * @return array
     */
    private function sort(array $configs, $flag = 'asc')
    {
        uasort($configs, function (ConfigEntity $front, ConfigEntity $rear) use ($flag) {
            $frontLevel = $front->getDepth();
            $rearLevel = $rear->getDepth();

            if ($frontLevel == $rearLevel) {
                return 0;
            }

            if ($flag === 'asc') {
                return ($frontLevel < $rearLevel) ? -1 : 1;
            } else {
                return ($frontLevel < $rearLevel) ? 1 : -1;
            }
        });

        return $configs;
    }

    /**
     * Move entity hierarchy to new parent or root
     *
     * @param ConfigEntity $config config object
     * @param string|null  $to     parent name
     * @return ConfigEntity
     * @throws InvalidArgumentException
     * @throws NoParentException
     */
    public function move(ConfigEntity $config, $to = null)
    {
        if ($to !== null && $this->repo->find($config->site_key, $to) === null) {
            throw new InvalidArgumentException(['arg' => $to]);
        }

        $parent = $config->getParent();

        if ($parent === null) {
            if ($config->getDepth() !== 1) {
                throw new NoParentException();
            }

            $this->repo->affiliate($config, $to);
        } else {
            $this->repo->foster($config, $to);
        }

        $arrName = explode('.', $config->name);
        $key = array_pop($arrName);
        if ($to !== null) {
            $key = $to . '.' . $key;
        }

        return $this->get($key, false, $config->site_key);
    }
}

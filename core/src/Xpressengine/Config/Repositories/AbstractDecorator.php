<?php
/**
 * Abstract Decorator class
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

use Xpressengine\Config\ConfigEntity;

/**
 * 저장소를 decorating 하여 처리될 수 있도록 하는 추상 클래스
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractDecorator implements RepositoryInterface
{
    /**
     * repository instance
     *
     * @var RepositoryInterface
     */
    protected $repo;

    /**
     * constructor
     *
     * @param RepositoryInterface $repo repository instance
     */
    public function __construct(RepositoryInterface $repo)
    {
        $this->repo = $repo;
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
        return $this->repo->find($siteKey, $name);
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
        return $this->repo->fetchParent($siteKey, $name);
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
        return $this->repo->fetchChildren($siteKey, $name);
    }

    /**
     * save
     *
     * @param ConfigEntity $config config object
     * @return ConfigEntity
     */
    public function save(ConfigEntity $config)
    {
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
        $this->repo->affiliate($config, $to);
    }
}

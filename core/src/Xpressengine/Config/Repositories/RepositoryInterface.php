<?php
/**
 * Repository interface
 *
 * PHP version 5
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Config\Repositories;

use Xpressengine\Config\ConfigEntity;

/**
 * 저장소에서 제공해야할 기능들을 정의
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface RepositoryInterface
{
    /**
     * search getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return ConfigEntity
     */
    public function find($siteKey, $name);

    /**
     * search ancestors getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return array
     */
    public function fetchParent($siteKey, $name);

    /**
     * search descendants getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return array
     */
    public function fetchChildren($siteKey, $name);

    /**
     * save
     *
     * @param ConfigEntity $config config object
     * @return ConfigEntity
     */
    public function save(ConfigEntity $config);

    /**
     * clear all just descendants vars
     *
     * @param ConfigEntity $config  config object
     * @param array        $excepts target to the except
     * @return void
     */
    public function clearLike(ConfigEntity $config, $excepts = []);

    /**
     * remove
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return void
     */
    public function remove($siteKey, $name);

    /**
     * Parent Changing with descendant
     *
     * @param ConfigEntity $config config object
     * @param string       $to     to config prefix
     * @return void
     */
    public function foster(ConfigEntity $config, $to);

    /**
     * affiliated to another config
     *
     * @param ConfigEntity $config config object
     * @param string       $to     parent name
     * @return void
     */
    public function affiliate(ConfigEntity $config, $to);
}

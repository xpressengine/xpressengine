<?php
/**
 * Config Repository
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

/**
 * 저장소에서 제공해야할 기능들을 정의
 *
 * @category    Config
 * @package     Xpressengine\Config
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface ConfigRepository
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
    public function fetchAncestor($siteKey, $name);

    /**
     * search descendants getter
     *
     * @param string $siteKey site key
     * @param string $name    the name
     * @return array
     */
    public function fetchDescendant($siteKey, $name);

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

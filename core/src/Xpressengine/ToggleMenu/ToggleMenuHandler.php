<?php
/**
 * This file is toggle menu handler.
 *
 * PHP version 5
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\ToggleMenu;

use Illuminate\Contracts\Container\Container;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Plugin\PluginRegister;
use Xpressengine\ToggleMenu\Exceptions\WrongInstanceException;

/**
 * Class ToggleMenuHandler
 *
 * @category    ToggleMenu
 * @package     Xpressengine\ToggleMenu
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ToggleMenuHandler
{
    /**
     * Register instance
     *
     * @var PluginRegister
     */
    protected $register;

    /**
     * Xe config instance
     *
     * @var ConfigManager
     */
    protected $cfg;

    /**
     * Container instance
     *
     * @var Container
     */
    protected $container;

    /**
     * Type suffix for register
     *
     * @var string
     */
    protected static $suffix = 'menu';

    /**
     * Constructor
     *
     * @param PluginRegister $register  Register instance
     * @param ConfigManager  $cfg       Xe config instance
     * @param Container      $container Container instance
     */
    public function __construct(PluginRegister $register, ConfigManager $cfg, Container $container)
    {
        $this->register = $register;
        $this->cfg = $cfg;
        $this->container = $container;
    }

    /**
     * 사용할 메뉴 아이템들을 반환
     *
     * @param string $id         target plugin id
     * @param string $instanceId instance id
     * @param string $identifier target identifier
     * @return AbstractToggleMenu[]
     * @throws WrongInstanceException
     */
    public function getItems($id, $instanceId = null, $identifier = null)
    {
        $items = $this->getActivated($id, $instanceId);

        foreach ($items as &$item) {
            $item = $this->container->make($item);

            if (!$item instanceof AbstractToggleMenu) {
                throw new WrongInstanceException();
            }

            $item->setArguments($id, $instanceId, $identifier);
        }

        return $items;
    }

    /**
     * 사용할 아이템들을 설정에 저장
     *
     * @param string      $id         target plugin id
     * @param string|null $instanceId instance id
     * @param array       $keys       menu item keys
     * @return \Xpressengine\Config\ConfigEntity
     */
    public function setActivates($id, $instanceId = null, array $keys = [])
    {
        $configKey = $this->getConfigKey($id, $instanceId);
        $config = [];
        if (count($keys) > 0) {
            $config = ['activate' => $keys];
        }

        if (!$this->cfg->get($configKey)) {
            return $this->cfg->add($configKey, $config);
        }

        return $this->cfg->put($configKey, $config);
    }

    /**
     * 활성화된 아이템 목록을 반환
     *
     * @param string      $id         target plugin id
     * @param string|null $instanceId instance id
     * @return array
     */
    public function getActivated($id, $instanceId = null)
    {
        $config = $this->cfg->getOrNew($this->getConfigKey($id, $instanceId));
        $keys = $config->get('activate', []);

        $activated = array_intersect_key($this->all($id), array_flip($keys));

        // sort
        $activated = array_merge(array_flip($keys), $activated);

        return array_filter($activated, function ($val) {
            return class_exists($val);
        });
    }

    /**
     * 활성화 되지 않은 아이템 목록을 반환
     *
     * @param string      $id         target plugin id
     * @param string|null $instanceId instance id
     * @return array
     */
    public function getDeactivated($id, $instanceId = null)
    {
        return array_diff_key($this->all($id), $this->getActivated($id, $instanceId));
    }

    /**
     * config 에서 사용할 key 반환
     *
     * @param string      $id         target plugin id
     * @param string|null $instanceId instance id
     * @return string
     */
    public function getConfigKey($id, $instanceId)
    {
        return 'toggleMenu@' . $id . ($instanceId !== null ? '.' . $instanceId : '');
    }

    /**
     * type 에 해당하는 모든 메뉴 아이템목록을 반환
     *
     * @param string $id target plugin id
     * @return array
     */
    public function all($id)
    {
        return $this->register->get($this->getTypeKey($id)) ?: [];
    }

    /**
     * register 에서 구분할 수 있는 type key 반환
     *
     * @param string $id target plugin id
     * @return string
     */
    private function getTypeKey($id)
    {
        return $id . PluginRegister::KEY_DELIMITER . 'toggleMenu';
    }
}

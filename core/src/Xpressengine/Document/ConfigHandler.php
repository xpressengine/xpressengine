<?php
/**
 * ConfigHandler
 *
 * PHP version 7
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 * @mainpage
 */

namespace Xpressengine\Document;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Document\Exceptions\ConfigNotFoundException;

/**
 * ConfigHandler
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ConfigHandler
{
    /**
     * config name
     */
    const CONFIG_NAME = 'document';

    /**
     * ConfigManager instance
     *
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var array
     */
    protected $default = [
        'instanceId' => '',
        'group' => '',
        'division' => false,
        'revision' => false,
    ];

    /**
     * create instance
     *
     * @param ConfigManager $configManager ConfigManager instance
     */
    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * get config handler instance
     *
     * @return ConfigManager
     */
    public function getConfigManager()
    {
        return $this->configManager;
    }

    /**
     * get default config
     *
     * @return ConfigEntity
     */
    public function getDefault()
    {
        return new ConfigEntity($this->default);
    }

    /**
     * get config Entity
     * $instanceId 가 없을 경우 default config 반환
     *
     * @param string $instanceId instance id
     * @return ConfigEntity
     */
    public function get($instanceId = null)
    {
        if ($instanceId === null) {
            return $this->configManager->get(self::CONFIG_NAME);
        } else {
            return $this->configManager->get(
                sprintf('%s.%s', self::CONFIG_NAME, $instanceId)
            );
        }
    }

    /**
     * Return default config when cannot found config
     *
     * @param string $instanceId instance id
     * @return ConfigEntity
     */
    public function getOrDefault($instanceId)
    {
        $config = $this->get($instanceId);
        if ($config === null) {
            $config = $this->getDefault();
        }
        return $config;
    }

    /**
     * config entity list 반환
     * list of ConfigEntity
     *
     * @return array
     */
    public function gets()
    {
        return $this->configManager->children($this->get());
    }

    /**
     * 새로운 document config entity 를 만들어 반환
     *
     * @param string $instanceId instance id
     * @param array  $params     parameters
     * @return ConfigEntity
     */
    public function make($instanceId, array $params)
    {
        $config = [
            'instanceId' => $instanceId,
            'group' => 'documents_' . $instanceId,
        ];

        $config = array_merge($config, $params);

        foreach ($this->getDefault() as $name => $value) {
            if (isset($params[$name]) === true) {
                $value = $params[$name];
            }
            $config[$name] = $value;
        }

        $configEntity = new ConfigEntity();
        foreach ($config as $name => $value) {
            $configEntity->set($name, $value);
        }
        return $configEntity;
    }

    /**
     * create document instance
     *
     * @param ConfigEntity $config document instance config
     * @return ConfigEntity
     */
    public function add(ConfigEntity $config)
    {
        $this->configManager->add(
            sprintf('%s.%s', self::CONFIG_NAME, $config->get('instanceId')),
            $config->getPureAll()
        );

        return $config;
    }

    /**
     * update document instance config
     * * Cannot changed 'division', 'revision' configure.
     *
     * @param ConfigEntity $config document instance config
     * @return ConfigEntity
     */
    public function put(ConfigEntity $config)
    {
        if ($this->get($config->get('instanceId')) === null) {
            throw new ConfigNotFoundException(['instanceId' => $config->get('instanceId')]);
        }

        $this->configManager->put(
            sprintf('%s.%s', self::CONFIG_NAME, $config->get('instanceId')),
            $config->getPureAll()
        );

        return $config;
    }

    /**
     * drop document instance
     *
     * @param ConfigEntity $config config
     * @return void
     */
    public function remove(ConfigEntity $config)
    {
        $this->configManager->remove($config);
    }
}

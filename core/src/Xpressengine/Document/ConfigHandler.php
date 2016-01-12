<?php
/**
 * ConfigHandler
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @mainpage
 */
namespace Xpressengine\Document;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Config\ConfigManager;

/**
 * ConfigHandler
 *
 * ## 사용법
 *
 * ### Default config 조회
 * ```php
 * $config = $configHandler->getDefault();
 * ```
 *
 * ### Config 조회
 * ```php
 * $config = $configHandler->get('instance-id');
 * ```
 *
 * ### Config 목록 조회
 * ```php
 * $configs = $configHandler->gets();
 * ```
 *
 * ### Config 생성
 * * 인스턴스 생성할 때 Document Config 추가가
 *```php
 * $params = [];
 * $config = $configHandler->makeEntity('instance-id', $params);
 * $config = $configHandler->add($config);
 * ```
 *
 * ### Config 수정
 * ```php
 * $config = $config;
 * $configHandler->put($config);
 * ```
 *
 * ### Config 삭제
 * ```php
 * $config = $config;
 * $configHandler->remove($config);
 * ```
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ConfigHandler
{

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
        'comment' => true,
        'assent' => true,
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
     * @param $instanceId
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
    public function makeEntity($instanceId, array $params)
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

        // array 로 ConfigEntity 를 만들고 싶다!!
        $configEntity = new ConfigEntity();
        foreach ($config as $name => $value) {
            $configEntity->set($name, $value);
        }
        return $configEntity;
    }

    /**
     * create document instance
     * * ex) 게시판 생성
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
     * * division, revision 설정 변경 불가.
     *      - 이 설정에 대한 변경은 core 에서 제공 안함.
     *
     * @param ConfigEntity $config document instance config
     * @return ConfigEntity
     */
    public function put(ConfigEntity $config)
    {
        if ($this->get($config->get('instanceId')) === null) {
            throw new Exceptions\ConfigException;
        }

        $diff = $config->diff();
        if (isset($diff['instanceId']) === null) {
            throw new Exceptions\ConfigException;
        }

        $this->configManager->put(
            sprintf('%s.%s', self::CONFIG_NAME, $config->get('instanceId')),
            $config->getPureAll()
        );

        return $config;
    }

    /**
     * drop document instance
     * * ex) 게시판 삭제
     *
     * @param ConfigEntity $config config
     * @return void
     */
    public function remove(ConfigEntity $config)
    {
        $this->configManager->remove($config);
    }
}

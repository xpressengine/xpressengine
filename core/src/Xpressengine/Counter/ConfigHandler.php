<?php
/**
 * ConfigHandler
 *
 * PHP version 5
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Counter;

use Xpressengine\Config\ConfigManager;
use Xpressengine\Config\ConfigEntity;

/**
 * ConfigHandler
 *
 * * Counter 에서 추가된 config 관리
 * * Counter 를 사용하기 위해서는
 * $counterName, $type(Counter::TYPE_ID or Counter::TYPE_SESSION) 을 설정해야 함
 *
 * ## 사용법
 *
 * ### Counter config init
 * * Counter 를 사용하기 위해서 config 를 설정해야 함
 *
 * ```php
 * $configHandler = app('xe.counter')->getConfigHandler();
 *
 * // board 의 read counter 등록
 * $configHandler->set('board_read', Counter::TYPE_SESSION);
 *
 * // board 의 vote counter 등록
 * $configHandler->set('board_vote', Counter::TYPE_ID);
 * ```
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ConfigHandler
{

    /**
     * config manager's name
     *
     * @var string
     */
    protected $name = 'counter';

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * create instance
     * @param ConfigManager $configManager config manager
     */
    public function __construct(ConfigManager $configManager)
    {
        $this->configManager = $configManager;
    }

    /**
     * get config entity
     *
     * @return ConfigEntity
     */
    public function get()
    {
        return $this->configManager->get($this->name);
    }

    /**
     * return Counter type of counter name
     *
     * @param string $counterName counter name
     * @return string
     */
    public function getType($counterName)
    {
        $config = $this->get();
        return $config->get($counterName) === null ? Counter::TYPE_ID : $config->get($counterName);
    }

    /**
     * set config
     *
     * @param string $counterName counter name
     * @param string $type        counter type
     * @return void
     */
    public function set($counterName, $type = Counter::TYPE_ID)
    {
        $config = $this->configManager->get($this->name);
        $config->set($counterName, $type);
        $this->configManager->put($this->name, $config->getPureAll());
    }
}

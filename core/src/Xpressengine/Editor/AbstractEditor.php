<?php
/**
 *  AbstractEditor
 *
 * PHP version 5
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Editor;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Support\MobileSupportTrait;

/**
 * AbstractEditor
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class AbstractEditor implements ComponentInterface
{
    use ComponentTrait, MobileSupportTrait;

    protected $editors;

    /**
     * @var string
     */
    protected $instanceId;

    /**
     * @var ConfigEntity|null
     */
    protected $config;

    protected $arguments = [];

    protected $tools;

    protected static $configResolver;

    public function __construct(EditorHandler $editors, $instanceId)
    {
        $this->editors = $editors;
        $this->instanceId = $instanceId;

        $this->config = $this->resolveConfig($instanceId);
    }

    public function setArguments($arguments)
    {
        $this->arguments = $arguments;

        return $this;
    }

    public static function setConfigResolver(callable $resolver)
    {
        static::$configResolver = $resolver;
    }

    protected function resolveConfig($instanceId)
    {
        if (!static::$configResolver) {
            return null;
        }

        return call_user_func(static::$configResolver, static::getConfigKey($instanceId));
    }

    public static function getConfigKey($instanceId)
    {
        return static::getId() . '.' . $instanceId;
    }

    abstract public function getName();

    /**
     * @return array
     */
    abstract public function getConfigData();

    /**
     * @return array
     */
    abstract public function getActivateToolIds();

    /**
     * @return AbstractTool[]
     */
    public function getTools()
    {
        if ($this->tools === null) {
            $this->tools = [];
            foreach ($this->config->get('tools', []) as $toolId) {
                if ($tool = $this->editors->getTool($toolId, $this->instanceId)) {
                    $this->tools[] = $tool;
                }
            }
        }

        return $this->tools;
    }

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    abstract public function render();

    /**
     * 에디터로 등록된 내용 출력
     *
     * @param string $content content
     * @return string
     */
    abstract public function compile($content);

    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}

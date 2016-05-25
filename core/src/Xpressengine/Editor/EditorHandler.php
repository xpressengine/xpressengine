<?php
/**
 * EditorHandler
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

use Xpressengine\Config\ConfigManager;
use Xpressengine\Editor\Exceptions\EditorNotFoundException;
use Xpressengine\Plugin\PluginRegister;
use Illuminate\Container\Container;

/**
 * Class EditorHandler
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class EditorHandler
{
    /**
     * PluginRegister instance
     *
     * @var PluginRegister
     */
    protected $register;

    /**
     * ConfigManager instance
     *
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * Container instance
     *
     * @var Container
     */
    protected $container;

    /**
     * Default editor identifier
     *
     * @var string
     */
    protected $defaultEditorId;

    /**
     * The selector for tool's compiling
     *
     * @var string
     */
    protected $selectorName = 'editor_component';

    /**
     * config name
     */
    const CONFIG_NAME = 'editors';

    /**
     * EditorHandler constructor.
     *
     * @param PluginRegister $register      PluginRegister instance
     * @param ConfigManager  $configManager ConfigManager instance
     * @param Container      $container     Container instance
     */
    public function __construct(PluginRegister $register, ConfigManager $configManager, Container $container)
    {
        $this->register = $register;
        $this->configManager = $configManager;
        $this->container = $container;
    }

    /**
     * Get registered editor ids
     *
     * @return array
     */
    public function getAll()
    {
        return $this->register->get('editor');
    }

    /**
     * Set default editor id
     *
     * @param string $editorId editor id
     * @return void
     */
    public function setDefaultEditorId($editorId)
    {
        $this->defaultEditorId = $editorId;
    }

    /**
     * Get default editor id
     *
     * @return string
     */
    public function getDefaultEditorId()
    {
        return $this->defaultEditorId;
    }

    /**
     * Set instance by instance id
     *
     * @param string $instanceId instance id
     * @param string $editorId   editor id
     * @return void
     */
    public function setInstance($instanceId, $editorId)
    {
        if ($editorId !== null && !$this->register->get($editorId)) {
            throw new EditorNotFoundException;
        }

        $this->configManager->set(self::CONFIG_NAME, [$instanceId => $editorId]);
    }

    /**
     * Get editor id by instance id
     *
     * @param string $instanceId instance id
     * @return string
     */
    public function getEditorId($instanceId)
    {
        $config = $this->configManager->get(self::CONFIG_NAME);

        return $config->get($instanceId);
    }

    /**
     * Get editor by instance id
     *
     * @param string $instanceId instance id
     * @return AbstractEditor
     */
    public function get($instanceId)
    {
        if (!$editorId = $this->getEditorId($instanceId)) {
            $editorId = $this->getDefaultEditorId();
        }

        $class = $this->register->get($editorId);

        return $this->container->make($class, ['instanceId' => $instanceId]);
    }

    /**
     * Rendering the editor
     *
     * @param string      $instanceId instance id
     * @param array|false $args       argument for editor
     * @return string
     * @deprecated
     */
    public function render($instanceId, $args)
    {
        return $this->get($instanceId)->setArguments($args)->render();
    }

    /**
     * Get all registered tools
     *
     * @return array
     */
    public function getToolAll()
    {
        return $this->register->get('editortool') ?: [];
    }

    /**
     * Get a tool
     *
     * @param string $toolId     tool id
     * @param string $instanceId instance id
     * @return AbstractTool|null
     */
    public function getTool($toolId, $instanceId)
    {
        foreach ($this->getToolAll() as $id => $class) {
            if ($toolId === $id) {
                return $this->container->make($class, ['instanceId' => $instanceId]);
            }
        }

        return null;
    }

    /**
     * Compile the raw content to be useful
     *
     * @param string $instanceId instance id
     * @param string $content    content
     * @return string
     */
    public function compile($instanceId, $content)
    {
        return $this->compileTools($instanceId, $this->get($instanceId)->compile($content));
    }

    /**
     * Compile the raw content to be useful by tools
     *
     * @param string $instanceId instance id
     * @param string $content    content
     * @return string
     */
    protected function compileTools($instanceId, $content)
    {
        return preg_replace_callback(
            '!<(?:(div)|img)([^>]*)' . $this->selectorName . '=([^>]*)>(?(1)(.*?)</div>)!is',
            function ($match) use ($instanceId) {
                $script = " {$match[2]} {$this->selectorName}={$match[3]}";
                $script = preg_replace('/([\w:-]+)\s*=(?:\s*(["\']))?((?(2).*?|[^ ]+))\2/i', '\1="\3"', $script);
                preg_match_all('/([a-z0-9_-]+)="([^"]+)"/is', $script, $m);

                $attributes = [];
                for ($i = 0, $c = count($m[0]); $i<$c; $i++) {
                    $attributes[$m[1][$i]] = $m[2][$i];
                }

                if (!isset($attributes[$this->selectorName])) {
                    return $match[0];
                }

                /** @var AbstractTool $tool */
                if ($tool = $this->getTool($attributes[$this->selectorName], $instanceId)) {
                    $tool->compile($match[0]);
                }

                // 대상 editor tool 이 존재하지 않는 경우 해당 내용 삭제
                return '';
            },
            $content
        );
    }
}

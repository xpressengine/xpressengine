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
 * EditorHandler
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
     * @var PluginRegister
     */
    protected $register;

    /**
     * @var ConfigManager
     */
    protected $configManager;

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var string
     */
    protected $defaultEditorId;

    /**
     * config name
     */
    const CONFIG_NAME = 'editors';

    protected $selectorName = 'editor_component';

    public function __construct(PluginRegister $register, ConfigManager $configManager, Container $container)
    {
        $this->register = $register;
        $this->configManager = $configManager;
        $this->container = $container;
    }

    /**
     * get registered editor component ids
     *
     * @return array
     */
    public function getAll()
    {
        return $this->register->get('editor');
    }

    /**
     * set default editor id
     *
     * @param string $editorId editor id
     */
    public function setDefaultEditorId($editorId)
    {
        $this->defaultEditorId = $editorId;
    }

    /**
     * get default editor id
     *
     * @return string
     */
    public function getDefaultEditorId()
    {
        return $this->defaultEditorId;
    }

    /**
     * set instance by instance id
     *
     * @param $instanceId
     * @param $editorId
     */
    public function setInstance($instanceId, $editorId)
    {
        if ($editorId !== null && !$this->register->get($editorId)) {
            throw new EditorNotFoundException;
        }

        $this->configManager->set(self::CONFIG_NAME, [$instanceId => $editorId]);
    }
    
    public function getEditorId($instanceId)
    {
        $config = $this->configManager->get(self::CONFIG_NAME);
        
        return $config->get($instanceId);
    }

    /**
     * get editor by instance id
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
     * @param $instanceId
     * @param $args
     * @return string
     *
     * @deprecated 
     */
    public function render($instanceId, $args)
    {
        return $this->get($instanceId)->setArguments($args)->render();
    }
    
    public function getToolAll()
    {
        return $this->register->get('editortool');
    }
    
    public function getTool($toolId, $instanceId)
    {
        foreach ($this->getToolAll() as $id => $class) {
            if ($toolId === $id) {
                return $this->container->make($class, ['instanceId' => $instanceId]);
            }
        }

        return null;
    }
    
    public function compile($instanceId, $content)
    {
        return $this->compileTools($instanceId, $this->get($instanceId)->compile($content));
    }

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

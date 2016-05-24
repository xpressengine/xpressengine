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
        $editorId = $this->getEditorId($instanceId);
        if ($editorId === null) {
            // todo: default 사용할지 말지
            return null;
            $editorId = $this->getDefaultEditorId();
        }

        $component = $this->register->get($editorId);
        /**
         * @var AbstractEditor $editor
         */
//        $editor = new $component;
        $editor = $this->container->make($component);
        $editor->setInstanceId($instanceId);

        return $editor;
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
                /** @var AbstractTool $tool */
                $tool = $this->container->make($class);
                $tool->setInstanceId($instanceId);

                return $tool;
            }
        }

        return null;
    }
    
    public function compile($instanceId, $content)
    {
        $editor = $this->get($instanceId);
        $content = $editor->compile($content);
        /** @var AbstractTool $tool */
        foreach ($editor->getTools() as $tool) {
            $content = $tool->compile($content);
        }

        return $content;
    }

//    function transComponent($content)
//    {
//        $content = preg_replace_callback('!<(?:(div)|img)([^>]*)editor_component=([^>]*)>(?(1)(.*?)</div>)!is', array($this,'transEditorComponent'), $content);
//        return $content;
//    }
//    /**
//     * @brief Convert editor component code of the contents
//     */
//    function transEditorComponent($match)
//    {
//        $script = " {$match[2]} editor_component={$match[3]}";
//        $script = preg_replace('/([\w:-]+)\s*=(?:\s*(["\']))?((?(2).*?|[^ ]+))\2/i', '\1="\3"', $script);
//        preg_match_all('/([a-z0-9_-]+)="([^"]+)"/is', $script, $m);
//        $xml_obj = new stdClass;
//        $xml_obj->attrs = new stdClass;
//        for($i=0,$c=count($m[0]);$i<$c;$i++)
//        {
//            if(!isset($xml_obj->attrs)) $xml_obj->attrs = new stdClass;
//            $xml_obj->attrs->{$m[1][$i]} = $m[2][$i];
//        }
//        $xml_obj->body = $match[4];
//        if(!$xml_obj->attrs->editor_component) return $match[0];
//        // Get converted codes by using component::transHTML()
//        $oEditorModel = getModel('editor');
//        $oComponent = &$oEditorModel->getComponentObject($xml_obj->attrs->editor_component, 0);
//        if(!is_object($oComponent)||!method_exists($oComponent, 'transHTML')) return $match[0];
//        return $oComponent->transHTML($xml_obj);
//    }
}

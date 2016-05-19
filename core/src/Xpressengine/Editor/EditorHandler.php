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
     * @param $config
     */
    public function setInstance($instanceId, $editorId/*, ConfigEntity $config */)
    {
        if ($editorId !== null && !$this->register->get($editorId)) {
            throw new EditorNotFoundException;
        }

        $this->configManager->set(self::CONFIG_NAME, [$instanceId => $editorId]);

//        $component = $this->register->get($editorId);
//        /**
//         * @var AbstractEditor $editor
//         */
//        $editor = new $component;
//        $editor->setConfig($instanceId, $config);
    }

//    /**
//     * get editor instance
//     *
//     * @param $instanceId
//     * @return AbstractEditor
//     * @deprecated
//     */
//    public function getInstance($instanceId)
//    {
//        $editorId = $this->getEditorId($instanceId);
//
//        $component = $this->register->get($editorId);
//        /**
//         * @var AbstractEditor $editor
//         */
//        $editor = new $component;
//        $editor->setInstanceId($instanceId);
//
//        return $editor;
//    }

//    public function removeInstance($instanceId)
//    {
//        $editorId = $this->getEditorId($instanceId);
//
//        $component = $this->register->get($editorId);
//        /**
//         * @var AbstractEditor $editor
//         */
//        $editor = new $component;
//        $editor->removeConfig($instanceId);
//
//        $config = $this->configManager->get(self::CONFIG_NAME);
//        $arr = $config->getPureAll();
//        unset($arr[$instanceId]);
//        $this->configManager->put(self::CONFIG_NAME, $arr);
//    }

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

//    public function getByEditorId($editorId)
//    {
//
//    }

    public function render($instanceId, $args)
    {
        return $this->get($instanceId)->setArguments($args)->render();
    }
    
    public function getPartsAll()
    {
        return $this->register->get('editorparts');
    }
    
    public function getParts($partsId, $instanceId)
    {
        foreach ($this->getPartsAll() as $id => $class) {
            if ($partsId === $id) {
                /** @var AbstractParts $parts */
                $parts = $this->container->make($class);
                $parts->setInstanceId($instanceId);

                return $parts;
            }
        }

        return null;
    }
}

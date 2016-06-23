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
use Xpressengine\Media\MediaManager;
use Xpressengine\Media\Models\Image;
use Xpressengine\Plugin\PluginRegister;
use Illuminate\Contracts\Container\Container;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;

/**
 * Class EditorHandler
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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

    protected $storage;

    protected $mediaManager;

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
    protected $selectorName = 'xe-tool-id';

    const CONFIG_NAME = 'editor';

    /**
     * map config name
     */
    const MAP_CONFIG_NAME = 'editors';

    const FILE_UPLOAD_PATH = 'public/editor';

    const THUMBNAIL_TYPE = 'spill';

    /**
     * EditorHandler constructor.
     *
     * @param PluginRegister $register      PluginRegister instance
     * @param ConfigManager  $configManager ConfigManager instance
     * @param Container      $container     Container instance
     */
    public function __construct(PluginRegister $register, ConfigManager $configManager, Container $container, Storage $storage, MediaManager $mediaManager)
    {
        $this->register = $register;
        $this->configManager = $configManager;
        $this->container = $container;
        $this->storage = $storage;
        $this->mediaManager = $mediaManager;
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

        $this->configManager->set(self::MAP_CONFIG_NAME, [$instanceId => $editorId]);
    }

    /**
     * Get editor id by instance id
     *
     * @param string $instanceId instance id
     * @return string
     */
    public function getEditorId($instanceId)
    {
        if (!$config = $this->configManager->get(self::MAP_CONFIG_NAME)) {
            $config = $this->configManager->set(self::MAP_CONFIG_NAME, []);
        }

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

        /** @var AbstractEditor $editor */
        $editor = $this->container->make($class, ['instanceId' => $instanceId]);
        $editor->setConfig($this->configManager->getOrNew($this->getConfigKey($instanceId)));

        return $editor;
    }

    /**
     * Rendering the editor
     *
     * @param string      $instanceId instance id
     * @param array|false $args       argument for editor
     * @param string|null $targetId   target id
     * @return string
     */
    public function render($instanceId, $args, $targetId = null)
    {
//        return $this->get($instanceId)->setArguments($args)->setTargetId($targetId)->render();
        $editor = $this->get($instanceId)->setArguments($args);
        if ($targetId) {
            $editor->setFiles($this->getFiles($targetId));
        }

        return $editor->render();
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
    public function compile($instanceId, $content, $targetId = null, $bodyOnly = false)
    {
        $editor = $this->get($instanceId);
        if ($targetId) {
            $editor->setFiles($this->getFiles($targetId));
        }
        
        return $this->compileTools($instanceId, $editor->compile($content));
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
                    return $tool->compile($match[0]);
                }

                // 대상 editor tool 이 존재하지 않는 경우 해당 내용 삭제
                return '';
            },
            $content
        );
    }

    /**
     * Perform any final actions for the store action lifecycle
     *
     * todo: tag 처리 필요 (mention 도 필요한지 확인)
     *
     * @param string $instanceId instance id
     * @param string $targetId   target id
     * @param array  $inputs     request inputs
     * @return void
     */
    public function terminate($instanceId, $targetId, $inputs = [])
    {
        $editor = $this->get($instanceId);
        $olds = File::getByFileable($targetId);
        $olds = $olds->getDictionary();
        $files = File::whereIn('id', array_get($inputs, $editor->getFileInputName(), []))->get();
        foreach ($files as $file) {
            if (!isset($olds[$file->getKey()])) {
                $this->storage->bind($targetId, $file);
            } else {
                unset($olds[$file->getKey()]);
            }
        }

        foreach ($olds as $old) {
            $this->storage->unBind($targetId, $old, true);
        }
    }

    protected function getFiles($targetId)
    {
        $data = [];
        $files = File::getByFileable($targetId);
        foreach ($files as $file) {
            $thumbnails = null;
            if ($this->mediaManager->is($file)) {
                $thumbnails = Image::getThumbnails($this->mediaManager->make($file), static::THUMBNAIL_TYPE);
            }

            $file->setRelation('thumbnails', $thumbnails);
            $data[] = $file;
        }

        return $data;
    }

    /**
     * Get a key string for the config
     *
     * @param string $instanceId instance identifier
     * @return string
     */
    public function getConfigKey($instanceId)
    {
        return static::CONFIG_NAME . '.' . $instanceId;
    }

    /**
     * Get a key string for the permission
     *
     * @param string $instanceId instance identifier
     * @return string
     */
    public function getPermKey($instanceId)
    {
        return $this->getConfigKey($instanceId);
    }
}

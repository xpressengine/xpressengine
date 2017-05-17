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
use Xpressengine\Media\Models\Media;
use Xpressengine\Plugin\PluginRegister;
use Illuminate\Contracts\Container\Container;
use Xpressengine\Storage\File;
use Xpressengine\Storage\Storage;
use Xpressengine\Tag\TagHandler;

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

    /**
     * Storage instance
     *
     * @var Storage
     */
    protected $storage;

    /**
     * MediaManager instance
     *
     * @var MediaManager
     */
    protected $mediaManager;

    /**
     * TagHandler instance
     *
     * @var TagHandler
     */
    protected $tagHandler;

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

    /**
     * Unique name
     *
     * @var string
     */
    const NAME = 'editor';

    /**
     * The name of config prefix
     *
     * @var string
     */
    const CONFIG_NAME = 'editor';

    /**
     * The name of map config
     *
     * @var string
     */
    const MAP_CONFIG_NAME = 'editors';

    /**
     * The path for upload
     *
     * @var string
     */
    const FILE_UPLOAD_PATH = 'public/editor';

    /**
     * The type of thumbnail
     *
     * @var string
     */
    const THUMBNAIL_TYPE = 'spill';

    /**
     * EditorHandler constructor.
     *
     * @param PluginRegister $register      PluginRegister instance
     * @param ConfigManager  $configManager ConfigManager instance
     * @param Container      $container     Container instance
     * @param Storage        $storage       Storage instance
     * @param MediaManager   $mediaManager  MediaManager instance
     * @param TagHandler     $tagHandler    TagHandler instance
     */
    public function __construct(
        PluginRegister $register,
        ConfigManager $configManager,
        Container $container,
        Storage $storage,
        MediaManager $mediaManager,
        TagHandler $tagHandler
    ) {
        $this->register = $register;
        $this->configManager = $configManager;
        $this->container = $container;
        $this->storage = $storage;
        $this->mediaManager = $mediaManager;
        $this->tagHandler = $tagHandler;
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
     * @param bool   $htmlable   content is htmlable
     * @return string
     */
    public function compile($instanceId, $content, $htmlable = false)
    {
        $editor = $this->get($instanceId);

        return $this->compileTools($instanceId, $editor->compile($content, $htmlable));
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
     * Get files of target used
     *
     * @param string $targetId target identifier
     * @return File[]
     */
    public function getFiles($targetId)
    {
        $data = [];
        $files = $this->storage->fetchByFileable($targetId);
        foreach ($files as $file) {
            $thumbnails = null;
            if ($this->mediaManager->is($file)) {
                $imgClass = $this->mediaManager->getHandler(Media::TYPE_IMAGE)->getModel();
                $thumbnails = $imgClass::getThumbnails($this->mediaManager->make($file), static::THUMBNAIL_TYPE);
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

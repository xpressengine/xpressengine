<?php
/**
 * AbstractEditor
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
 * Class AbstractEditor
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

    /**
     * EditorHandler instance
     *
     * @var EditorHandler
     */
    protected $editors;

    /**
     * Instance identifier
     *
     * @var string
     */
    protected $instanceId;

    /**
     * ConfigEntity instance
     *
     * @var ConfigEntity|null
     */
    protected $config;

    /**
     * Given arguments for the editor
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * Indicates if used only javascript.
     *
     * @var bool
     */
    protected $scriptOnly = false;

    /**
     * The registered tools for the editor
     *
     * @var AbstractTool[]
     */
    protected $tools;

    /**
     * Default editor options
     *
     * @var array
     */
    protected $defaultOptions = [
        'contentDomName' => 'content',
        'contentDomId' => 'xeContentEditor',
        'contentDomOptions' => [
            'class' => 'form-control',
            'rows' => '20',
            'cols' => '80'
        ],
        'editorOptions' => [],
    ];

    /**
     * The config resolver
     *
     * @var callable
     */
    protected static $configResolver;

    /**
     * AbstractEditor constructor.
     *
     * @param EditorHandler $editors    EditorHandler instance
     * @param string        $instanceId Instance identifier
     */
    public function __construct(EditorHandler $editors, $instanceId)
    {
        $this->editors = $editors;
        $this->instanceId = $instanceId;

        $this->config = $this->resolveConfig($instanceId);
    }

    /**
     * Set arguments for the editor
     *
     * @param array $arguments arguments
     * @return $this
     */
    public function setArguments($arguments = [])
    {
        $this->arguments = $arguments;

        if ($arguments === false) {
            $this->scriptOnly = true;
        }

        return $this;
    }

    /**
     * Get options
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge($this->defaultOptions, $this->arguments);
    }

    /**
     * Set the config resolver
     *
     * @param callable $resolver config resolver
     * @return void
     */
    public static function setConfigResolver(callable $resolver)
    {
        static::$configResolver = $resolver;
    }

    /**
     * Resolve a config instance
     *
     * @param string $instanceId instance identifier
     * @return ConfigEntity|null
     */
    protected function resolveConfig($instanceId)
    {
        if (!static::$configResolver) {
            return null;
        }

        return call_user_func(static::$configResolver, static::getConfigKey($instanceId));
    }

    /**
     * Get a key string for the config
     *
     * @param string $instanceId instance identifier
     * @return string
     */
    public static function getConfigKey($instanceId)
    {
        return static::getId() . '.' . $instanceId;
    }

    /**
     * Get a editor name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Get config data for the editor
     *
     * @return array
     */
    abstract public function getConfigData();

    /**
     * Get activated tool's identifier for the editor
     *
     * @return array
     */
    abstract public function getActivateToolIds();

    /**
     * Load tools
     *
     * @return void
     */
    protected function loadTools()
    {
        foreach ($this->getTools() as $tool) {
            $tool->initAssets();
        }
    }
    
    /**
     * Get activated tools for the editor
     *
     * @return AbstractTool[]
     */
    public function getTools()
    {
        if ($this->tools === null) {
            $this->tools = [];
            foreach ($this->getActivateToolIds() as $toolId) {
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
    public function render()
    {
        $this->loadTools();

        $htmlString = [];
        if ($this->scriptOnly === false) {
            $options = $this->getOptions();

            $htmlString[] = $this->getContentHtml(array_get($options, 'content'), $options);
            $htmlString[] = $this->getEditorScript($options);
        }
        
        return implode('', $htmlString);
    }

    /**
     * Compile the raw content to be useful
     *
     * @param string $content content
     * @return string
     */
    abstract public function compile($content);

    /**
     * Get a content html tag string
     *
     * @param string $content content
     * @param array  $options dom options
     * @return string
     */
    protected function getContentHtml($content, $options)
    {
        $contentHtml = [];
        $contentHtml[] = '<textarea ';
        $contentHtml[] = 'name="' . $options['contentDomName'] . '" ';
        $contentHtml[] = 'id="' . $options['contentDomId'] . '" ';
        $contentHtml[] = $this->getContentDomHtmlOption($options['contentDomOptions']);
        $contentHtml[] = ' placeholder="' . xe_trans('xe::content') . '">';
        $contentHtml[] = $content;
        $contentHtml[] = '</textarea>';

        return implode('', $contentHtml);
    }

    /**
     * Get attributes string for content html tag
     *
     * @param array $domOptions dom options
     * @return string
     */
    protected function getContentDomHtmlOption($domOptions)
    {
        $optionsString = '';
        foreach ($domOptions as $key => $val) {
            $optionsString.= "$key='{$val}' ";
        }

        return $optionsString;
    }

    /**
     * Get script for running the editor
     *
     * @param array $options options
     * @return mixed
     */
    protected function getEditorScript(array $options)
    {
        $editorScript = '
        <script>
            $(function() {
                XEeditor.getEditor(\'%s\').create(\'%s\', %s, %s, %s);
            });
        </script>';

        return sprintf(
            $editorScript,
            $this->getName(),
            $options['contentDomId'],
            json_encode($options['editorOptions']),
            json_encode($this->getConfigData()),
            json_encode($this->getTools())
        );
    }

    /**
     * Get uri string for editor setting by instance identifier
     *
     * @param string $instanceId instance identifier
     * @return string|null
     */
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}

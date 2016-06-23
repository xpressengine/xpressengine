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
use Illuminate\Contracts\Routing\UrlGenerator;

/**
 * Class AbstractEditor
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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

    protected $urls;

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

    protected $files = [];

    /**
     * @var
     *
     * @deprecated
     */
    protected $targetId;

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

    protected $fileInputName = '_files';

    /**
     * The config resolver
     *
     * @var callable
     *
     * @deprecated
     */
    protected static $configResolver;

    /**
     * AbstractEditor constructor.
     *
     * @param EditorHandler $editors    EditorHandler instance
     * @param string        $instanceId Instance identifier
     */
    public function __construct(EditorHandler $editors, UrlGenerator $urls, $instanceId)
    {
        $this->editors = $editors;
        $this->urls = $urls;
        $this->instanceId = $instanceId;

//        $this->config = $this->resolveConfig($instanceId);
    }

    public function setConfig(ConfigEntity $config)
    {
        $this->config = $config;

        return $this;
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

    public function setFiles($files = [])
    {
        $this->files = $files;
    }

    /**
     * Set target identified for the editor
     *
     * @param string $targetId target id
     * @return $this
     *
     * @deprecated
     */
    public function setTargetId($targetId)
    {
        $this->targetId = $targetId;

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
     *
     * @deprecated
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
     *
     * @deprecated
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
     * 
     * @deprecated 
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
            
            $options = array_merge($options, [
                'editorOptions' => [
                    'fileUpload' => [
                        'upload_url' => $this->urls->route('editor.file.upload'),
                        'source_url' => $this->urls->route('editor.file.source'),
                        'download_url' => $this->urls->route('editor.file.download'),
                        'destroy_url' => $this->urls->route('editor.file.destroy'),
                    ],
                    'suggestion' => [
                        'hashtag_api' => $this->urls->route('editor.hashTag'),
                        'mention_api' => $this->urls->route('editor.mention'),
                    ],
                ]
            ]);

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
    public function compile($content)
    {
        return $this->compileBody($content) . $this->getFileView();
    }

    abstract protected function compileBody($content);

    abstract protected function getFileView();

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
     *
     * @deprecated
     */
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }

    /**
     * Perform any final actions for the store action lifecycle
     *
     * @param array       $inputs     request inputs
     * @param string|null $targetId   target id
     * @return void
     *
     * @deprecated
     */
    public function terminate($inputs = [], $targetId = null)
    {
        //
    }

    public function getFileInputName()
    {
        return $this->fileInputName;
    }
}

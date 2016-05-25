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

    protected $scriptOnly = false;

    protected $tools;

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

    protected static $configResolver;

    public function __construct(EditorHandler $editors, $instanceId)
    {
        $this->editors = $editors;
        $this->instanceId = $instanceId;

        $this->config = $this->resolveConfig($instanceId);
    }

    public function setArguments($arguments = [])
    {
        $this->arguments = $arguments;

        if ($arguments === false) {
            $this->scriptOnly = true;
        }

        return $this;
    }

    /**
     * get options
     *
     * @return array
     */
    protected function getOptions()
    {
        return array_merge($this->defaultOptions, $this->arguments);
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

    protected function loadTools()
    {
        foreach ($this->getTools() as $tool) {
            $tool->initAssets();
        }
    }
    
    /**
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
        if($this->scriptOnly === false){
            $options = $this->getOptions();

            $htmlString[] = $this->getContentHtml(array_get($options, 'content'), $options);
            $htmlString[] = $this->getEditorScript($options);
        }
        
        return implode('', $htmlString); 
    }

    /**
     * 에디터로 등록된 내용 출력
     *
     * @param string $content content
     * @return string
     */
    abstract public function compile($content);

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
     * getContentDomHtmlOption
     *
     * @param array $domOptions
     *
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

    protected function getEditorScript($options)
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

    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }
}

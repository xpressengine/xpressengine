<?php
/**
 * AbstractEditor
 *
 * PHP version 7
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Editor;

use Illuminate\Contracts\Events\Dispatcher;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\MobileSupportTrait;
use Xpressengine\Permission\Instance;
use Xpressengine\Presenter\Html\FrontendHandler;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Auth\Access\Gate;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class AbstractEditor
 *
 * @category    Editor
 * @package     Xpressengine\Editor
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

    /**
     * UrlGenerator instance
     *
     * @var UrlGenerator
     */
    protected $urls;

    /**
     * Gate instance
     *
     * @var Gate
     */
    protected $gate;

    /**
     * SkinHandler instance
     *
     * @var SkinHandler
     */
    protected $skins;

    /**
     * Dispatcher instance
     *
     * @var Dispatcher
     */
    protected $events;

    /**
     * FrontendHandler instance
     *
     * @var FrontendHandler
     */
    protected $frontend;

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
     * Options for the editor
     *
     * @var null
     */
    protected $options = null;

    /**
     * Used files
     *
     * @var array
     */
    protected $files = [];

    /**
     * Cover file id
     *
     * @var null|string
     */
    protected $coverId = null;

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
     * The image resolver
     *
     * @var callable
     */
    protected static $imageResolver;

    /**
     * The privileged determiner
     *
     * @var callable
     */
    protected static $privilegedDeterminer;

    /**
     * Default editor arguments
     *
     * @var array
     */
    protected $defaultArguments = [
        'content' => '',
        'cover' => false,
        'contentDomName' => 'content',
        'contentDomId' => 'xeContentEditor',
        'contentDomOptions' => [
            'class' => 'form-control',
        ]
    ];

    /**
     * The file input name
     *
     * @var string
     */
    protected $fileInputName = '_files';

    /**
     * The tag input name
     *
     * @var string
     */
    protected $tagInputName = '_tags';

    /**
     * The mention input name
     *
     * @var string
     */
    protected $mentionInputName = '_mentions';

    /**
     * The cover input name
     *
     * @var string
     */
    protected $coverInputName = '_coverId';

    /**
     * The file class name
     *
     * @var string
     */
    protected $fileClassName = '__xe_file';

    /**
     * The image class name
     *
     * @var string
     */
    protected $imageClassName = '__xe_image';

    /**
     * The tag class name
     *
     * @var string
     */
    protected $tagClassName = '__xe_hashtag';

    /**
     * The mention class name
     *
     * @var string
     */
    protected $mentionClassName = '__xe_mention';

    /**
     * The file identifier attribute name
     *
     * @var string
     */
    protected $fileIdentifierAttrName = 'data-id';

    /**
     * The image identifier attribute name
     *
     * @var string
     */
    protected $imageIdentifierAttrName = 'data-id';

    /**
     * The mention identifier attribute name
     *
     * @var string
     */
    protected $mentionIdentifierAttrName = 'data-id';

    /**
     * AbstractEditor constructor.
     *
     * @param EditorHandler   $editors    EditorHandler instance
     * @param UrlGenerator    $urls       UrlGenerator instance
     * @param Gate            $gate       Gate instance
     * @param SkinHandler     $skins      SkinHandler instance
     * @param Dispatcher      $events     Dispatcher instance
     * @param FrontendHandler $frontend   FrontendHandler instance
     * @param string          $instanceId Instance identifier
     */
    public function __construct(
        EditorHandler $editors,
        UrlGenerator $urls,
        Gate $gate,
        SkinHandler $skins,
        Dispatcher $events,
        FrontendHandler $frontend,
        $instanceId
    ) {
        $this->editors = $editors;
        $this->urls = $urls;
        $this->gate = $gate;
        $this->skins = $skins;
        $this->events = $events;
        $this->frontend = $frontend;
        $this->instanceId = $instanceId;
    }

    /**
     * Set config for the editor
     *
     * @param ConfigEntity $config config instance
     * @return $this
     */
    public function setConfig(ConfigEntity $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * Get config for the editor
     *
     * @return null|ConfigEntity
     */
    public function getConfig()
    {
        return $this->config;
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
     * Get arguments for the editor
     *
     * @return array
     */
    public function getArguments()
    {
        return array_merge($this->defaultArguments, $this->arguments);
    }

    /**
     * Set files the editor used
     *
     * @param array $files file instances
     * @return void
     */
    public function setFiles($files = [])
    {
        $this->files = $files;
    }

    /**
     * Set cover file id
     *
     * @param string $coverId cover file id
     * @return void
     */
    public function setCover($coverId)
    {
        $this->coverId = $coverId;
    }

    /**
     * Get cover file id
     *
     * @return string
     */
    public function getCover()
    {
        return $this->coverId;
    }

    /**
     * Get a editor name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Determine if a editor html usable.
     *
     * @return boolean
     */
    abstract public function htmlable();

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions()
    {
        if (!$this->options) {
            $this->options = $this->buildOptions();
        }

        return $this->options;
    }

    /**
     * Build options
     *
     * @return array
     */
    protected function buildOptions()
    {
        $this->events->fire('xe.editor.option.building', $this);

        $options = array_merge($this->getStaticOption(), $this->getDynamicOption());

        $this->events->fire('xe.editor.option.builded', $this);

        return $options;
    }

    /**
     * Get static option data for the editor
     *
     * @return array
     */
    protected function getStaticOption()
    {
        $routeParam = ['instanceId' => $this->instanceId];
        return [
            'fileUpload' => [
                'upload_url' => $this->urls->route('editor.file.upload', $routeParam),
                'source_url' => $this->urls->route('editor.file.source', $routeParam),
                'download_url' => $this->urls->route('editor.file.download', $routeParam),
                'destroy_url' => $this->urls->route('editor.file.destroy', $routeParam),
            ],
            'instanceId' => $this->instanceId,
            'suggestion' => [
                'hashtag_api' => $this->urls->route('editor.hashTag'),
                'mention_api' => $this->urls->route('editor.mention'),
            ],
            'names' => [
                'file' => [
                    'input' => $this->getFileInputName(),
                    'class' => $this->getFileClassName(),
                    'identifier' => $this->getFileIdentifierAttrName(),
                    'image' => [
                        'class' => $this->getImageClassName(),
                        'identifier' => $this->getImageIdentifierAttrName(),
                    ]
                ],
                'tag' => [
                    'input' => $this->getTagInputName(),
                    'class' => $this->getTagClassName(),
                ],
                'mention' => [
                    'input' => $this->getMentionInputName(),
                    'class' => $this->getMentionClassName(),
                    'identifier' => $this->getMentionIdentifierAttrName(),
                ],
                'cover' => [
                    'input' => $this->getCoverInputName(),
                ],
            ],
            'cover' => [
                'use' => true, // @FIXME
                'coverId' => $this->getCover()
            ]
        ];
    }

    /**
     * Get dynamic option data for the editor
     *
     * @return array
     */
    protected function getDynamicOption()
    {
        $data = array_except($this->config->all(), 'tools');
        $data['fontFamily'] = isset($data['fontFamily']) ? array_map(function ($v) {
            return trim($v);
        }, explode(',', $data['fontFamily'])) : [];
        $data['extensions'] = isset($data['extensions']) ? array_map(function ($v) {
            return trim($v);
        }, explode(',', $data['extensions'])) : [];
        $data['extensions'] = array_search('*', $data['extensions']) !== false ? ['*'] : $data['extensions'];
        $instance = new Instance($this->editors->getPermKey($this->instanceId));
        $data['perms'] = [
            'html' => $this->gate->allows('html', $instance),
            'tool' => $this->gate->allows('tool', $instance),
            'upload' => $this->gate->allows('upload', $instance),
            'medialibrary' => auth()->user()->isAdmin()
        ];
        if (!$data['perms']['upload']) {
            $data['uploadActive'] = false;
        }
        $data['stylesheet'] = $this->config->get('stylesheet') ? asset($this->config->get('stylesheet')) : null;

        $data['files'] = $this->files;

        if ($this->isPrivileged()) {
            $data['fileMaxSize'] = min(
                $this->getMegaSize(ini_get('upload_max_filesize')),
                $this->getMegaSize(ini_get('post_max_size'))
            );
            $data['attachMaxSize'] = 0;
        }

        return $data;
    }

    /**
     * Get php.ini setting file size to MegaByte Size
     *
     * @param  string $originalSize php.ini setting value
     * @return float|int|mixed
     */
    protected function getMegaSize($originalSize)
    {
        $originalSize = strtoupper($originalSize);
        $unit = substr($originalSize, -1);
        $size = str_replace($unit, '', $originalSize);

        switch ($unit) {
            case 'K':
                $size = $size / 1024;
                break;

            case 'G':
                $size = $size * 1024;
                break;

            case 'T':
                $size = $size * 1024 * 1024;
                break;
        }

        return $size;
    }

    /**
     * Get activated tool's identifier for the editor
     *
     * @return array
     */
    public function getActivateToolIds()
    {
        return $this->config->get('tools', []);
    }

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
        $this->events->fire('xe.editor.render', $this);

        $this->loadTools();

        $htmlString = '';
        if ($this->scriptOnly === false) {
            $htmlString = $this->getContentHtml() . $this->getEditorScript($this->getOptions());
        }

        return $htmlString;
    }

    /**
     * Compile the raw content to be useful
     *
     * @param string $content  content
     * @param bool   $htmlable content is htmlable
     * @return string
     */
    public function compile($content, $htmlable = false)
    {
        $content = (string)$content;
        $this->events->fire('xe.editor.compile', $this);

        if ($htmlable !== true) {
            $content = nl2br(e($content));
        }

        $content = $this->hashTag($content);
        $content = $this->mention($content);
        $content = $this->link($content);
        $content = $this->image($content);

        $content = sprintf(
            '<xe-content data-instance-id="%s" class="xe-content xe-content-%s">%s</xe-content>',
            $this->getInstanceId(),
            $this->getInstanceId(),
            $content
        );

        return $this->compileBody($content);
    }

    /**
     * Compile content body
     *
     * @param string $content content
     * @return string
     */
    abstract protected function compileBody($content);

    /**
     * Get a content html tag string
     *
     * @return string
     */
    protected function getContentHtml()
    {
        $args = $this->getArguments();
        $html =
            '<textarea ' .
            'name="' . $args['contentDomName'] . '" ' .
            'id="' . $args['contentDomId'] . '" ' .
            $this->getContentDomHtmlOption($args['contentDomOptions']) .
            ' placeholder="' . xe_trans('xe::content') . '" '.
            'style="width:100%;">'.
            e($args['content']) .
            '</textarea>';

        return $html;
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
            jQuery(function($) {
                XE.app("Editor").then(function (Editor) {
                    Editor.getEditor(\'%s\').then(function(editor) {
                        editor.create(\'%s\', %s, %s, %s);
                    })
                })
            });
        </script>';

        return sprintf(
            $editorScript,
            $this->getName(),
            $this->getArguments()['contentDomId'],
            json_encode($options),
            json_encode($this->getCustomOptions()),
            json_encode($this->getTools())
        );
    }

    /**
     * Get options for some editor only
     *
     * @return array
     */
    public function getCustomOptions()
    {
        return [];
    }

    /**
     * Compile tags in content body
     *
     * @param string $content content
     * @return string
     */
    protected function hashTag($content)
    {
        $tags = $this->getData($content, '.' . $this->getTagClassName());
        foreach ($tags as $tag) {
            $word = ltrim($tag['text'], '#');
            $content = str_replace(
                $tag['html'],
                sprintf('<a href="#%s" class="%s">#%s</a>', $word, $this->getTagClassName(), $word),
                $content
            );
        }

        return $content;
    }

    /**
     * Compile mentions in content body
     *
     * @param string $content content
     * @return string
     */
    protected function mention($content)
    {
        $mentions = $this->getData($content, '.' . $this->getMentionClassName(), 'data-id');
        foreach ($mentions as $mention) {
            $name = ltrim($mention['text'], '@');
            $content = str_replace(
                $mention['html'],
                sprintf(
                    '<span role="button" class="%s" data-toggle="xeUserMenu" data-user-id="%s">@%s</span>',
                    $this->getMentionClassName(),
                    $mention['data-id'],
                    $name
                ),
                $content
            );
        }

        return $content;
    }

    /**
     * Compile links in content body
     *
     * @param string $content content
     * @return string
     */
    protected function link($content)
    {
        return $content;
    }

    /**
     * Compile images in content body
     *
     * @param string $content content
     * @return string
     */
    protected function image($content)
    {
        $list = $this->getData($content, 'img.' . $this->getImageClassName(), ['data-id', 'data-media-id', 'style', 'alt', 'title']);

        $ids = array_column($list, 'data-id');
        $images = static::resolveImage($ids);
        $temp = [];
        foreach ($images as $image) {
            $temp[$image->getOriginKey()] = $image;
        }
        $images = $temp;
        unset($temp);

        foreach ($list as $data) {
            if (!isset($images[$data['data-id']])) {
                continue;
            }

            $image = $images[$data['data-id']];

            $attrStr = trim($data['html'], ' </>');
            $content = str_replace(
                [
                    '<' . $attrStr . '>',
                    '<' . $attrStr . '/>',
                    '<' . $attrStr . ' >',
                    '<' . $attrStr . ' />',
                ],
                sprintf(
                    '<img src="%s" class="%s" data-id="%s" data-media-id="%s" style="%s" alt="%s" title="%s" />',
                    $image->url(),
                    $this->getImageClassName(),
                    $data['data-id'],
                    $data['data-media-id'],
                    $data['style'],
                    $data['alt'],
                    $data['title']
                ),
                $content
            );
        }

        return $content;
    }

    /**
     * Get html node data
     *
     * @param string $content    content
     * @param string $selector   selector string
     * @param array  $attributes attribute names
     * @return array
     */
    private function getData($content, $selector, $attributes = [])
    {
        $attributes = !is_array($attributes) ? [$attributes] : $attributes;

        $crawler = $this->createCrawler($content);
        return $crawler->filter($selector)->each(function ($node, $i) use ($attributes) {
            $dom = $node->getNode(0);
            $data = [
                'html' => $dom->ownerDocument->saveHTML($dom),
                'inner' => $node->html(),
                'text' => $node->text(),
            ];

            foreach ($attributes as $attr) {
                $data[$attr] = $node->attr($attr);
            }

            return $data;
        });
    }

    /**
     * Set the image resolver
     *
     * @param callable $resolver resolver
     * @return void
     */
    public static function setImageResolver(callable $resolver)
    {
        static::$imageResolver = $resolver;
    }

    /**
     * Resolve image instances
     *
     * @param array $ids identifier list
     * @return array
     */
    public static function resolveImage($ids = [])
    {
        $ids = !is_array($ids) ? [$ids] : $ids;

        return call_user_func(static::$imageResolver, $ids);
    }

    /**
     * Set the privileged determiner
     *
     * @param callable $determiner determiner
     * @return void
     */
    public static function setPrivilegedDeterminer(callable $determiner)
    {
        static::$privilegedDeterminer = $determiner;
    }

    /**
     * Determine if privileged
     *
     * @return bool
     */
    public function isPrivileged()
    {
        return !!call_user_func(static::$privilegedDeterminer, $this);
    }

    /**
     * Create crawler instance
     *
     * @param string $content content
     * @return Crawler
     */
    private function createCrawler($content)
    {
        return new Crawler($content);
    }

    /**
     * Get instance id for the editor
     *
     * @return string
     */
    public function getInstanceId()
    {
        return $this->instanceId;
    }

    /**
     * Get uri for custom setting
     *
     * @param string $instanceId instance identifier
     * @return string|null
     */
    public static function getInstanceSettingURI($instanceId)
    {
        return null;
    }

    /**
     * Get the file input name
     *
     * @return string
     */
    public function getFileInputName()
    {
        return $this->fileInputName;
    }

    /**
     * Get the tag input name
     *
     * @return string
     */
    public function getTagInputName()
    {
        return $this->tagInputName;
    }

    /**
     * Get the mention input name
     *
     * @return string
     */
    public function getMentionInputName()
    {
        return $this->mentionInputName;
    }

    /**
     * Get the cover input name
     *
     * @return string
     */
    public function getCoverInputName()
    {
        return $this->coverInputName;
    }

    /**
     * Get the file class name
     *
     * @return string
     */
    public function getFileClassName()
    {
        return $this->fileClassName;
    }

    /**
     * Get the image class name
     *
     * @return string
     */
    public function getImageClassName()
    {
        return $this->imageClassName;
    }

    /**
     * Get the tag class name
     *
     * @return string
     */
    public function getTagClassName()
    {
        return $this->tagClassName;
    }

    /**
     * Get the mention class name
     *
     * @return string
     */
    public function getMentionClassName()
    {
        return $this->mentionClassName;
    }

    /**
     * Get the file identifier attribute name
     *
     * @return string
     */
    public function getFileIdentifierAttrName()
    {
        return $this->fileIdentifierAttrName;
    }

    /**
     * Get the image identifier attribute name
     *
     * @return string
     */
    public function getImageIdentifierAttrName()
    {
        return $this->imageIdentifierAttrName;
    }

    /**
     * Get the mention identifier attribute name
     *
     * @return string
     */
    public function getMentionIdentifierAttrName()
    {
        return $this->mentionIdentifierAttrName;
    }
}

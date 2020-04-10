<?php
/**
 * CSSFile
 *
 * PHP version 7
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

/**
 * CSSFile
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CSSFile
{
    use AttributeTrait;
    use MinifyTrait;
    use SortTrait;
    use TargetTrait;
    use EmptyStringTrait;
    use ParameterTrait;

    /**
     * CSSFile list
     *
     * @var CSSFile[]
     */
    protected static $fileList = [];

    /**
     * The filename list for unloads.
     *
     * @var string[]
     */
    protected static $unloaded = [];

    /**
     * The filename list of this object.
     *
     * @var string[]
     */
    protected $files = [];

    /**
     * The location for html response.
     *
     * @var string
     */
    const LOCATION_OUTPUT = 'head.append';

    /**
     * The location for json response.
     * @var string
     */
    const LOCATION_ASYNC = 'async.append';

    /**
     * 주어진 위치에 해당하는 로드된 CSS파일 목록을 출력한다.
     *
     * @param bool $minified minified 파일을 출력할지 결정한다.
     * @return string
     */
    public static function output($minified = false)
    {
        $output = '';

        if (!$list = array_get(static::$fileList, static::LOCATION_OUTPUT)) {
            return $output;
        }

        foreach (static::getSorted(static::LOCATION_OUTPUT) as $name) {
            if (in_array($name, static::$unloaded)) {
                continue;
            }

            $item = $list[$name] ?? new static([]);

            $output .= $item->render($name, $minified);
        }

        return $output;
    }


    /**
     * 로드된 파일 목록을 반환한다.
     *
     * @param bool $minified min 파일 반환 여부
     * @return array
     */
    public static function getFileList($minified = false)
    {
        $output = [];

        if (!$list = array_get(static::$fileList, static::LOCATION_ASYNC)) {
            return $output;
        }

        foreach (static::getSorted(static::LOCATION_ASYNC) as $name) {
            if (in_array($name, static::$unloaded)) {
                continue;
            }

            $item = $list[$name] ?? new static([]);

            $output[] = $item->getFile($name, $minified);
        }

        return $output;
    }

    /**
     * 로드된 파일을 반환한다.
     *
     * @param string $file     파일경로
     * @param bool   $minified true일 경우, min파일을 반환한다.
     * @return string
     */
    protected function getFile($file, $minified = false)
    {
        return $minified && $this->minified ? $this->minified : $file;
    }


    /**
     * init 전역 메소드이며, javascript 파일의 목록을 관리하기 위해 필요한 초기 작업으로
     * file list를 설정한다.
     *
     * @param array $fileList js file의 목록
     * @return void
     */
    public static function init($fileList = [])
    {
        static::$fileList = $fileList;
    }

    /**
     * 생성자. 파일경로를 전달받는다.
     * 단 하나의 파일이나 배열형식의 다중 파일을 전달 받을 수 있다.
     *
     * @param string|string[] $files 파일경로
     */
    public function __construct($files)
    {
        foreach ((array) $files as $file) {
            $file = $this->asset($file);
            $this->files[] = $file;
        }

        // initialization
        $this->attr('type', 'text/css');
        $this->attr('rel', 'stylesheet');
        $this->attr('media', 'all');
    }

    /**
     * type
     *
     * @param string $type type
     * @return $this
     */
    public function type($type)
    {
        $this->attr('type', $type);
        return $this;
    }

    /**
     * media
     *
     * @param string $media media
     * @return $this
     */
    public function media($media)
    {
        $this->attr('media', $media);
        return $this;
    }

    /**
     * unload
     *
     * @return void
     */
    public function unload()
    {
        static::$unloaded = array_merge(static::$unloaded, $this->files);
    }

    /**
     * load this file to async list
     *
     * @return $this
     */
    public function loadAsync()
    {
        $this->loadFile(static::LOCATION_ASYNC);

        return $this;
    }

    /**
     * load this file
     *
     * @return $this
     */
    public function load()
    {
        $this->loadFile(static::LOCATION_OUTPUT);

        return $this;
    }

    /**
     * Set current files to the static variable.
     *
     * @param string $location location
     * @return void
     */
    protected function loadFile($location)
    {
        static::$fileList = array_add(static::$fileList, $location, []);

        foreach ($this->files as $file) {
            list($element, $position) = explode('.', $location);
            static::$fileList[$element][$position][$file] = $this;
        }

        $this->sort($this->files, $location);
    }

    /**
     * render
     *
     * @param string     $file     file path
     * @param bool|false $minified minified
     * @return string
     */
    public function render($file, $minified = false)
    {
        //attr
        $attr = '';
        if (count($this->attributes) > 0) {
            foreach ($this->attributes as $name => $value) {
                $attr .= ' '.$name.'="'.$value.'"';
            }
        }

        if ($minified && $this->minified !== null) {
            $file = $this->minified;
        }

        // src
        $tag = '<link href="'.$this->buildSource($file).'"'.$attr.'>'.PHP_EOL;

        // target
        if ($this->target !== null) {
            $targetTag = '<!--[if '.$this->target.']>';
            if (stripos($this->target, 'gt') === 0) {
                $targetTag .= '<!-->;';
            }
            $tag = $targetTag.$tag.'<![endif]-->';
        }
        return $tag;
    }

    /**
     * key resolver
     *
     * @param string $file file path
     * @return string
     */
    protected function resolveKey($file)
    {
        return $this->asset($file);
    }

    /**
     * asset
     *
     * @param string $file file path
     * @return string
     */
    protected function asset($file)
    {
        return asset($file);
    }
}

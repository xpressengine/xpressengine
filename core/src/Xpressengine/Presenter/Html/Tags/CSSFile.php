<?php
/**
 * CSSFile
 *
 * PHP version 5
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

use Xpressengine\Support\Sorter;

/**
 * CSSFile
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CSSFile
{
    use AttributeTrait;
    use LocatableTrait;
    use MinifyTrait;
    use SortTrait;
    use TargetTrait;
    use EmptyStringTrait;

    /**
     * @var CSSFile[] $fileList $fileList[filename] = CSSFile Instance
     */
    protected static $fileList = [];

    /**
     * @var string[] filename list
     */
    protected static $unloaded = [];

    /**
     * @var string[] 해당 인스턴스에 포함된 파일들의 파일명 목록
     */
    protected $files;

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * 주어진 위치에 해당하는 로드된 CSS파일 목록을 출력한다.
     *
     * @param string $location 출력할 파일의 위치\n
     *                         (head.append|head.prepend|body.append|body.prepend)
     * @param bool   $minified minified 파일을 출력할지 결정한다.
     *
     * @return string
     */
    public static function output($location = 'head.append', $minified = false)
    {
        $output = '';

        if (static::$sorter === null) {
            return $output;
        }

        // get files by location
        // $list is assoc array(filename => JSFile instance)
        $list = array_get(static::$fileList, $location, []);

        $sorted = static::$sorter->sort(array_diff(array_keys($list), static::$unloaded));

        array_map(
            function ($file) use ($list, &$output, $minified) {
                $fileObj = $list[$file];
                $output .= $fileObj->render($file, $minified);
            },
            $sorted
        );

        return $output;
    }


    /**
     * 로드된 파일 목록을 반환한다.
     *
     * @param string $location 파일 로드 위치
     * @param bool   $minified min 파일 반환 여부
     *
     * @return array
     */
    public static function getFileList($location = 'async.append', $minified = false)
    {
        $output = [];

        if (static::$sorter === null) {
            return $output;
        }

        // get files by location
        // $list is assoc array(filename => CSSFile instance)
        $list = array_get(static::$fileList, $location, []);

        $sorted = static::$sorter->sort(array_diff(array_keys($list), static::$unloaded));

        array_map(
            function ($file) use ($list, &$output, $minified) {
                $fileObj = $list[$file];
                $output[] = $fileObj->getFile($file, $minified);
            },
            $sorted
        );

        return $output;
    }

    /**
     * 로드된 파일을 반환한다.
     *
     * @param string $file     파일경로
     * @param bool   $minified true일 경우, min파일을 반환한다.
     *
     * @return string
     */
    protected function getFile($file, $minified = false)
    {
        if ($minified) {
            return $this->minified;
        }
        return $file;
    }


    /**
     * init 전역 메소드이며, javascript 파일의 목록을 관리하기 위해 필요한 초기 작업으로
     * sorter와 file list를 설정한다.
     *
     * @param array  $fileList js file의 목록
     * @param Sorter $sorter   우선순위 정렬을 위한 sorter
     *
     * @return void
     */
    public static function init($fileList = [], $sorter = null)
    {
        static::$sorter = $sorter === null ? new Sorter() : $sorter;
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
        $this->location = 'head.append';

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
     *
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
     *
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
     * @return CSSFile
     */
    public function loadAsync()
    {
        $this->location = 'async.append';
        return $this->load();
    }

    /**
     * load this file
     *
     * @return $this
     */
    public function load()
    {
        if ($this->loaded) {
            return $this;
        }

        if (static::$sorter === null || !static::$sorter instanceof Sorter) {
            static::$sorter = new Sorter();
        }

        $prev = null;

        foreach ((array) $this->files as $file) {
            // add file to output list
            static::$fileList = array_add(static::$fileList, $this->location, []);

            list($element, $position) = explode('.', $this->location);
            static::$fileList[$element][$position][$file] = $this;

            $added = false;

            // add before
            if (!empty($this->befores)) {
                $added = true;
                static::$sorter->add($file, Sorter::BEFORE, $this->befores);
            }

            if ($prev !== null) {
                static::$sorter->add($file, Sorter::BEFORE, $prev);
            }
            // remember prev file
            $prev = $file;

            // add after
            if (!empty($this->afters)) {
                $added = true;
                static::$sorter->add($file, Sorter::AFTER, $this->afters);
            }

            // add file to sorter
            if (!$added) {
                static::$sorter->add($file);
            }
        }

        // remove files from 'unloaded' list
        static::$unloaded = array_diff(static::$unloaded, (array) $this->files);

        // set loaded flag
        $this->loaded = true;

        return $this;
    }

    /**
     * render
     *
     * @param string     $file     file path
     * @param bool|false $minified minified
     *
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
        $tag = '<link href="'.$file.'"'.$attr.'>'.PHP_EOL;

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
     *
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
     *
     * @return string
     */
    protected function asset($file)
    {
        return asset($file);
    }
}

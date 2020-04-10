<?php
/**
 * IconFile
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
 * IconFile
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class IconFile
{
    use AttributeTrait;
    use EmptyStringTrait;

    /**
     * @var IconFile[] $fileList $fileList[] = IconFile Instance
     */
    protected static $fileList = [];

    /**
     * @var string 해당 인스턴스에 포함된 파일들의 파일명 목록
     */
    protected $file;

    /**
     * @var bool
     */
    protected $isAppleTouchIcon = false;

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * 로드된 JS파일 목록을 출력한다.
     *
     * @return string
     */
    public static function output()
    {
        $output = '';

        $list = static::$fileList;

        // output icon
        if (isset(static::$fileList['icon'])) {
            $iconObj = static::$fileList['icon'];
            $output .= $iconObj->render();
        }

        // output icon
        if (isset(static::$fileList['apple-touch-icon'])) {
            $iconObj = static::$fileList['apple-touch-icon'];
            $output .= $iconObj->render();
        }

        // output apple-touch-icon
        if (isset(static::$fileList['apple-touch-icon-sized'])) {
            foreach (static::$fileList['apple-touch-icon-sized'] as $size => $iconObj) {
                $output .= $iconObj->render();
            }
        }

        return $output;
    }

    /**
     * init 전역 메소드이며, javascript 파일의 목록을 관리하기 위해 필요한 초기 작업으로
     * sorter와 file list를 설정한다.
     *
     * @param array $fileList js file의 목록
     *
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
     * @param string $file 파일경로
     */
    public function __construct($file)
    {
        $file = $this->asset($file);
        $this->file = $file;

        // initialization
        $this->attr('rel', 'shortcut icon');
        $this->attr('type', 'image/x-icon');
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
     * apple touch icon
     *
     * @return $this
     */
    public function appleTouchIcon()
    {
        $this->isAppleTouchIcon = true;
        $this->attr('rel', 'apple-touch-icon');
        return $this;
    }

    /**
     * sizes
     *
     * @param string $size size
     *
     * @return $this
     */
    public function sizes($size)
    {
        if ($this->isAppleTouchIcon === false) {
            //TODO:throw exception!!
        }
        $this->attr('sizes', $size);
        return $this;
    }

    /**
     * load
     *
     * @return $this
     */
    public function load()
    {
        if ($this->loaded) {
            return $this;
        }

        if ($this->isAppleTouchIcon === false) {
            static::$fileList['icon'] = $this;
        } else {
            if (isset($this->attributes['size'])) {
                array_set(static::$fileList, 'apple-touch-icon-sized.'.$this->attributes['size'], $this);
            } else {
                static::$fileList['apple-touch-icon'] = $this;
            }
        }

        // set loaded flag
        $this->loaded = true;

        return $this;
    }

    /**
     * render
     *
     * @return string
     */
    public function render()
    {

        if ($this->isAppleTouchIcon) {
            unset($this->attributes['type']);
        }

        //attr
        $attr = '';
        if (count($this->attributes) > 0) {
            foreach ($this->attributes as $name => $value) {
                $attr .= ' '.$name.'="'.$value.'"';
            }
        }

        // src
        $tag = '<link'.$attr.' href="'.$this->file.'">'.PHP_EOL;

        return $tag;
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

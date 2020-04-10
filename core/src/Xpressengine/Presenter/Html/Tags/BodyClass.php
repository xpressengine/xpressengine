<?php
/**
 * BodyClass
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
 * BodyClass
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class BodyClass
{
    use EmptyStringTrait;

    /**
     * @var Meta[] $classes $tags[$attributeName][$attributeValue] = $content;
     */
    protected static $classes = [];

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @var string
     */
    protected $class;

    /**
     * output
     *
     * @return string
     */
    public static function output()
    {
        return implode(' ', static::$classes);
    }

    /**
     * init 전역 메소드이며, meta 태그 목록을 관리하기 위해 필요한 초기 작업으로
     * tag list를 설정한다.
     *
     * @param array $classes tag list
     *
     * @return void
     */
    public static function init($classes = [])
    {
        static::$classes = $classes;
    }

    /**
     * 생성자. 파일경로를 전달받는다.
     * 단 하나의 파일이나 배열형식의 다중 파일을 전달 받을 수 있다.
     *
     * @param string $class class name
     */
    public function __construct($class)
    {
        $this->class = $class;
        $this->load();
    }

    /**
     * unload
     *
     * @return $this
     */
    public function unload()
    {
        static::$classes = array_diff(static::$classes, [$this->class]);

        $this->loaded = false;

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

        if (!in_array($this->class, static::$classes)) {
            static::$classes[] = $this->class;
        }

        $this->loaded = true;

        return $this;
    }
}

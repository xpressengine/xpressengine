<?php
/**
 * Preload
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
 * Preload
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Preload
{
    use EmptyStringTrait;
    use AttributeTrait;

    /**
     * @var Preload[] $tags $tags[$attributeName] = $attributeValue;
     */
    protected static $tags = [];

    /**
     * @var bool
     */
    protected $loaded = false;
    /**
     * output
     *
     * @return string
     */
    public static function output()
    {
        $output = '';

        foreach (static::$tags as $attributes) {
            $tag = '<link';
            foreach ($attributes as $name => $value) {
                $tag .= ' '.$name.'="'.$value.'"';
            }
            $output .= $tag.'>'.PHP_EOL;
        }
        return $output;
    }

    /**
     * init 전역 메소드이며, preload 태그 목록을 관리하기 위해 필요한 초기 작업으로
     * tag list를 설정한다.
     *
     * @param array $tags tag list
     *
     * @return void
     */
    public static function init($tags = [])
    {
        static::$tags = $tags;
    }

    /**
     * Preload constructor.
     */
    public function __construct()
    {
    }

    /**
     * name
     *
     * @param string $value value
     *
     * @return $this
     */
    public function as($value)
    {
        $this->attr('as', $value);
        return $this;
    }

    /**
     * type
     *
     * @param string $value value
     *
     * @return $this
     */
    public function type($value)
    {
        $this->attr('type', $value);
        return $this;
    }

    /**
     * crossorigin
     *
     * @param string $value value
     *
     * @return $this
     */
    public function crossorigin($value = 'anonymous')
    {
        $this->attr('crossorigin', $value);
        return $this;
    }


    /**
     * media
     *
     * @param string $value value
     *
     * @return $this
     */
    public function media($value)
    {
        $this->attr('media', $value);
        return $this;
    }

    /**
     * href
     *
     * @param string $value value
     *
     * @return $this
     */
    public function href($value)
    {
        $this->attr('href', $value);
        return $this;
    }

    /**
     * load
     *
     * @return $this|void
     */
    public function load()
    {
        if ($this->loaded) {
            return $this;
        }

        if (count($this->attributes) === 0) {
            return;
        }

        $this->attr('rel', 'preload');
        static::$tags[] = $this->attributes;

        $this->loaded = true;

        return $this;
    }
}

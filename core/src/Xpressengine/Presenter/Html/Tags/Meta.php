<?php
/**
 * Meta
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
 * Meta
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Meta
{
    use EmptyStringTrait;

    /**
     * @var Meta[] $tags $tags[$attributeName][$attributeValue] = $content;
     */
    protected static $tags = [];

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * @var int|null
     */
    protected $alias;

    /**
     * @var string[] alias list
     */
    protected static $unloaded = [];

    /**
     * @var int
     */
    protected static $aliasSeq = 1;

    /**
     * output
     *
     * @return string
     */
    public static function output()
    {
        $output = '';

        foreach (static::$tags as $alias => $attributes) {
            if (in_array($alias, static::$unloaded)) {
                continue;
            }

            $tag = '<meta';
            foreach ($attributes as $name => $value) {
                $tag .= ' '.$name.'="'.$value.'"';
            }
            $output .= $tag.'>'.PHP_EOL;
        }
        return $output;
    }

    /**
     * init 전역 메소드이며, meta 태그 목록을 관리하기 위해 필요한 초기 작업으로
     * tag list를 설정한다.
     *
     * @param array $tags tag list
     *
     * @return void
     */
    public static function init($tags = [])
    {
        static::$tags = $tags;
        static::$unloaded = [];
    }

    /**
     * Meta constructor.
     *
     * @param string|null $alias alias
     */
    public function __construct($alias = null)
    {
        if ($alias === null) {
            $alias = static::$aliasSeq++;
        }
        $this->alias = $alias;
    }

    /**
     * name
     *
     * @param string $value value
     *
     * @return $this
     */
    public function name($value)
    {
        $this->addAttribute('name', $value);
        return $this;
    }

    /**
     * property
     *
     * @param string $value value
     *
     * @return $this
     */
    public function property($value)
    {
        $this->addAttribute('property', $value);
        return $this;
    }

    /**
     * content
     *
     * @param string $content content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->addAttribute('content', $content);
        return $this;
    }

    /**
     * character set
     *
     * @param string $charset character set
     *
     * @return $this
     */
    public function charset($charset)
    {
        $this->addAttribute('charset', $charset);
        return $this;
    }

    /**
     * httpEquiv
     *
     * @param string $httpEquiv httpEquiv
     *
     * @return $this
     */
    public function httpEquiv($httpEquiv)
    {
        $this->addAttribute('http-equiv', $httpEquiv);
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

        static::$tags[$this->alias] = $this->attributes;

        unset(static::$unloaded[$this->alias]);

        $this->loaded = true;

        return $this;
    }

    /**
     * unload
     *
     * @return void
     */
    public function unload()
    {
        array_push(static::$unloaded, $this->alias);
    }

    /**
     * add attribute
     *
     * @param string $attrName attribute name
     * @param string $value    value
     *
     * @return void
     */
    private function addAttribute($attrName, $value)
    {
        $this->attributes[$attrName] = $value;
    }
}

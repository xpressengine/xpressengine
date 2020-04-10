<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\UIObject;

/**
 * Element class
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Element
{
    protected $name;

    protected $attributes = [];

    protected $children = [];

    protected $empty = false;

    protected static $emptyElements = [
        'area',
        'base',
        'br',
        'col',
        'embed',
        'hr',
        'img',
        'input',
        'keygen',
        'link',
        'meta',
        'param',
        'source',
        'track',
        'wbr'
    ];

    /**
     * Element constructor.
     *
     * @param string $name       element name
     * @param array  $attributes attributes of element
     * @param array  $children   children of element
     */
    public function __construct($name, array $attributes = [], array $children = [])
    {
        $this->name = $name;
        if (in_array($name, static::$emptyElements)) {
            $this->empty = true;
        }
        $this->attributes = $attributes;
        $this->children = $children;
    }

    /**
     * add attribute
     *
     * @param string $key    attribute key
     * @param string $value  value of attribute
     * @param bool   $append whether append a value or set a value
     *
     * @return $this
     */
    public function attr($key, $value, $append = false)
    {
        if ($append) {
            $this->resolveAttribute($key);
            if (!in_array($value, $this->attributes[$key])) {
                $this->attributes[$key][] = $value;
            }
        } else {
            $this->attributes[$key] = [$value];
        }
        return $this;
    }

    /**
     * remove attribute
     *
     * @param string $key attribute key
     *
     * @return $this
     */
    public function removeAttr($key)
    {
        array_forget($this->attributes, $key);
        return $this;
    }

    /**
     * add class
     *
     * @param string $class class name
     *
     * @return $this
     */
    public function addClass($class)
    {
        foreach ((array) $class as $c) {
            $this->attr('class', $c, true);
        }
        return $this;
    }

    /**
     * remove class
     *
     * @param string $class class name
     *
     * @return $this
     */
    public function removeClass($class)
    {
        $this->resolveAttribute('class');

        if (in_array($class, $this->attributes['class'])) {
            unset($this->attributes['class'][array_search($class, $this->attributes['class'])]);
        }
        return $this;
    }

    /**
     * append child
     *
     * @param string|static $el child element
     *
     * @return $this
     */
    public function append($el)
    {
        if (!is_array($el)) {
            $el = [$el];
        }
        foreach ($el as $e) {
            array_push($this->children, $e);
        }
        return $this;
    }

    /**
     * prepend child
     *
     * @param string|static $el child element
     *
     * @return $this
     */
    public function prepend($el)
    {
        foreach ((array) $el as $e) {
            array_unshift($this->children, $e);
        }
        return $this;
    }

    /**
     * set html or text to sole child
     *
     * @param string $html html
     *
     * @return $this
     */
    public function html($html)
    {
        $this->children = [$html];
        return $this;
    }

    /**
     * render
     *
     * @return string
     */
    public function render()
    {
        $name = $this->name;
        // attributes
        $attrs = [];
        foreach ($this->attributes as $key => $value) {
            if (is_array($value)) {
                $value = implode(' ', $value);
            }
            $attrs[] = "$key=\"$value\"";
        }
        $attrs = implode(' ', $attrs);
        $attrs = $attrs ? ' '.$attrs : '';

        $start = "<$name$attrs>";
        $body = "";
        $end = "</$name>";

        if ($this->empty) {
            $body = "";
            $end = "";
        } else {
            foreach ($this->children as $child) {
                $body .= (string) $child;
            }
        }

        return $start.$body.$end;
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->render();
        } catch (\Exception $e) {
            return 'error: '.$e->getMessage();
        }
    }

    /**
     * transform attribute to array format
     *
     * @param string $key attribute key
     *
     * @return void
     */
    protected function resolveAttribute($key)
    {
        $this->attributes = array_add($this->attributes, $key, []);

        if (is_string($this->attributes[$key])) {
            $this->attributes[$key] = [$this->attributes[$key]];
        }
    }
}

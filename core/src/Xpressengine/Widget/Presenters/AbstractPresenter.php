<?php
/**
 * AbstractPresenter.php
 *
 * PHP version 7
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Widget\Presenters;

use Illuminate\Support\Arr;
use Xpressengine\UIObject\Element;

/**
 * Abstract class AbstractPresenter
 *
 * @category    Widget
 * @package     Xpressengine\Widget
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class AbstractPresenter implements PresenterInterface
{
    /**
     * The name of presenter
     *
     * @var string
     */
    const NAME = '';

    /**
     * The number of columns supported by the presenter
     *
     * @var int
     */
    const COLS = 0;

    /**
     * @var boolean
     */
    const SUPPORT_CONTAINER = false;

    /**
     * The data for contents
     *
     * @var @array
     */
    protected $data;

    /**
     * The options of presenter
     *
     * @var array
     */
    protected $options = [];

    /**
     * @var bool
     */
    protected $supportContainer = false;

    /**
     * The widget code generator
     *
     * @var callable
     */
    protected static $generator;

    /**
     * AbstractPresenter constructor.
     *
     * @param array $data    contents data
     * @param array $options options
     */
    public function __construct(array $data, array $options = [])
    {
        $this->data = $data;
        $this->options = $options;
    }

    /**
     * Get the string contents of the presenter.
     *
     * @return string
     */
    public function render(): string
    {
        $content = '';
        foreach ($this->data as $row) {
            $content .= $this->getRow($row);
        }

        return $this->getContainerWrapper($content);
    }

    /**
     * Get HTML wrapper for content container.
     *
     * @param string $content content string
     * @return string
     */
    protected function getContainerWrapper(string $content): string
    {
        return $content;
    }

    /**
     * Get a row contents
     *
     * @param array $data row data
     * @return string
     */
    protected function getRow(array $data): string
    {
        $cols = Arr::get($data, 'cols', $data);
        $options = Arr::get($data, 'options', []);

        $content = '';

        foreach ($cols as $col) {
            if (empty($col)) {
                continue;
            }

            $content .= $this->getColumn($col);
        }

        return $this->getRowWrapper($content, $options);
    }

    /**
     * Get HTML wrapper for row contents
     *
     * @param string $content row contents
     * @param array $options
     * @return string
     */
    abstract protected function getRowWrapper(string $content, array $options): string;

    /**
     * Get a column contents
     *
     * @param array $data column data
     * @return string
     */
    protected function getColumn(array $data): string
    {
        $options = Arr::get($data, 'options', []);
        $content = '';

        if (count($rows = Arr::get($data, 'rows', [])) > 0) {
            foreach ($rows as $row) {
                $content .= $this->getRow($row);
            }
        } else {
            foreach (Arr::get($data, 'widgets', []) as $widget) {
                $activate = Arr::get($widget['@attributes'], 'activate', 'activate');

                if ($activate === 'activate') {
                    $content .= $this->getWidget($widget);
                }
            }
        }

        return $this->getColumnWrapper($content, $data['grid'], $options);
    }

    /**
     * Get HTML wrapper for column contents
     *
     * @param string $content column content
     * @param array $grid column grid data
     * @param array $options
     * @return string
     */
    abstract protected function getColumnWrapper(string $content, array $grid = [], array $options = []): string;

    /**
     * set element's attributes
     *
     * @param Element $element
     * @param array $attrs
     */
    protected function setElementAttributes(Element $element, array $attrs)
    {
        foreach ($attrs as $key => $value) {
            switch ($key) {
                case 'class':
                    $element->addClass($value);
                    break;

                case 'style':
                    $style = null;

                    if (is_string($value)) {
                        $style = $value;
                    }
                    else if (is_array($value)) {
                        foreach ($value as $styleKey => $styleValue) {
                            $style = $style . "$styleKey: $styleValue; ";
                        }
                    }

                    if ($style !== null) {
                        $element->attr('style', $style);
                    }

                    break;

                default:
                    foreach ((array) $value as $val) {
                        $element->attr($key, $val);
                    }

                    break;
            }
        }
    }

    /**
     * Get a widget contents
     *
     * @param array $raw widget data
     * @return string
     */
    protected function getWidget(array $raw): string
    {
        list($keys, $values) = Arr::divide(Arr::get($raw, '@attributes', []));
        array_walk($keys, function (&$item) {
            $item = '@'. $item;
        });

        $attributes = array_combine($keys, $values);

        if (array_key_exists('@title', $attributes)) {
            $attributes['@title'] = htmlentities($attributes['@title']);
        }

        $info = Arr::except($raw, '@attributes');

        foreach ($info as $key => $value) {
            if (is_string($value) === true) {
                $info[$key] = htmlentities($value);
            }
        }

        return call_user_func(
            static::$generator,
            Arr::get($raw, '@attributes.id'),
            array_merge($info, $attributes)
        );
    }

    /**
     * Set options for the presenter
     *
     * @param array $options options
     * @return $this
     */
    public function setOptions(array $options): AbstractPresenter
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Set the widget code generator
     *
     * @param callable $generator widget code generator
     * @return void
     */
    public static function setWidgetCodeGenerator(callable $generator)
    {
        static::$generator = $generator;
    }

    /**
     * Is it a column.
     *
     * @param array $data
     * @return bool
     */
    protected function isColumn(array $data): bool
    {
        return array_key_exists('grid', $data);
    }
}

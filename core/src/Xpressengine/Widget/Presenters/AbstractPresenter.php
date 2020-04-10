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
    public function __construct($data, $options = [])
    {
        $this->data = $data;
    }

    /**
     * Get the string contents of the presenter.
     *
     * @return string
     */
    public function render()
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
    protected function getContainerWrapper($content)
    {
        return $content;
    }

    /**
     * Get a row contents
     *
     * @param array $data row data
     * @return string
     */
    protected function getRow($data)
    {
        $content = '';
        foreach ($data as $col) {
            $content .= $this->getColumn($col);
        }

        return $this->getRowWrapper($content);
    }

    /**
     * Get HTML wrapper for row contents
     *
     * @param string $content row contents
     * @return string
     */
    abstract protected function getRowWrapper($content);

    /**
     * Get a column contents
     *
     * @param array $data column data
     * @return string
     */
    protected function getColumn($data)
    {
        $content = '';

        if (count($rows = Arr::get($data, 'rows', [])) > 0) {
            foreach ($rows as $row) {
                $content .= $this->getRow($row);
            }
        } else {
            foreach (Arr::get($data, 'widgets', []) as $widget) {
                $content .= $this->getWidget($widget);
            }
        }

        return $this->getColumnWrapper($content, $data['grid']);
    }

    /**
     * Get HTML wrapper for column contents
     *
     * @param string $content column content
     * @param array  $grid    column grid data
     * @return string
     */
    abstract protected function getColumnWrapper($content, $grid = []);

    /**
     * Get a widget contents
     *
     * @param array $raw widget data
     * @return string
     */
    protected function getWidget($raw)
    {
        list($keys, $values) = Arr::divide(Arr::get($raw, '@attributes', []));
        array_walk($keys, function (&$item) {
            $item = '@'. $item;
        });
        return call_user_func(
            static::$generator,
            Arr::get($raw, '@attributes.id'),
            array_merge(Arr::except($raw, '@attributes'), array_combine($keys, $values))
        );
    }

    /**
     * Set options for the presenter
     *
     * @param array $options options
     * @return $this
     */
    public function setOptions(array $options)
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
     * Get the widget code generator
     *
     * @return callable
     */
    public static function getWidgetCodeGenerator()
    {
        return static::$generator;
    }
}

<?php
/**
 * Html
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

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Support\Sorter;

/**
 * Html
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Html
{
    use LocatableTrait;
    use EmptyStringTrait;
    use SortTrait;

    /**
     * Html list
     *
     * @var Html[]
     */
    protected static $htmlList = [];

    /**
     * The alias name list for unloads.
     *
     * @var string[] alias list
     */
    protected static $unloaded = [];

    /**
     * The number of sequence.
     *
     * @var int
     */
    protected static $aliasSeq = 1;

    /**
     * The name of this object.
     *
     * @var int|string
     */
    protected $alias;

    /**
     * The content of this object.
     *
     * @var string|callable
     */
    protected $content;

    /**
     * 주어진 위치에 해당하는 로드된 JS파일 목록을 출력한다.
     *
     * @param string $location 출력할 파일의 위치 (head.append|head.prepend|body.append|body.prepend)
     * @return string
     */
    public static function output($location)
    {
        $output = '';

        if (!$list = array_get(static::$htmlList, $location)) {
            return $output;
        }

        foreach (static::getSorted($location) as $name) {
            if (in_array($name, static::$unloaded) || !isset($list[$name])) {
                continue;
            }

            if (is_string($name)) {
                $output .= "<!-- $name -->".PHP_EOL;
            }
            $output .= $list[$name]->render();
        }

        return $output;
    }

    /**
     * init 전역 메소드이며, javascript 파일의 목록을 관리하기 위해 필요한 초기 작업으로
     * html list를 설정한다.
     *
     * @param array $htmlList html content 의 목록
     * @return void
     */
    public static function init($htmlList = [])
    {
        static::$htmlList = $htmlList;
    }

    /**
     * 생성자. 태그 별칭을 전달받는다.
     *
     * @param string|null $alias 파일경로
     */
    public function __construct($alias = null)
    {
        if ($alias === null) {
            $alias = static::$aliasSeq++;
        }
        $this->alias = $alias;
    }

    /**
     * content
     *
     * @param string $content content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * load
     *
     * @return $this
     */
    public function load()
    {
        $location = $this->getLocations()[0];
        static::$htmlList = array_add(static::$htmlList, $location, []);

        list($element, $position) = explode('.', $location);
        static::$htmlList[$element][$position][$this->alias] = $this;

        $this->sort($this->alias, $location);

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
     * render
     *
     * @return string
     */
    public function render()
    {
        if (is_callable($this->content)) {
            return call_user_func($this->content).PHP_EOL;
        } elseif ($this->content instanceof Renderable) {
            return $this->content->render().PHP_EOL;
        } else {
            return (string) $this->content.PHP_EOL;
        }
    }

    /**
     * key resolver
     *
     * @param string $alias alias
     * @return string
     */
    protected function resolveKey($alias)
    {
        return $alias;
    }
}

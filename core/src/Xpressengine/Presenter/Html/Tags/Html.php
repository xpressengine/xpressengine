<?php
/**
 * Html
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

use Illuminate\Contracts\Support\Renderable;
use Xpressengine\Support\Sorter;

/**
 * Html
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Html
{
    use LocatableTrait;
    use EmptyStringTrait;
    use SortTrait;

    /**
     * @var Html[] $htmlList 3차원 배열의 형태(location x position x filename)
     */
    protected static $htmlList = [];

    /**
     * @var string[] alias list
     */
    protected static $unloaded = [];

    /**
     * @var int
     */
    protected static $aliasSeq = 1;

    /**
     * @var string 해당 인스턴스에 포함된 파일들의 파일명 목록
     */
    protected $html;

    /**
     * @var int|null
     */
    protected $alias;

    /**
     * @var string|callable
     */
    protected $content;

    /**
     * @var bool
     */
    protected $loaded = false;

    /**
     * 주어진 위치에 해당하는 로드된 JS파일 목록을 출력한다.
     *
     * @param string $location 출력할 파일의 위치 (head.append|head.prepend|body.append|body.prepend)
     *
     * @return string
     */
    public static function output($location)
    {
        $output = '';

        if (static::$sorter === null) {
            return $output;
        }

        // get files by location
        // $list is assoc array(filename => Html instance)
        $list = array_get(static::$htmlList, $location, []);

        $sorted = static::$sorter->sort(array_diff(array_keys($list), static::$unloaded));

        array_map(
            function ($alias) use ($list, &$output) {
                $htmlObj = $list[$alias];
                if (is_string($alias)) {
                    $output .= "<!-- $alias -->".PHP_EOL;
                }
                $output .= $htmlObj->render();
            },
            $sorted
        );

        return $output;
    }

    /**
     * init 전역 메소드이며, javascript 파일의 목록을 관리하기 위해 필요한 초기 작업으로
     * sorter와 file list를 설정한다.
     *
     * @param array  $htmlList js file의 목록
     * @param Sorter $sorter   우선순위 정렬을 위한 sorter
     *
     * @return void
     */
    public static function init($htmlList = [], $sorter = null)
    {
        static::$sorter = $sorter === null ? new Sorter() : $sorter;
        static::$htmlList = $htmlList;
    }

    /**
     * 생성자. 태그 별칭을 전달받는다.
     *
     * @param string|array|null $alias 파일경로
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
     *
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
        if ($this->loaded) {
            return $this;
        }

        if (static::$sorter === null || !static::$sorter instanceof Sorter) {
            static::$sorter = new Sorter();
        }

        // add file to output list
        static::$htmlList = array_add(static::$htmlList, $this->location, []);

        list($element, $position) = explode('.', $this->location);
        static::$htmlList[$element][$position][$this->alias] = $this;

        $added = false;

        // add before
        if (!empty($this->befores)) {
            $added = true;
            static::$sorter->add($this->alias, Sorter::BEFORE, $this->befores);
        }

        // add after
        if (!empty($this->afters)) {
            $added = true;
            static::$sorter->add($this->alias, Sorter::AFTER, $this->afters);
        }

        // add alias to sorter
        if (!$added) {
            static::$sorter->add($this->alias);
        }

        // remove alias from 'unloaded' list
        unset(static::$unloaded[$this->alias]);

        // set loaded flag
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
     *
     * @return string
     */
    protected function resolveKey($alias)
    {
        return $alias;
    }
}

<?php
/**
 * AbstractUIObject class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    UIObejct
 * @package     Xpressengine\UIObejct
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\UIObject;

use Closure;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\View\Expression;
use PhpQuery\PhpQuery;
use PhpQuery\PhpQueryObject;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * 이 클래스는 Xpressengine에서 UIObject를 구현할 때 필요한 추상클래스이다. UIObject를 Xpressengine에 등록하려면
 * 이 추상 클래스를 상속받은 클래스를 작성하여야 한다.
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractUIObject implements Renderable, ComponentInterface
{
    use ComponentTrait;

    public static $sequence = 0;

    /**
     * @var Closure|null UIObject가 출력(render)될 때, callback이 지정돼 있을 경우, 이 callback을 한번 실행한 후 출력된다.
     *                   만약 UIObject의 출력에 변화를 주고 싶을 경우, callback을 사용하여 출력되는 값을 변경할 수 있다.
     *                   이 callback은 파라메터로 출력될 html(PhpQueryObject)을 전달 받는다. html을 변경하면 변경한 html이 출력된다.
     */
    protected $callback;

    /**
     * @var array UIObject 생성시 첫번째 인자로 받는 파라메터
     */
    protected $arguments;

    /**
     * @var string UIObject가 기본적으로 가지고 있는 html
     */
    protected $template;

    /**
     * @var PhpQueryObject|null 출력될 html의 PhpQueryObject
     */
    protected $markup;

    /**
     * get sequence number
     *
     * @return int
     */
    public static function seq()
    {
        return ++self::$sequence;
    }

    /**
     * 생성자. 모든 UIObject는 동일한 방식으로 생성되어야 한다.
     *
     * @param mixed   $args     UIObject의 출력에 필요한 변수
     * @param Closure $callback UIObject가 출력될 때 실행될 callback
     */
    final public function __construct($args = [], $callback = null)
    {
        $this->callback = $callback;
        $this->arguments = $args;
    }

    /**
     * UIObject가 출력될 때 호출되는 메소드이다.
     *
     * @return string
     */
    public function render()
    {
        if (is_callable($this->callback)) {
            $callback = $this->callback;

            if ($this->markup === null) {
                PhpQuery::newDocument();
                $this->markup = PhpQuery::pq($this->template);
            }
            $callback($this->markup);
        }

        $viewStr = $this->markup === null ? $this->template : (string)$this->markup;
        return new Expression($viewStr);
    }

    /**
     * UIObject는 string 타입으로 캐스팅될 수 있으며, 이 때에 render 메소드가 사용된다.
     *
     * @return string
     */
    public function __toString()
    {
        try {
            $string = (string) $this->render();
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        return $string;
    }
}

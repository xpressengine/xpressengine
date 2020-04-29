<?php
/**
 * AbstractUIObject class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    UIObejct
 * @package     Xpressengine\UIObejct
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\UIObject;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\HtmlString;
use Xpressengine\Plugin\ComponentInterface;
use Xpressengine\Plugin\ComponentTrait;

/**
 * 이 클래스는 Xpressengine에서 UIObject를 구현할 때 필요한 추상클래스이다. UIObject를 Xpressengine에 등록하려면
 * 이 추상 클래스를 상속받은 클래스를 작성하여야 한다.
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
abstract class AbstractUIObject implements Renderable, ComponentInterface
{
    use ComponentTrait;

    public static $sequence = 0;

    /**
     * @var array UIObject 생성시 첫번째 인자로 받는 파라메터
     */
    protected $arguments;

    /**
     * @var string UIObject가 기본적으로 가지고 있는 html
     */
    protected $template;

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
     * @param mixed $args UIObject의 출력에 필요한 변수
     */
    final public function __construct($args = [])
    {
        $this->arguments = $args;
    }

    /**
     * UIObject가 출력될 때 호출되는 메소드이다.
     *
     * @return string
     */
    public function render()
    {
        return new HtmlString($this->template);
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

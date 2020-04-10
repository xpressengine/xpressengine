<?php
/**
 * Advisor class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Interception;

/**
 * interception에서 사용되는 advisor를 정의하는 클래스이다. advisor는 세가지 정보로 구성된다. 그 세가지 정보는 advisor의 이름,
 * advisor가 실행될 pointCut, 그리고 이 advisor가 실행될 때 실제로 작동하는 closure인 advice이다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Advisor
{

    /**
     * @var string 이 advisor의 이름
     */
    protected $name;
    /**
     * @var string[] 이 advisor가 실행될 위치를 지정하는 pointcut
     */
    protected $pointCut;

    /**
     * @var \Closure 이 advisor가 실행될 때 실제로 작동하게 되는 closure
     */
    protected $advice;

    /**
     * 생성자.
     *
     * @param string          $name     advisor's name
     * @param string|string[] $pointCut advisor's pointcut
     * @param \Closure        $advice   advisor's advice
     */
    public function __construct($name, $pointCut, $advice)
    {
        $this->name = $name;
        $this->pointCut = (array) $pointCut;
        $this->advice = $advice;
    }

    /**
     * 이 advisor의 advice를 반환한다.
     *
     * @return \Closure
     */
    public function getAdvice()
    {
        return $this->advice;
    }

    /**
     * 이 advisor의 advice를 주어진 값으로 지정한다.
     *
     * @param \Closure $advice 지정하려는 advice
     *
     * @return void
     */
    public function setAdvice($advice)
    {
        $this->advice = $advice;
    }

    /**
     * 이 advisor의 name을 반환한다.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 이 advisor의 name을 주어진 값으로 지정한다.
     *
     * @param string $name 지정하려는 name
     *
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string[]
     */
    public function getPointCut()
    {
        return $this->pointCut;
    }

    /**
     * 이 advisor의 pointcut을 지정한다.
     *
     * @param string|string[] $pointCut 지정하려는 pointcut
     *
     * @return void
     */
    public function setPointCut($pointCut)
    {
        $this->pointCut = (array) $pointCut;
    }
}

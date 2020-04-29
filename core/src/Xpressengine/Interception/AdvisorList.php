<?php
/**
 * AdvisorList class. This file is part of the Xpressengine package.
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
 * interception에서 사용되는 advisor의 리스트를 정의하는 클래스이다. target object의 메소드가 실행될 때,
 * Proxy가 실행되고, 이때 AdvisorStore는 실행될 메소드에 지정된 advisor를 선별한 후 그 목록을 이 클래스의 형식으로 Proxy에 전달한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AdvisorList
{

    /**
     * 정렬 완료된 advisor name의 목록. 이 클래스는 next 메소드가 실행될 때마다 이 목록에 존재하는 advisor를 순서대로 꺼내서 반환한다.
     *
     * @var string[]
     */
    protected $sortedAdvisorList = null;

    /**
     * advisor의 목록 레퍼런스, 이 클래스는 next 메소드가 실행될 때, sortedAdvisorList에서 반환할 advisor의 name을 조회한 후,
     * 이 배열에 등록돼 있는 실제 Advisor 인스턴스를 반환한다.
     *
     * @var Advisor[]
     */
    protected $advisorArr = null;

    /**
     * 생성자. 이 클래스는 생성될 때, 주어진 정렬된 advisor name 목록과, advisor 인스턴스 배열의 레퍼런스를 지정한다.
     *
     * @param string[]  $sortedAdvisorList 정렬된 advisor의 name 목록
     * @param Advisor[] $advisorArr        advisor 인스턴스 배열
     */
    public function __construct($sortedAdvisorList, &$advisorArr)
    {
        $this->advisorArr        = $advisorArr;
        $this->sortedAdvisorList = $sortedAdvisorList;
    }

    /**
     * 이 메소드가 실행될 때마다 Advisor를 순서대로 반환한다.
     *
     * @return Advisor
     */
    public function next()
    {
        $next = array_shift($this->sortedAdvisorList);

        if ($next) {
            return $this->advisorArr[$next];
        } else {
            return null;
        }
    }

    /**
     * 모든 advisor의 목록을 반환한다.
     *
     * @return \string[]
     */
    public function getAll()
    {
        return $this->sortedAdvisorList;
    }
}

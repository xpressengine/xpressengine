<?php
/**
 * AdvisorCollection class. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Interception;

use Xpressengine\Interception\Exceptions\AdvisorNameAlreadyExistsException;
use Xpressengine\Support\Sorter;

/**
 * 이 클래스는 Xpressengine에서 등록된 모든 advisor를 관리하는 클래스이다. 생성된 advisor를 저장하고
 * 특정 pointcut에 해당하는 advisor들의 정렬된 목록을 반환하는 역할을 한다.
 *
 * @category    Interception
 * @package     Xpressengine\Interception
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class AdvisorCollection
{

    /**
     * @var Advisor[] 추가된 advisor들의 목록(인스턴스 목록)
     */
    protected $advisorArr = [];

    /**
     * @var string[] 추가된 advisor name의 목록, 이 목록은 point cut을 정렬돼 있다.
     */
    protected $advisorMap = null;


    /**
     * 타겟 오브젝트의 alias, 타겟 오브젝트의 긴 class name을 간략하게 사용할 수 있도록 alias를 등록할 수 있다.
     *
     * @var array
     */
    protected $aliases;

    protected $sorted = [];

    /**
     * 생성자.
     *
     * @param array $aliases 타겟 오브젝트의 alias 목록
     */
    public function __construct($aliases = [])
    {
        $this->aliases = $aliases;
        $this->advisorMap = new \stdClass();
        $this->sorter = new Sorter();
    }

    /**
     * advisor를 추가한다.
     *
     * @param Advisor $advisor  추가하려는 advisor
     * @param null    $relation 추가하려는 advisor의 before, after 관계에 있는 advisor 목록. 아래와 같은 형식이 될 수 있다.
     *                          ```
     *                          ['before'=>'advisor1', 'after'=>['advisor2','advisor3']]
     *                          ```
     *
     * @return void
     */
    public function put(Advisor $advisor, $relation = null)
    {
        $name = $advisor->getName();
        $pointCutStrList = $advisor->getPointCut();

        // add advisor
        if (array_key_exists($name, $this->advisorArr)) {
            throw new AdvisorNameAlreadyExistsException(['name' => $name]);
        }

        $this->advisorArr[$name] = $advisor;

        foreach ($pointCutStrList as $pointCutStr) {
            list($class, $method) = explode('@', trim($pointCutStr, '\\'));

            if (isset($this->aliases[$class])) {
                //$pointCutStr = $this->aliases[$class].'@'.$method;
                $class = $this->aliases[$class];
            }

            $box = $this->getPointCutBox($class, $method);
            $box->advisorArr[] = $name;
        }

        // add relation
        $added = false;
        if (isset($relation['before']) && $relation['before'] !== null) {
            $this->sorter->add($name, Sorter::BEFORE, $relation['before']);
            $added = true;
        }
        if (isset($relation['after']) && $relation['after'] !== null) {
            $this->sorter->add($name, Sorter::AFTER, $relation['after']);
            $added = true;
        }

        if (!$added) {
            $this->sorter->add($name);
        }
    }


    /**
     * 주어진 pointcut에 해당하는 advisor 목록을 반환한다.
     *
     * @param string $pointCutStr pointcut를 지정하는 문자열이다. pointcut은 '{CLASS명}@{METHOD명}'의 형식이어야 한다.
     *
     * @return AdvisorList
     */
    public function getAdvisorList($pointCutStr)
    {
        list($class, $method) = explode('@', $pointCutStr);

        $box = $this->getPointCutBox($class, $method);

        if (!isset($this->sorted[$pointCutStr])) {
            $this->sorted[$pointCutStr] = $this->sorter->sort($box->advisorArr);
        }

        return new AdvisorList($this->sorted[$pointCutStr], $this->advisorArr);
    }

    /**
     * 주어진 PointCut(class, method)에 해당하는 advisor들의 정보를 가지는 box(리스트)를 반환한다.
     *
     * @param string $class  pointcut의 class명
     * @param string $method pointcut의 method명
     *
     * @return \stdClass
     */
    protected function getPointCutBox($class, $method)
    {

        if (!isset($this->advisorMap->$class)) {
            $this->advisorMap->$class = new \stdClass();
        }

        if (!isset($this->advisorMap->$class->$method)) {
            $box = $this->advisorMap->$class->$method = new \stdClass();

            $box->advisorArr = [];
            $box->sorted = false;
        }

        return $this->advisorMap->$class->$method;
    }

    /**
     * Pointcut의 class를 판단할 때 대신 사용될 수 있는 alias를 지정한다.
     *
     * @param string $alias 지정할 alias
     * @param string $class alias의 대상 원본 클래스명
     *
     * @return void
     */
    public function setAlias($alias, $class)
    {
        $this->aliases[$alias] = $class;

        if (isset($this->advisorMap->$alias)) {
            foreach ($this->advisorMap->$alias as $method => $value) {
                foreach ($value->advisorArr as $advisor) {
                    $this->advisorMap->$class->$method->advisorArr[] = $advisor;
                }
            }
            unset($this->advisorMap->$alias);
        }
    }

    /**
     * alias list를 반환한다.
     *
     * @return array
     */
    public function getAliasList()
    {
        return $this->aliases;
    }
}

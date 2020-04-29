<?php
/**
 * Sorter class. This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

/**
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Sorter
{

    /**
     * 두 key간의 순서를 지정할 때 사용한다. `A < B`일 경우, B가 먼저 실행되고 A가 실행됨을 나타낸다.
     */
    const BEFORE = '<';

    /**
     * 두 key간의 순서를 지정할 때 사용한다. `A > B`일 경우, A가 먼저 실행되고 B가 실행됨을 나타낸다.
     */
    const AFTER = '>';


    /**
     * @var array 추가된 key의 before key를 저장하는 배열이다. 아래와 같은 형식으로 저장된다.
     *            ```
     *            [
     *              '{key}' => ['beforeKey1','beforeKey2',...],
     *              ...
     *            ]
     *            ```
     */
    protected $relations = [];

    /**
     * @var array 다른 key에 의해 beforeKey로 지정된 key들의 배열이다. sort하는 과정에서 사용된다.
     */
    protected $befores = [];

    /**
     * @var array add 메소드를 통해 등록된 key의 목록이다. key로 등록될 경우 이 배열에 추가되며
     * targetKey로 등록된 key는 제외될 수 있다. sort하는 과정에서 사용된다.
     */
    protected $tails = [];

    /**
     * @var array sort가 실행됐을 경우, traversing 과정에서 거쳐간 key의 목록이다.
     */
    protected $resolved = [];

    /**
     * key들 간의 우선순위를 주입하는 메소드이다.
     * 주어진 key와 targetKey 사이에는 relation에 의해 주어진 관계를 갖는다는 것을 의미한다.
     *
     * 만약 A가 B보다 먼저 실행되어야 한다면 아래와 같이 이 메소드를 사용할 수 있다.
     * ```
     * $sorter-add('B',Sorter::BEFORE,'A');
     * // or
     * $sorter-add('A',Sorter::AFTER,'B');
     * ```
     *
     * @param string|string[] $keys       관계를 정의할 key, 복수의 key를 입력할 경우 배열로 입력할 수 있다.
     * @param string          $relation   Sorter::BEFORE('<') | Sorter::AFTER('>'). key와
     * @param string|string[] $targetKeys key와 관계를 정의할 대상 key. 복수의 key를 입력할 경우 배열로 입력할 수 있다.
     *
     * @return void
     */
    public function add($keys, $relation = null, $targetKeys = [])
    {

        foreach ((array) $keys as $key) {
            if (!in_array($key, $this->tails)) {
                $this->tails[] = $key;
            }
        }

        if ($relation === Sorter::AFTER) {
            $temp = $keys;
            $keys = $targetKeys;
            $targetKeys = $temp;
        }

        foreach ((array) $keys as $key) {
            if (!isset($this->relations[$key])) {
                $this->relations[$key] = [];
            }
            foreach ((array) $targetKeys as $before) {
                if (!in_array($before, $this->relations[$key])) {
                    $this->relations[$key][] = $before;
                }
                if (!in_array($before, $this->befores)) {
                    $this->befores[] = $before;
                }
            }
        }
    }

    /**
     * 등록된 key들의 관계를 이용하여 key 목록을 정렬하여 반환한다.
     * keyList가 주어질 경우, keyList에 지정된 key들만을 대상으로 정렬하여 반환한다.
     *
     * @param null|array $keyList 정렬의 대상이 되는 key의 목록
     *
     * @return array
     */
    public function sort($keyList = null)
    {
        $tails = $this->tails;
        $targets = $keyList === null ? $this->tails : (array) $keyList;

        if (count($targets) === 1) {
            return $targets;
        }

        $list = [];
        $this->resolved = [];

        $count = count($tails);
        $infiniteCount = 0;
        while ($tail = array_shift($tails)) {
            if (in_array($tail, $this->resolved)) {
                continue;
            }
            if (isset($this->relations[$tail])) {
                // 아직 처리해야할 before가 있다면
                if (!empty($remainBefore = array_diff($this->relations[$tail], $this->resolved))) {
                    // 존재하지 않는 before만 남았는지 검사
                    if (!empty(array_intersect($remainBefore, $tails))) {
                        array_push($tails, $tail);

                        if (++$infiniteCount > $count) {
                            throw new InfiniteRecursionException();
                        }
                        continue;
                    }
                }
            }

            // $tail이 실제 입력된 키면 $list에 저장
            if (in_array($tail, $targets)) {
                array_push($list, $tail);
            }
            array_push($this->resolved, $tail);
            $infiniteCount = 0;
            //$this->sortBefore($tail, $tails, $list);
        }

        return $list;
    }
}

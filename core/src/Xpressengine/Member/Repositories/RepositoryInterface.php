<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Member\Repositories;

use stdClass;
use Xpressengine\Member\Entities\Entity;

/**
 * 이 인터페이스는 Xpressengine Member 패키지의 Repository들이 공통으로 가지는 인터페이스이다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface RepositoryInterface
{
    /**
     * 주어진 ID에 해당하는 정보가 존재하는지의 여부를 반환한다.
     *
     * @param string $id 조회할 Entity의 id
     *
     * @return bool
     */
    public function has($id);

    /**
     * 주어진 id에 해당하는 entity를 조회하여 반환한다.
     *
     * @param string        $id   조회할 entity의 아이디
     * @param string[]|null $with entity와 함께 반환할 relation 정보
     *
     * @return null|Entity
     */
    public function find($id, $with = null);

    /**
     * 주어진 id에 해당하는 entity들의 목록을 반환한다.
     *
     * @param string[]      $ids  조회할 entity의 아이디 목록
     * @param string[]|null $with entity와 함께 반환할 relation 정보
     *
     * @return array
     */
    public function findAll($ids, $with = null);

    /**
     * 주어진 조건에 해당하는 entity 목록을 조회한다. 조회할 때에는 pagination이 적용된다.
     *
     * @param array              $wheres     검색 조건
     * @param string[]|null      $with       entity와 함께 반환할 relation 정보
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    public function fetch($wheres, $with = null, $navigation = 10);

    /**
     * 주어진 조건에 해당하는 entity 하나를 조회한다.
     *
     * @param array         $wheres 검색 조건
     * @param string[]|null $with   entity와 함께 반환할 relation 정보
     *
     * @return null|Entity
     */
    public function fetchOne($wheres, $with = null);

    /**
     * 주어진 조건에 해당하는 모든 entity 조회한다.
     *
     * @param mixed         $wheres 검색 조건
     * @param string[]|null $with   entity와 함께 반환할 relation 정보
     *
     * @return array
     */
    public function fetchAll($wheres, $with = null);

    /**
     * entity 목록을 조회한다. pagination된 결과를 반환한다.
     *
     * @param string[]|null      $with       entity와 함께 반환할 relation 정보
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    public function paginate($with = null, $navigation = 10);

    /**
     * 모든 entity 목록을 조회한다.
     *
     * @param string[]|null $with entity와 함께 반환할 relation 정보
     *
     * @return array
     */
    public function all($with = null);

    /**
     * 주어진 조건에 해당하는 entity 목록을 조회한다. $searches 파라메터에 지정된 조건은 like 검색을 수행한다.
     *
     * $searches 파라메터는 아래와 같이 지정될 수 있다.
     * ```
     * $searches = [
     *      'displayName' => 'foo',
     * ]
     * // where displayName like '%foo%'
     *
     * $searches = [
     *      'displayName|email' => 'foo'
     * ]
     * // where displayName like '%foo%' or email like '%foo%'
     *
     * $searches = [
     *      'displayName' => 'foo',
     *      'email' => 'bar'
     * ]
     * // where displayName like '%foo%' and email like '%bar%'
     * ```
     *
     * @param mixed              $searches   like 검색을 위한 조건
     * @param mixed              $wheres     검색 조건
     * @param string[]|null      $with       entity와 함께 반환할 relation 정보
     * @param int|int[]|stdClass $navigation 검색시 사용할 navigation(page, perPage, sort, order) 정보
     *
     * @return array
     */
    public function search($searches, $wheres = null, $with = null, $navigation = 10);

    /**
     * 주어진 조건에 해당하는 entity의 갯수를 반환한다.
     *
     * @param mixed $wheres 검색 조건
     *
     * @return int
     */
    public function count($wheres = null);

    /**
     * 주어진 entity 정보를 저장소에 업데이트한다.
     *
     * @param Entity $entity 업데이트할 정보
     *
     * @return Entity
     */
    public function update($entity);

    /**
     * 주어진 entity를 저장소에서 삭제한다.
     *
     * @param Entity $entity 삭제할 entity 정보
     *
     * @return int
     */
    public function delete($entity);

    /**
     * 주어진 entity 정보를 저장소에 추가한다.
     *
     * @param Entity $entity 삽입할 정보
     *
     * @return Entity
     */
    public function insert($entity);
}

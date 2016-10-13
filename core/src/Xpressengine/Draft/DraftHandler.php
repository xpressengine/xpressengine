<?php
/**
 * This file is draft handler class
 *
 * PHP version 5
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Draft;

use Illuminate\Auth\AuthManager;

/**
 * # DraftHandler
 * 임시저장 데이터를 관리
 *
 * ### app binding : xe.draft 로 바인딩 되어 있음
 * XeDraft Facade 로 접근이 가능
 *
 * ### Usage
 * 임시저장될 데이터는 key, value 형태로 등록되어집니다.
 * 이때 key 는 구분할 수 있는 문자열으로, 중복이 가능합니다.
 * 등록되어질 내용이 value 이외에 추가적으로 더 있을 경우
 * 배열로 함께 전달해야 합니다.
 *
 * ```php
 * XeDraft::set('key string', 'it is test content', ['foo' => 'bar', 'baz' => 'qux']);
 * ```
 *
 * 임시저장된 데이터를 가져올때는 등록시 사용했던 key 를 통해서 같은 키를 가지는
 * 데이터 목록을 반환 받을 수 도 있고, 등록시 생성된 id 를 통해 한개의
 * 데이터만 반환 받을 수 도 있습니다.
 *
 * ```php
 * // list
 * $dataList = XeDraft::get('key string');
 *
 * // one
 * $data = XeDraft::getById('id');
 * ```
 *
 * @category    Draft
 * @package     Xpressengine\Draft
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DraftHandler
{
    /**
     * Repository instance
     *
     * @var DraftRepository
     */
    protected $repo;

    /**
     * AuthManager instance
     *
     * @var AuthManager
     */
    protected $auth;

    /**
     * Constructor
     *
     * @param DraftRepository $repo Repository instance
     * @param AuthManager         $auth AuthManager instance
     */
    public function __construct(DraftRepository $repo, AuthManager $auth)
    {
        $this->repo = $repo;
        $this->auth = $auth;
    }

    /**
     * 임시저장 데이터들을 반환 함
     *
     * @param string $key 구분할 수 있는 키(중복가능)
     * @return DraftEntity[]
     */
    public function get($key)
    {
        return $this->repo->fetch([
            'userId' => $this->auth->user()->getId(),
            'key' => $key,
        ]);
    }

    /**
     * 아이디에 해당 하는 데이터 반환
     *
     * @param string $id 임시저장 아이디
     * @return DraftEntity
     */
    public function getById($id)
    {
        return $this->repo->find($id);
    }

    /**
     * 자동저장으로 저장된 데이터 반환
     *
     * @param string $key 구분할 수 있는 키
     * @return DraftEntity
     */
    public function getAuto($key)
    {
        $arr = $this->repo->fetch([
            'userId' => $this->auth->user()->getId(),
            'key' => $key,
            'isAuto' => 1
        ]);

        return array_shift($arr);
    }

    /**
     * 임시 데이터 저장
     *
     * @param string $key    구분할 수 있는 키(중복가능)
     * @param mixed  $val    저장될 내용
     * @param array  $etc    기타 값들
     * @param bool   $isAuto 자동 저장 인지 여부
     * @return DraftEntity
     */
    public function set($key, $val, array $etc = [], $isAuto = false)
    {
        if ($this->auth->guest()) {
            return null;
        }

        $draft = new DraftEntity();
        $draft->fill([
            'userId' => $this->auth->user()->getId(),
            'key' => $key,
            'val' => $val,
            'etc' => serialize($etc),
            'isAuto' => $isAuto ? 1 : 0
        ]);

        return $this->repo->insert($draft);
    }

    /**
     * 임시저장 데이터 갱신
     *
     * @param string $id  임시저장 아이디
     * @param string $val 갱신될 data 값
     * @param array  $etc 기타 값들
     * @return DraftEntity
     */
    public function put($id, $val, array $etc = [])
    {
        if (($draft = $this->getById($id)) === null) {
            return null;
        }

        $draft->val = $val;
        $draft->etc = serialize($etc);

        return $this->repo->update($draft);
    }

    /**
     * 임시저장 데이터 삭제
     *
     * @param DraftEntity $draft 임시저장 객체
     * @return void
     */
    public function remove(DraftEntity $draft)
    {
        $this->repo->delete($draft);
    }

    /**
     * 키 값에 해당하는 임시저장 데이터 존재 유무 판별
     *
     * @param string $key 구분할 수 있는 키(중복가능)
     * @return bool
     */
    public function exists($key)
    {
        $items = $this->get($key);

        return count($items) > 0;
    }
}

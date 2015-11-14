<?php
/**
 * Counter
 *
 * PHP version 5
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Counter;

use Illuminate\Http\Request;
use Xpressengine\Member\GuardInterface as Authenticator;
use Xpressengine\Member\Repositories\MemberRepositoryInterface as Member;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Entities\Guest;

/**
 * # Counter
 * * 조회수, 좋아요, 싫어요 등 카운팅이 필요한 요소들을 위해 카운트 로그 지원
 * * 두가지 방식을 지원한다
 *      - 회원에 따라 id에 한번만 처리 가능한 형식 - 추천/비추천 수에 적용(추천수타입)
 *      - 세션에 따라 처리하는 형식
 * (로그인/아웃 하고 나면 다시 카운트) - 글 읽음 수에 적용(조회수타입)
 *
 *
 * ## app binding
 * * xe.counter 로 바인딩 되어 있음
 * * Counter facade 제공
 *
 * ## 사용법
 *
 * ### Counter 설정 등록
 * * Counter 를 사용하기 위해서 config 를 설정해야 함
 * * 패키지 또는 플러그인에서 Install 할 때 처리해줘야 함
 *
 * ```php
 * $configHandler = app('xe.counter')->getConfigHandler();
 *
 * // board 의 read counter 등록
 * $configHandler->set('board_read', Counter::TYPE_SESSION);
 *
 * // board 의 vote counter 등록
 * $configHandler->set('board_vote', Counter::TYPE_ID);
 * ```
 *
 * ### Counter type
 * * Counter::TYPE_ID
 *      - 회원 아이디 기준으로 도작 database 이용
 *      - 로그인하지 않은 사용자는 count 할 수 없음
 * * Counter::TYPE_SESSION
 *      - session 을 이용해서 count
 *      - 로그인 한 사용자는 Counter::TYPE_ID 방식으로 처리
 *      - 로그인 안한 사용자는 세션에 로그 기록
 *      - 세션이 삭제되면 다시 count 됨
 *
 * ### Counter init
 * * Counter 초기화 설정
 * * 등록된 Counter 설정으로 초기화
 *
 * ```php
 * $counter = app('xe.counter');
 *
 * // 게시판 조회수 counter 설정
 * $counter->init('board_read');
 *
 * // 게시판 찬성 수 counter 설정
 * $counter->init('board_vote', 'assent');
 * ```
 *
 * ### 로그 저장
 * * Counter 는 로그만 관리. 총 count 저장 안함
 * * 총 count 는 Counter 를 사용하는 코드에서 저장해야 함
 *
 * ```php
 * $counter = app('xe.counter');
 *
 * // 조회수 증가
 * $counter->init('board_read');
 * $counter->add('Document-UUID');
 *
 * // 찬성 증가
 * $counter->init('board_vote', 'assent');
 * $counter->add('Document-UUID');
 * ```
 *
 * ### 로그 삭제
 *
 * ```php
 * $counter = app('xe.counter');
 *
 * // 조회수 증가
 * $counter->init('board_read');
 * $counter->remove('Document-UUID');
 *
 * // 찬성 증가
 * $counter->init('board_vote', 'assent');
 * $counter->remove('Document-UUID');
 * ```
 *
 * ### 로그 확인
 *
 * ```php
 * $counter = app('xe.counter');
 *
 * // 게시글 조회 여부
 * $counter->init('board_read');
 * $result = $counter->invoked('Document-UUID', Auth::user());
 *
 * // 찬성 투표 여부
 * $counter->init('board_vote', 'assent');
 * $result = $counter->invoked('Document-UUID', Auth::user());
 * ```
 *
 * ### 로그 정보 확인
 *
 * ```php
 * $counter = app('xe.counter');
 *
 * $counter->init('board_vote', 'assent');
 * $data = $counter->get('Document-UUID', Auth::user());
 * ```
 *
 * ### 로그에 포함된 사용자 확인
 *
 * ```php
 * $counter = app('xe.counter');
 *
 * $counter->init('board_vote', 'assent');
 *
 * // MemberEntity[]
 * $list = $counter->getUsers('Document-UUID', 5);
 *
 * // 회원 아이디
 * $ids = $counter->getUserIds('Document-UUID', 5);
 * ```
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Counter
{
    /**
     * @var Repository
     */
    protected $repo;

    /**
     * @var SessionCounter
     */
    protected $session;

    /**
     * @var Authenticator
     */
    protected $auth;

    /**
     * @var Member
     */
    protected $member;

    /**
     * @var ConfigHandler
     */
    protected $configHandler;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $option = 'default';

    /**
     * self::TYPE_ID or self::TYPE_SESSION
     *
     * @var string
     */
    protected $type;

    /**
     * 기본 설정. DB log 기준으로 처리
     */
    const TYPE_ID = 'id';

    /**
     * userId 가 없을 경우 session 을 이용해 처리
     */
    const TYPE_SESSION = 'session';

    /**
     * create instance
     *
     * @param Repository     $repo          Counter repository
     * @param SessionCounter $session       Session counter
     * @param ConfigHandler  $configHandler config handler
     * @param Member         $member        회원정보 관리
     * @param Authenticator  $auth          Authenticator
     * @param Request        $request       Request
     */
    public function __construct(
        Repository $repo,
        SessionCounter $session,
        ConfigHandler $configHandler,
        Member $member,
        Authenticator $auth,
        Request $request
    ) {
        $this->repo = $repo;
        $this->session = $session;
        $this->configHandler = $configHandler;
        $this->member = $member;
        $this->auth = $auth;
        $this->request = $request;
    }

    /**
     * get config handler
     *
     * @return ConfigHandler
     */
    public function getConfigHandler()
    {
        return $this->configHandler;
    }

    /**
     * counter 설정
     *
     * @param string $name   counter name
     * @param string $option counter option
     * @return Counter
     */
    public function init($name, $option = 'default')
    {
        $this->name = $name;
        $this->option = $option;
        $this->type = $this->configHandler->getType($name);

        if ($this->isSession()) {
            $this->session->init($name, $option);
        }

        return $this;
    }

    /**
     * add counter log
     *
     * @param string                $targetId targetId
     * @param MemberEntityInterface $author   user instance
     * @param int                   $point    point
     * @return void
     * @throws Exceptions\LoginRequiredException
     */
    public function add($targetId, MemberEntityInterface $author = null, $point = 1)
    {
        $author = $this->getUser($author);

        if ($this->invoked($targetId, $author) === true) {
            throw new Exceptions\InvokedException;
        }

        if ($this->isSession() === true && $author instanceof Guest) {
            $this->session->add($targetId);
            $ip = $this->request->ip();
            $this->repo->insert($this->name, $this->option, $targetId, '', $ip, $point);
        }

        if ($author->getId() != '') {
            $ip = $this->request->ip();
            $this->repo->insert($this->name, $this->option, $targetId, $author->getId(), $ip, $point);
        }
    }

    /**
     * remove counter log
     *
     * @param string                $targetId targetId
     * @param MemberEntityInterface $author   user instance
     * @return void
     */
    public function remove($targetId, MemberEntityInterface $author = null)
    {
        $author = $this->getUser($author);

        if ($this->isSession() === true) {
            $this->session->remove($targetId);
        }

        if ($author->getId() != '') {
            $this->repo->delete($this->name, $this->option, $targetId, $author->getId());
        }
    }

    /**
     * $targetId 에 $authorId 가 포함 되어있는지 확인
     *
     * @param string                $targetId targetId
     * @param MemberEntityInterface $author   user instance
     * @return bool
     * @throws Exceptions\InvalidTypeException
     */
    public function invoked($targetId, MemberEntityInterface $author)
    {
        if ($this->isSession() === false && $author instanceof Guest) {
            throw new Exceptions\InvalidTypeException;
        } elseif ($this->isSession() === true && $author instanceof Guest) {
            return $this->session->invoked($targetId);
        } else {
            return $this->get($targetId, $author) !== null;
        }
    }

    /**
     * 참여 정보 반환
     *
     * @param string                $targetId targetId
     * @param MemberEntityInterface $author   user instance
     * @return array|null
     */
    public function get($targetId, MemberEntityInterface $author)
    {
        return $this->repo->find([
            'targetId' => $targetId,
            'userId' => $author->getId(),
            'counterName' => $this->name,
        ]);
    }


    /**
     * 세션을 지원하는지 확인
     *
     * @return bool
     */
    protected function isSession()
    {
        return $this->type == self::TYPE_SESSION;
    }

    /**
     * get author
     * $author 가 null 로 넘어 온 경우 $auth 를 통해 로그인 사용자 정보를 획득
     *
     * @param MemberEntityInterface $author user instance
     * @return MemberEntityInterface
     * @throws Exceptions\LoginRequiredException
     */
    protected function getUser(MemberEntityInterface $author = null)
    {
        if ($author === null) {
            $author = $this->auth->user();
        }

        $this->invalid($author);

        return $author;
    }

    /**
     * $type 이 session 이 아닌 경우는 Guest 에 대해서 동작 할 수 없음
     *
     * @param MemberEntityInterface $author user instance
     * @return void
     * @throws Exceptions\LoginRequiredException
     * @throws Exceptions\NameNotExistsException
     */
    protected function invalid(MemberEntityInterface $author)
    {
        if ($this->name === null) {
            throw new Exceptions\NameNotExistsException;
        }

        if ($this->isSession() === false && $author instanceof Guest == true) {
            throw new Exceptions\LoginRequiredException;
        }
    }

    /**
     * get User instance list
     *
     * @param string $targetId target id
     * @param int    $limit    limit
     * @return array
     */
    public function getUsers($targetId, $limit = 5)
    {
        $users = [];
        foreach ($this->getUserIds($targetId, $limit) as $userId) {
            $users[] = $this->member->find($userId);
        }

        return $users;
    }

    /**
     * get user id list
     *
     * @param string $targetId target id
     * @param int    $limit    limit
     * @return array
     */
    public function getUserIds($targetId, $limit = 5)
    {
        $wheres = [
            'targetId' => $targetId,
            'counterName' => $this->name,
            'counterOption' => $this->option,
        ];
        $orders = [
            'createdAt' => 'desc',
        ];
        return $this->repo->fetchByUserIds($wheres, $orders, $limit);
    }

    /**
     * targetId 에 해당하는 모든 리스트 반환
     *
     * @param string $targetId targetId
     * @return array
     * @deprecated
     */
    public function gets($targetId)
    {
        return $this->repo->fetch([
            'targetId' => $targetId,
            'counterName' => $this->name,
            'counterOption' => $this->option,
        ], []);
    }

    /**
     * get list by paginate
     *
     * @param array $wheres  where conditions
     * @param array $orders  order conditions
     * @param int   $perPage page count
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @deprecated
     */
    public function paginate($wheres, $orders, $perPage)
    {
        return $this->repo->paginate($wheres, $orders, $perPage);
    }

    /**
     * targetId 의 수
     *
     * @param string $targetId targetId
     * @return int
     * @deprecated
     */
    public function count($targetId)
    {
        $wheres = [
            'targetId' => $targetId,
            'counterName' => $this->name,
        ];

        return $this->repo->count($wheres);
    }

    /**
     * get counts group by options
     *
     * @param string $targetId target id
     * @return array
     * @deprecated
     */
    public function countsByOption($targetId)
    {
        $wheres = [
            'targetId' => $targetId,
            'counterName' => $this->name,
        ];

        return $this->repo->countsByOption($wheres);
    }
}

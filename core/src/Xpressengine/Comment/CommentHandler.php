<?php
/**
 * This file is comment handler
 *
 * PHP version 5
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Comment;

use Illuminate\Pagination\Paginator;
use Xpressengine\Comment\Exceptions\InvalidParentException;
use Xpressengine\Comment\Exceptions\NotConfiguredException;
use Xpressengine\Comment\Exceptions\LimitedReplyException;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Member\GuardInterface as Authenticator;
use Xpressengine\Member\MemberHandler;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Comment\Exceptions\InvalidObjectException;

/**
 * # CommentHandler
 * comment 패키지 메인 클래스로서 comment 전반을 다룸
 *
 * ### app binding : xe.comment 로 바인딩 되어 있음
 * `Comment` Facade 로 접근 가능
 *
 * ### 댓글 등록
 * ```php
 *  Comment::create([
 *      'instanceId' => 'someInstance',
 *      'targetId' => 'targetIdentifier',
 *      'content' => 'comment content!'
 *  ]);
 * ```
 *
 * 비회원이 작성하는 경우 작성자명, 이메일, 비밀번호를 함께 전달해야 합니다.
 * ```php
 *  Comment::create($target, [
 *      'writer' => 'author name',
 *      'email' => 'foo@bar.com',
 *      'certifyKey' => '*********',    // hashed string
 *      'content' => 'comment content!'
 *  ]);
 * ```
 *
 * 대댓글일 경우 부모 댓글의 아이디를 함께 전달해야 합니다.
 * ```php
 *  Comment::create($target, [
 *      'parentId' => 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
 *      'content' => 'comment content!'
 *  ]);
 * ```
 *
 * ### 리스팅
 * comment 패키지는 더보기 형태의 목록을 지원 합니다.
 * ```php
 *  // 일반적인 사용자 페이지의 목록을 가져올때는 다음 검색조건이 필요합니다.
 *  $wheres = ['approved' => 'approved', 'display' => ['!=', 'hidden']];
 *  // $offsetHead, $offsetReply 는 마지막 댓글의 head 값과 reply 코드 값입니다.
 *  Comment::loadMore($target, $wheres, $offsetHead, $offsetReply);
 * ```
 *
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CommentHandler
{
    const PREFIX = 'comments';

    /**
     * Member instance
     *
     * @var MemberHandler
     */
    protected $member;

    /**
     * Authenticator instance
     *
     * @var Authenticator
     */
    protected $auth;

    /**
     * Repository instance
     *
     * @var Repository
     */
    protected $repo;

    /**
     * ConfigManager instance
     *
     * @var ConfigManager
     */
    protected $configs;

    /**
     * @var array
     */
    private $defaultConfig = [
        'division' => false,
        'useAssent' => false,
        'useDissent' => false,
        'useApprove' => false,
        'secret' => false,
        'perPage' => 20,
        'useWysiwyg' => false,
        'removeType' => 'batch',
        'reverse' => false
    ];

    /**
     * constructor
     *
     * @param MemberHandler $member  Member instance
     * @param Authenticator $auth    Authenticator instance
     * @param Repository    $repo    Repository instance
     * @param ConfigManager $configs ConfigManager instance
     */
    public function __construct(
        MemberHandler $member,
        Authenticator $auth,
        Repository $repo,
        ConfigManager $configs
    ) {
        $this->member = $member;
        $this->auth = $auth;
        $this->repo = $repo;
        $this->configs = $configs;
    }

    /**
     * 대상 instance 별 설정
     *
     * @param string $instanceId  instance identifier
     * @param array  $information config information
     * @return void
     * @throws NotConfiguredException
     */
    public function configure($instanceId, array $information)
    {
        $key = $this->getConfigKey($instanceId);

        if (!$config = $this->configs->get($key)) {
            throw new NotConfiguredException();
        }

        $information = array_merge($this->defaultConfig, $information);
        // division 설정은 최초 인스턴스 생성시 결정되며 변경할 수 없다.
        $information = array_diff_key($information, array_flip(['division']));

        foreach ($information as $name => $value) {
            $config->set($name, $value);
        }

        $this->configs->modify($config);
    }

    /**
     * 새로운 인스턴스 설정
     *
     * @param string $instanceId instance identifier
     * @param bool   $division   if true, set table division
     * @return void
     */
    public function createInstance($instanceId, $division = false)
    {
        $key = $this->getConfigKey($instanceId);
        $information = array_merge($this->defaultConfig, ['division' => $division]);

        $this->configs->set($key, $information);

        $this->repo->createInstance($instanceId);
    }

    /**
     * 인스턴스 유무
     *
     * @param string $instanceId instance identifier
     * @return bool
     */
    public function existInstance($instanceId)
    {
        $key = $this->getConfigKey($instanceId);
        if ($this->configs->get($key) !== null) {
            return true;
        }

        return false;
    }

    /**
     * config 객체를 반환함
     *
     * @param string $instanceId instance identifier
     * @return \Xpressengine\Config\ConfigEntity
     */
    public function getConfig($instanceId)
    {
//        return $this->configs->getOrNew($this->getConfigKey($instanceId));
        $config = $this->configs->get($this->getConfigKey($instanceId));

        if ($config === null) {
            $config = $this->configs->getOrNew($this->getConfigKey($instanceId));
            foreach ($this->defaultConfig as $key => $value) {
                $config->set($key, $value);
            }
        }

        return $config;
    }

    /**
     * config key 를 반환
     *
     * @param string $instanceId instance identifier
     * @return string
     */
    protected function getConfigKey($instanceId)
    {
        return static::PREFIX . '.' . $instanceId;
    }

    /**
     * instance 에 속한 comment 를 제거함, table 도 삭제 됨
     *
     * @param string $instanceId instance identifier
     * @return void
     */
    public function drop($instanceId)
    {
        $this->repo->dropInstance($instanceId);

        $this->configs->removeByName($this->getConfigKey($instanceId));
    }

    /**
     * comment 객체를 반환
     *
     * @param string $id comment identifier
     * @return CommentEntity
     */
    public function get($id)
    {
        $comment = $this->repo->find($id);

        return $comment ? $this->member->associate($comment) : null;
    }

    /**
     * comment 객체를 반환
     *
     * @param string $instanceId instance identifier
     * @param string $id         comment identifier
     * @return CommentEntity
     */
    public function getBaseInstance($instanceId, $id)
    {
        $comment = $this->repo->findBaseInstanceId($instanceId, $id);

        return $comment ? $this->member->associate($comment) : null;
    }

    /**
     * 계층형 목록으로 반환
     *
     * json 으로 반환되어 사용되어지기 위해
     * 정순으로 목록화한 역순으로 반환
     *
     * @param string      $instanceId  instance identifier
     * @param string      $targetId    target identifier
     * @param array       $wheres      검색조건
     * @param string|null $offsetHead  이전 목록의 마지막 head
     * @param string|null $offsetReply 이전 목록의 마지막 reply
     * @param int|null    $take        아이템 갯수
     * @return Paginator comment list
     */
    public function loadMore(
        $instanceId,
        $targetId,
        array $wheres = [],
        $offsetHead = null,
        $offsetReply = null,
        $take = null
    ) {
        $config = $this->configs->get($this->getConfigKey($instanceId));

        $take = $take ?: $config->get('perPage');

        $direction = $config->get('reverse') === true ? 'asc' : 'desc';

        $wheres['targetId'] = $targetId;

        $totalCount = $this->repo->countBaseInstanceId($instanceId, $wheres);

        if ($offsetHead !== null) {
            $wheres[] = function ($query) use ($offsetHead, $offsetReply, $direction) {
                $query->where('head', $offsetHead);
                $ltgt = $direction == 'asc' ? '>' : '<';
                if ($offsetReply === null) {
                    $offsetReply = '';
                }
                $query->where('reply', $ltgt, $offsetReply);
                $query->orWhere('head', '<', $offsetHead);
            };
        }

        $comments = $this->repo->fetchBaseInstanceId(
            $instanceId,
            $wheres,
            $take + 1,
            [
                'head' => 'desc',
                'reply' => $direction,
            ]
        );

        $comments = $this->member->associates($comments);

        $paginator = new Paginator($comments, $take, null, ['totalCount' => $totalCount]);

        return $paginator;
    }

    /**
     * 대상에 대한 전체 댓글 갯수
     *
     * @param string $instanceId instance identifier
     * @param string $targetId   target identifier
     * @return int
     */
    public function countAllByTarget($instanceId, $targetId)
    {
        return $this->repo->countBaseInstanceId($instanceId, ['targetId' => $targetId]);
    }

    /**
     * 전체 댓글 갯수
     *
     * @return int
     */
    public function countAll()
    {
        return $this->repo->count([]);
    }

    /**
     * 관리자에서 모든 댓글 볼때 사용
     *
     * @param array $wheres 검색조건
     * @param int   $take   아이템 갯수
     * @return Paginator
     */
    public function paginate(array $wheres = [], $take = 10)
    {
        $paginator = $this->repo->paginate($wheres, $take, ['createdAt' => 'desc']);

        return $paginator;
    }

    /**
     * comment id 들을 전달받아 목록을 구성
     *
     * @param array $ids comment id list
     * @return CommentEntity[]
     */
    public function getsIn(array $ids)
    {
        return $this->repo->fetchIn($ids);
    }

    /**
     * 검색조건에 맞는 댓글 목록을 반환
     *
     * @param array $wheres where clause
     * @return CommentEntity[]
     */
    public function gets(array $wheres)
    {
        return $this->repo->fetch($wheres);
    }

    /**
     * comment 를 생성
     *
     * @param array                      $inputs input information
     * @param MemberEntityInterface|null $user   user instance
     * @return CommentEntity
     */
    public function create(array $inputs, MemberEntityInterface $user = null)
    {
        $comment = new CommentEntity();
        foreach ($inputs as $key => $value) {
            $comment->$key = $value;
        }

        return $this->add($comment, $user);
    }

    /**
     * Add new comment
     *
     * @param CommentEntity              $comment comment object
     * @param MemberEntityInterface|null $user    user instance
     * @return CommentEntity
     * @throws InvalidObjectException
     */
    public function add(CommentEntity $comment, MemberEntityInterface $user = null)
    {
        if ($comment->instanceId === null || $comment->targetId === null) {
            throw new InvalidObjectException;
        }

        if (isset($comment->targetAuthorId)) {
            unset($comment->targetAuthorId);
        }

        /** @var MemberEntityInterface $user */
        $user = $user ?: $this->auth->user();

        $comment->userId = $user->getId();

        if (isset($comment->writer) === false) {
            $comment->writer = $user->getDisplayName();
        }

        $config = $this->configs->get($this->getConfigKey($comment->instanceId));
        if ($config->get('useWysiwyg') === true) {
            $comment->html = 1;
        }

        // for 계층 모델
        if (isset($comment->parentId) === true) {
            if (!$parent = $this->get($comment->parentId)) {
                throw new InvalidObjectException;
            }

            $this->setReply($comment, $parent);
        }

        $added = $this->repo->insert($comment);

        return $this->member->associate($added);
    }

    /**
     * Set reply code
     *
     * @param CommentEntity $comment new comment object
     * @param CommentEntity $parent  parent comment object
     * @return void
     * @throws LimitedReplyException
     */
    protected function setReply(CommentEntity &$comment, CommentEntity $parent)
    {
        $comment->head = $parent->head;

        $charLen = $this->getReplyCharlen();

        $lastReply = $this->repo->getLastChildReply($parent, $charLen);

        $lastChar = null;
        if ($lastReply !== null) {
            $lastChar = substr($lastReply, -1 * $charLen);
        }

        $comment->reply = $parent->reply . $this->makeReplyChar($lastChar);
    }

    /**
     * Reply character length
     *
     * @return int
     */
    private function getReplyCharlen()
    {
        return CommentEntity::getReplyCharlen();
    }

    /**
     * Make next reply code characters
     *
     * @param string $prevChars previous child reply code character
     * @return string
     * @throws LimitedReplyException
     */
    protected function makeReplyChar($prevChars = null)
    {
        $std = '0123456789abcdefghijklmnopqrstuvwxyz';
        $std = str_split($std, 1);

        if ($prevChars === null) {
            return str_repeat($std[0], $this->getReplyCharlen());
        }

        if ($prevChars[strlen($prevChars)-1] == end($std)) {
            if (strlen($prevChars) < 2) {
                throw new LimitedReplyException;
            }
            reset($std);
            $new = $this->makeReplyChar(substr($prevChars, 0, strlen($prevChars)-1)) . current($std);
        } else {
            $key = array_search($prevChars[strlen($prevChars)-1], $std);
            $new = substr($prevChars, 0, strlen($prevChars)-1) . $std[$key + 1];
        }

        return $new;
    }

    /**
     * Put a comment
     *
     * @param CommentEntity $comment comment instance
     * @return CommentEntity
     */
    public function put(CommentEntity $comment)
    {
        $config = $this->configs->get($this->getConfigKey($comment->instanceId));
        if ($config->get('useWysiwyg') === true) {
            $comment->html = 1;
        }

        $updated = $this->repo->update($comment);

        return $this->member->associate($updated);
    }

    /**
     * Remove a comment
     *
     * @param CommentEntity $comment comment instance
     * @return int
     */
    public function remove(CommentEntity $comment)
    {
        if ($comment->status == 'trash') {
            if ($comment->display == 'hidden') {
                return $this->repo->delete($comment);
            } elseif ($comment->display == 'blind') {
                return $this->repo->clearDelete($comment);
            }
        }

        return 0;
    }

    /**
     * Soft remove a comment
     *
     * @param CommentEntity $comment comment instance
     * @return int
     * @throws NotConfiguredException
     */
    public function trash(CommentEntity $comment)
    {
        $config = $this->getConfig($comment->instanceId);

        if ($config->get('removeType') == 'batch') {
            $comments = $this->repo->fetch([
                'head' => $comment->head,
                'reply' => ['like', ($comment->reply ?: '') . '%']
            ]);

            $rowCnt = 0;
            foreach ($comments as $comment) {
                $rowCnt += $this->repo->softDelete($comment, ['status' => 'trash', 'display' => 'hidden']);
            }

            return $rowCnt;
        } elseif ($config->get('removeType') == 'blind') {
            return $this->repo->softDelete($comment, ['status' => 'trash', 'display' => 'blind']);
        } else {
            throw new NotConfiguredException();
        }
    }

    /**
     * 임시삭제된 댓글 복구
     *
     * @param CommentEntity $comment comment instance
     * @return CommentEntity
     * @throws InvalidParentException
     */
    public function restore(CommentEntity $comment)
    {
        // blind trash 상태에서 휴지통 비우기된 댓글은 복구되지 않음
        if ($comment->removed !== 0) {
            return null;
        }

        if (empty($comment->reply) !== true) {
            $parent = $this->repo->fetch([
                'head' => $comment->head,
                'reply' => substr($comment->reply, 0, -1 * $this->getReplyCharlen())
            ]);
            $parent = array_shift($parent);

            if ($parent === null || $parent->approved !== 'approved' || $parent->display == 'hidden') {
                throw new InvalidParentException();
            }
        }

        return $this->repo->unDelete($comment, ['status' => 'public', 'display' => 'visible']);
    }

    /**
     * 대상 객체에 속하는 댓글을 이동시킴
     *
     * @param string $instanceId instance identifier
     * @param string $targetId   target identifier
     * @return void
     */
    public function moveByTarget($instanceId, $targetId)
    {
        $comments = $this->repo->fetch(['targetId' => $targetId]);

        foreach ($comments as $comment) {
            $this->repo->moveTo($comment, $instanceId);
        }
    }

    /**
     * Database connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getConnection()
    {
        return $this->repo->getConnection();
    }
}

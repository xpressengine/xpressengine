<?php
/**
 * Document
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Document\Models;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Document\DocumentHandler;
use Xpressengine\Document\Exceptions\NotAllowedTypeException;
use Xpressengine\Document\Exceptions\ParentDocumentNotFoundException;
use Xpressengine\Document\Exceptions\ReplyLimitationException;
use Xpressengine\Document\Exceptions\ValueRequiredException;

/**
 * Document
 *
 * Config를 설정할 때 division 을 사용하는 경우에는 이 모델의 table 이름을
 * division table 이름으로 변경합니다.
 *
 * @property string id
 * @property string parentId
 * @property string instanceId
 * @property string type
 * @property string userId
 * @property string writer
 * @property string email
 * @property string certifyKey
 * @property integer readCount
 * @property integer commentCount
 * @property integer assentCount
 * @property integer dissentCount
 * @property integer approved
 * @property integer published
 * @property integer status
 * @property integer display
 * @property integer format
 * @property string locale
 * @property string title
 * @property string content
 * @property string pureContent
 * @property string createdAt
 * @property string publishedAt
 * @property string updatedAt
 * @property string deletedAt
 * @property string head
 * @property string reply
 * @property string listOrder
 * @property string ipaddress
 * @property string userType
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Document extends DynamicModel
{

    const TABLE_NAME = 'documents';

    public $table = self::TABLE_NAME;

    public $incrementing = false;

    protected $fillable = [
        'parentId', 'instanceId', 'userId', 'writer', 'approved',
        'published', 'status', 'display', 'format', 'locale', 'title',
        'content', 'pureContent', 'createdAt', 'publishedAt', 'head', 'reply',
        'listOrder', 'ipaddress', 'userType', 'certifyKey', 'email',
    ];

    protected $casts = [
        'status' => 'int',
        'approved' => 'int',
        'published' => 'int',
        'display' => 'int',
        'format' => 'int',
    ];

    protected $hidden = ['email', 'certifyKey', 'ipaddress'];

    /**
     * @var bool use dynamic query
     */
    protected $dynamic = true;
    protected $division = false;
    protected $config;

    /**
     * The connection name for the model.
     * Virtual connection name.
     *
     * @var string
     */
    protected $connection = 'document';

    protected static $replyCharLen = 3;

    // status
    const STATUS_TRASH = 0;
    const STATUS_TEMP = 10;
    const STATUS_PRIVATE = 20;
    const STATUS_PUBLIC = 30;
    const STATUS_NOTICE = 50;

    // approved
    const APPROVED_REJECTED = 0;
    const APPROVED_WAITING = 10;
    const APPROVED_APPROVED = 30;

    // published
    const PUBLISHED_REJECTED = 0;
    const PUBLISHED_WAITING = 10;
    const PUBLISHED_RESERVED = 20;
    const PUBLISHED_PUBLISHED = 30;

    // display
    const DISPLAY_HIDDEN = 0;
    const DISPLAY_SECRET = 10;
    const DISPLAY_VISIBLE = 20;

    const FORMAT_NONE = 0;
    const FORMAT_HTML = 10;

    // user type
    const USER_TYPE_GUEST = 'guest';
    const USER_TYPE_ANONYMITY = 'anonymity';
    const USER_TYPE_NORMAL = 'normal';
    const USER_TYPE_USER = 'user';

    /**
     * @var array
     */
    protected $statuses = [
        self::STATUS_PUBLIC,
        self::STATUS_PRIVATE,
        self::STATUS_TEMP,
        self::STATUS_TRASH,
        self::STATUS_NOTICE,
    ];

    /**
     * @var array
     */
    protected $displays = [
        self::DISPLAY_VISIBLE,
        self::DISPLAY_SECRET,
        self::DISPLAY_HIDDEN,
    ];

    /**
     * @var array
     */
    protected $approves = [
        self::APPROVED_APPROVED,
        self::APPROVED_WAITING,
        self::APPROVED_REJECTED,
    ];

    /**
     * @var array
     */
    protected $publishes = [
        self::PUBLISHED_PUBLISHED,
        self::PUBLISHED_RESERVED,
        self::PUBLISHED_WAITING,
        self::PUBLISHED_REJECTED,
    ];

    /**
     * division 테이블로 변경
     *
     * @param string $instanceId instance id
     * @return Document
     */
    static public function division($instanceId)
    {
        /** @var Document $instance */
        $instance = new static;
        $instance->setDivision($instanceId);

        return $instance;
    }

    /**
     * division 테이블 이름 변경
     *
     * @param $instanceId
     * @return $this
     */
    public function setDivision($instanceId)
    {
        /** @var DocumentHandler $handler */
        $handler = app('xe.document');

        $config = $handler->getConfig($instanceId);
        if ($config !== null && $config->get('division') === true) {
            $tableName = $handler->getInstanceManager()->getDivisionTableName($config);
            $this->setTable($tableName);
        }

        return $this;
    }

    /**
     * user relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('Xpressengine\User\Models\User', 'userId');
    }

    /**
     * set config
     *
     * @param ConfigEntity $config document config entity
     * @param string|null  $table  table name
     * @return void
     * @deprecated
     */
    public function setConfig(ConfigEntity $config, $table = null)
    {
        $this->config = $config;
        $this->division = $config->get('division');
        $this->setProxyOptions([
            'id' => $config->get('instanceId'),
            'group' => $config->get('group'),
        ]);
        if ($table !== null) {
            $this->table = $table;
        }
    }

    /**
     * Check required attributes
     *
     * @param array $attributes attributes
     * @return void
     */
    public function checkRequired(array $attributes)
    {
        if ($attributes['userId'] === null) {
            throw new ValueRequiredException(['name' => 'userId']);
        }

        if ($attributes['writer'] === null) {
            throw new ValueRequiredException(['name' => 'writer']);
        }

        if ($attributes['instanceId'] === null) {
            throw new ValueRequiredException(['name' => 'instanceId']);
        }
    }

    /**
     * Set default value to attributes
     *
     * @param array $attributes attributes
     * @return array
     */
    public function fixedAttributes(array $attributes)
    {
        $attributes['pureContent'] = $this->getPureContent($attributes['content']);

        if (empty($attributes['userType']) === true) {
            $attributes['userType'] = $this::USER_TYPE_USER;
        }
        if (empty($attributes['approved']) === true) {
            $attributes['approved'] = $this::APPROVED_APPROVED;
        }
        if (empty($attributes['published']) === true) {
            $attributes['published'] = $this::PUBLISHED_PUBLISHED;
        }
        if (empty($attributes['status']) === true) {
            $attributes['status'] = $this::STATUS_PUBLIC;
        }
        if (empty($attributes['display']) === true) {
            $attributes['display'] = $this::DISPLAY_VISIBLE;
        }
        if ($attributes['published'] == 'published' && empty($attributes['publishedAt']) === true) {
            $attributes['publishedAt'] = $this->freshTimestamp();
        }
        if (empty($attributes['reply']) === true) {
            $attributes['reply'] = '';
        }
        if (empty($attributes['locale']) === true) {
            $attributes['locale'] = '';
        }

        return $attributes;
    }

    /**
     * HTML 코드를 제거한 pureContent 반환
     *
     * @param string $content content
     * @return string
     * @todo 이미지 제목이나 파일 제목 같은 tag 요소들은 제거하지 않고
     * 내용에 들어갈 수 있도록 해야 좋겠음
     */
    public function getPureContent($content)
    {
        $content = strip_tags($content);
        $content = str_replace(['&nbsp;'], [' '], $content);
        return $content;
    }

    /**
     * Set reply attributes value
     *
     * @return void
     */
    public function setReply()
    {
        $timestamp = time();
        if ($this->parentId == null || $this->parentId == '') {
            $this->setAttribute('head', $timestamp . '-' . $this->id);
        } elseif ($this->parentId !== $this->id) {
            $parent = static::find($this->parentId);
            if ($parent === null) {
                throw new ParentDocumentNotFoundException;
            }
            $this->setAttribute('reply', $this->getReplyChar($parent));
            $this->setAttribute('head', $parent->head);
        }
        $this->setAttribute('listOrder', $this->head . (isset($this->reply) ? $this->reply : ''));
    }

    /**
     * Set reply character length
     *
     * @param int $len reply character length
     * @return void
     */
    public static function setReplyCharLen($len)
    {
        self::$replyCharLen = $len;
    }

    /**
     * Reply character length
     *
     * @return int
     */
    public static function getReplyCharLen()
    {
        return self::$replyCharLen;
    }

    /**
     * get reply code
     *
     * @param Document $parent Parent document model
     * @return string
     */
    protected function getReplyChar(Document $parent)
    {
        $lastReply = self::where('head', $parent->head)
            ->where('reply', 'like', $parent->reply . str_repeat('_', self::$replyCharLen))
            ->max('reply');

        $lastChar = null;
        if ($lastReply !== null) {
            $lastChar = substr($lastReply, -1 * self::getReplyCharLen());
        }

        return $parent->reply . $this->makeReplyChar($lastChar);
    }

    /**
     * Make next reply code characters
     *
     * @param string $prevChars previous child reply code character
     * @return string
     * @throws ReplyLimitationException
     */
    protected function makeReplyChar($prevChars = null)
    {
        $std = '0123456789abcdefghijklmnopqrstuvwxyz';
        $std = str_split($std, 1);

        if ($prevChars === null) {
            return str_repeat($std[0], self::getReplyCharLen());
        }

        if ($prevChars[strlen($prevChars)-1] == end($std)) {
            if (strlen($prevChars) < 2) {
                throw new ReplyLimitationException;
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
     * 덧글의 depth 반환
     *
     * @return float
     */
    public function getDepth()
    {
        return strlen($this->reply) / $this->getReplyCharLen();
    }

    /**
     * 승인 상태 변경
     *
     * @param string $approved condition value. 'approved':승인됨, 'waiting':대기중, 'rejected':거절됨
     * @return void
     */
    public function setApproved($approved)
    {
        $approved = strtolower($approved);
        if (in_array($approved, $this->approves) === false) {
            throw new NotAllowedTypeException(['type' => $approved, 'to' => 'Approved']);
        }
        $this->setAttribute('approved', $approved);
    }

    /**
     * change documents display condition
     *
     * @param string $display condition value 'visible':보여짐, 'secret':비밀글, 'hidden':숨김
     * @return void
     */
    public function setDisplay($display)
    {
        $display = strtolower($display);
        if (in_array($display, $this->displays) === false) {
            throw new NotAllowedTypeException(['type' => $display, 'to' => 'Display']);
        }
        $this->setAttribute('display', $display);
    }

    /**
     * change documents status condition
     *
     * @param string $status condition value. 'usual':일반, 'temp':임시저장글, 'trash':휴지통글
     * @return void
     */
    public function setStatus($status)
    {
        $status = strtolower($status);
        if (in_array($status, $this->statuses) === false) {
            throw new NotAllowedTypeException(['type' => $status, 'to' => 'Status']);
        }
        $this->setAttribute('status', $status);
    }

    /**
     * change documents publish condition
     *
     * @param string $published condition value.
     * 'published':발행됨, 'waiting':대기중, 'reserved':발행예약됨, 'rejected':거절됨
     * @return void
     */
    public function setPublished($published)
    {
        $published = strtolower($published);
        if (in_array($published, $this->publishes) === false) {
            throw new NotAllowedTypeException(['type' => $published, 'to' => 'Published']);
        }
        $this->setAttribute('published', $published);
    }

    /**
     * 승인
     *
     * @return $this
     */
    public function setApprove()
    {
        $this->setApproved(self::APPROVED_APPROVED);
        $this->setDisplay(self::DISPLAY_VISIBLE);
        return $this;
    }

    /**
     * 승인 신청 거절
     *
     * @return $this
     */
    public function setReject()
    {
        $this->setApproved(self::APPROVED_REJECTED);
        $this->setDisplay(self::DISPLAY_HIDDEN);
        return $this;
    }

    /**
     * 승인 대기
     *
     * @return $this
     */
    public function setApproveWait()
    {
        $this->setApproved(self::APPROVED_WAITING);
        $this->setDisplay(self::DISPLAY_HIDDEN);
        return $this;
    }

    /**
     * 발행
     *
     * @return $this
     */
    public function setPublish()
    {
        $this->setPublished(self::PUBLISHED_PUBLISHED);
        $this->setDisplay(self::DISPLAY_VISIBLE);
        return $this;
    }

    /**
     * 발행 예약
     *
     * @return $this
     */
    public function setReserve()
    {
        $this->setPublished(self::PUBLISHED_RESERVED);
        $this->setDisplay(self::DISPLAY_HIDDEN);
        return $this;
    }

    /**
     * 휴지통
     *
     * @return $this
     */
    public function setTrash()
    {
        $this->setStatus(self::STATUS_TRASH);
        $this->setDisplay(self::DISPLAY_HIDDEN);
        $this->setAttribute(self::DELETED_AT, $this->freshTimestamp());
        return $this;
    }

    /**
     * 휴지통 문서 복구
     *
     * @return $this
     */
    public function setRestore()
    {
        $this->setStatus(self::STATUS_PUBLIC);
        $this->setDisplay(self::DISPLAY_VISIBLE);
        return $this;
    }

    /**
     * 임시저장
     *
     * @return $this
     */
    public function setTemporary()
    {
        $this->setStatus('temp');
        $this->setDisplay('hidden');
        return $this;
    }

    /**
     * 공지 상태로 변경
     *
     * @param bool $notice is notice
     * @return $this
     */
    public function setNotice($notice = true)
    {
        if ($notice === true) {
            $this->setStatus(self::STATUS_NOTICE);
        } else {
            $this->setStatus(self::STATUS_PUBLIC);
        }
        return $this;
    }

    /**
     * Fire the given event for the model.
     * Document 를 확장해서 사용하는 모델의 이벤트를 실행
     *
     * @param  string  $event
     * @param  bool  $halt
     * @return mixed
     */
    protected function fireModelEvent($event, $halt = true)
    {
        $documentDispatcher = Document::getEventDispatcher();
        if (isset($documentDispatcher)) {
            $documentEvent = "eloquent.{$event}: " . Document::class;
            $method = $halt ? 'until' : 'fire';
            Document::getEventDispatcher()->$method($documentEvent, $this);
        }

        $class = static::class;
        if ($class != Document::class) {
            return parent::fireModelEvent($event, $halt);
        }
    }
}

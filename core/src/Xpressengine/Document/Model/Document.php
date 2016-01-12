<?php
/**
 * Document
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Document\Model;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Document\Exceptions\NotAllowedTypeException;
use Xpressengine\Document\Exceptions\NotFoundDocumentException;
use Xpressengine\Document\Exceptions\ReplyLimitationException;
use Xpressengine\Document\Exceptions\RequiredValueException;

/**
 * Document
 *
 * @property string id
 * @property string parentId
 * @property string instanceId
 * @property string userId
 * @property string writer
 * @property string email
 * @property string certifyKey
 * @property string readCount
 * @property string commentCount
 * @property string assentCount
 * @property string dissentCount
 * @property string approved
 * @property string published
 * @property string status
 * @property string display
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
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Document extends DynamicModel
{
    protected static $replyCharLen = 3;

    // status
    const STATUS_PUBLIC = 'public';
    const STATUS_PRIVATE = 'private';
    const STATUS_TEMP = 'temp';
    const STATUS_TRASH = 'trash';
    const STATUS_NOTICE = 'notice';

    // approved
    const APPROVED_APPROVED = 'approved';
    const APPROVED_WAITING = 'waiting';
    const APPROVED_REJECTED = 'rejected';

    // published
    const PUBLISHED_PUBLISHED = 'published';
    const PUBLISHED_RESERVED = 'reserved';
    const PUBLISHED_WAITING = 'waiting';
    const PUBLISHED_REJECTED = 'rejected';

    // display
    const DISPLAY_VISIBLE = 'visible';
    const DISPLAY_SECRET = 'secret';
    const DISPLAY_HIDDEN = 'hidden';

    // user type
    const USER_TYPE_USER = 'user';
    const USER_TYPE_ANONYMITY = 'anonymity';
    const USER_TYPE_GUEST = 'guest';

    /**
     * The connection name for the model.
     * Virtual connection name.
     *
     * @var string
     */
    protected $connection = 'document';

    /**
     * @var array
     */
    protected $status = [
        self::STATUS_PUBLIC,
        self::STATUS_PRIVATE,
        self::STATUS_TEMP,
        self::STATUS_TRASH,
        self::STATUS_NOTICE,
    ];

    /**
     * @var array
     */
    protected $display = [
        self::DISPLAY_VISIBLE,
        self::DISPLAY_SECRET,
        self::DISPLAY_HIDDEN,
    ];

    /**
     * @var array
     */
    protected $approved = [
        self::APPROVED_APPROVED,
        self::APPROVED_WAITING,
        self::APPROVED_REJECTED,
    ];

    /**
     * @var array
     */
    protected $published = [
        self::PUBLISHED_PUBLISHED,
        self::PUBLISHED_RESERVED,
        self::PUBLISHED_WAITING,
        self::PUBLISHED_REJECTED,
    ];
    
    /**
     * division table 이름 반환
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function divisionTable(ConfigEntity $config = null)
    {
        $table = $this->table;
        if ($config != null && $config->get('division') === true) {
            $table = sprintf('%s_division_%s', $this->table, $config->get('instanceId'));
        }

        return $table;
    }

    /**
     * set model to division table name
     *
     * @param ConfigEntity|null $config config entity
     * @return $this
     */
    public function setDivision(ConfigEntity $config = null)
    {
        $this->setTable($this->divisionTable($config));
        return $this;
    }

    /**
     * Check required attributes
     *
     * @return void
     */
    public function checkRequired()
    {
        if ($this->userId === null) {
            throw new RequiredValueException;
        }

        if ($this->writer === null) {
            throw new RequiredValueException;
        }

        if ($this->instanceId === null) {
            throw new RequiredValueException;
        }
    }

    /**
     * Set default value to attributes
     *
     * @return void
     */
    public function fixedAttributes()
    {
        $this->setPureContent();

        if ($this->userType == null) {
            $this->userType = $this::USER_TYPE_USER;
        }
        if ($this->approved == null) {
            $this->approved = $this::APPROVED_APPROVED;
        }
        if ($this->published == null) {
            $this->published = $this::PUBLISHED_PUBLISHED;
        }
        if ($this->status == null) {
            $this->status = $this::STATUS_PUBLIC;
        }
        if ($this->display == null) {
            $this->display = $this::DISPLAY_VISIBLE;
        }
        if ($this->published == 'published' && $this->publishedAt == null) {
            $this->publishedAt = $this->freshTimestamp();
        }
        if ($this->locale == null) {
            $this->locale = 'default';
        }
    }

    /**
     * HTML 코드를 제거한 pureContent 할당
     *
     * @return void
     * @todo 이미지 제목이나 파일 제목 같은 tag 요소들은 제거하지 않고
     * 내용에 들어갈 수 있도록 해야 좋겠음
     */
    public function setPureContent()
    {
        $this->pureContent = strip_tags($this->content);
        $this->pureContent = str_replace(['&nbsp;'], [' '], $this->pureContent);
    }

    /**
     * Set reply code
     *
     * @return void
     */
    public function setReply()
    {
        $timestamp = time();
        if ($this->parentId == null || $this->parentId == '') {
            $this->head = $timestamp . '-' . $this->id;
        } elseif ($this->parentId !== $this->id) {
            $parent = self::find($this->parentId);
            if ($parent === null) {
                throw new NotFoundDocumentException;
            }

            $this->reply = $this->getReplyChar($parent);
            $this->head = $parent->head;
        }
        $this->listOrder = $this->head . (isset($this->reply) ? $this->reply : '');
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
            ->where('replay', 'like', $parent->reply . str_repeat('_', self::$replyCharLen))
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
        if (in_array($approved, $this->approved) === false) {
            throw new NotAllowedTypeException(['type' => $approved, 'to' => 'Approved']);
        }
        $this->__set('approved', $approved);
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
        if (in_array($display, $this->display) === false) {
            throw new NotAllowedTypeException(['type' => $display, 'to' => 'Display']);
        }
        $this->__set('display', $display);
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
        if (in_array($status, $this->status) === false) {
            throw new NotAllowedTypeException(['type' => $status, 'to' => 'Status']);
        }
        $this->__set('status', $status);
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
        if (in_array($published, $this->published) === false) {
            throw new NotAllowedTypeException(['type' => $published, 'to' => 'Published']);
        }
        $this->__set('published', $published);
    }

    /**
     * 승인
     *
     * @return $this
     */
    public function approve()
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
    public function reject()
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
    public function approveWait()
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
    public function publish()
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
    public function reserve()
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
    public function trash()
    {
        $this->setStatus(self::STATUS_TRASH);
        // 문서를 안보이게 할 필요는 없는듯
        $this->setDisplay(self::DISPLAY_HIDDEN);
        return $this;
    }

    /**
     * 휴지통 문서 복구
     *
     * @return $this
     */
    public function restore()
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
    public function temporary()
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
    public function notice($notice = true)
    {
        if ($notice === true) {
            $this->setStatus(self::STATUS_NOTICE);
        } else {
            $this->setStatus(self::STATUS_PUBLIC);
        }
        return $this;
    }
}

<?php
/**
 * DocumentEntity
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
namespace Xpressengine\Document;

use Xpressengine\Member\AssociateInterface;
use Xpressengine\Support\EntityTrait;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Entities\Guest;

/**
 * DocumentEntity
 *
 * property string id
 *
*@property string parentId
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
 *
 */
class DocumentEntity implements AssociateInterface
{

    use EntityTrait {
        __construct as traitConstruct;
    }

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
     * content 반환 모드
     *
     * @var string
     */
    const CONTENT_HTML = 'origin';

    /**
     * content 반환 모드
     *
     * @var string
     */
    const CONTENT_NO_HTML = 'noHtml';

    /**
     * writer's user entity
     *
     * @var MemberEntityInterface
     */
    protected $author;

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
     * @var string
     */
    protected $contentMode = self::CONTENT_HTML;

    /**
     * constructor
     *
     * @param array $attributes attributes in object
     */
    public function __construct(array $attributes = [])
    {
        // DocumentEntity 는 array, object 를 attribute 로 갖지 않는다.
        $attributes = array_filter($attributes, function($item) {
            if (!is_array($item) && !is_object($item)) {
                return true;
            }
        });
        $this->traitConstruct($attributes);
    }

    /**
     * get content return mode
     *
     * @return string
     */
    public function getContentMode()
    {
        return $this->contentMode;
    }

    /**
     * content 반환 모드
     *
     * @param string $contentMode output content mode
     * @return void
     */
    public function setContentMode($contentMode)
    {
        $this->contentMode = $contentMode;
    }

    /**
     * content 반환
     *
     * @param string|null $contentMode output content mode
     * @return string
     */
    public function content($contentMode = null)
    {
        if ($contentMode != null) {
            $this->setContentMode($contentMode);
        }

        switch($this->contentMode) {
            case self::CONTENT_NO_HTML:
                return $this->contentNoHtml();
            case self::CONTENT_HTML:
                return $this->contentOrigin();
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
     * pure content 반환
     * HTML 코드를 제거한 content
     *
     * @return string
     */
    public function getPureContent()
    {
        if (empty($this->pureContent) === true) {
            $this->setPureContent();
        }

        return $this->pureContent;
    }

    /**
     * 원래의 content 를 반환.
     *
     * @return string
     */
    private function contentOrigin()
    {
        return $this->__get('content');
    }

    /**
     * content 에서 html 태그를 제거한 결과 반환
     *
     * @return string
     * @todo 코드 구현해야 함
     */
    private function contentNoHtml()
    {
        return $this->__get('content');
    }

    /**
     * set user type
     *
     * @param string $userType set user type (USER, ANONYMITY, GUEST)
     * @return void
     */
    public function setUserType($userType)
    {
        $this->__set('userType', $userType);
    }

    /**
     * Set document author
     *
     * @param MemberEntityInterface $author user instance (User or Guest)
     * @return void
     */
    public function setAuthor(MemberEntityInterface $author)
    {
        $this->author = $author;
    }

    /**
     * 익명 글 설정
     *
     * @param string $anonymityWriter 익명으로 대체할 이름
     * @return void
     */
    public function anonymity($anonymityWriter = 'Anonymity')
    {
        $this->__set('writer', $anonymityWriter);

        $this->setUserType(self::USER_TYPE_ANONYMITY);
    }

    /**
     * 비회원 글 작성
     *
     * @return void
     */
    public function guest()
    {
        if ($this->certifyKey === null) {
            throw new Exceptions\DocumentEntityException;
        }

        $this->setUserType(self::USER_TYPE_GUEST);
    }

    /**
     * 비회원이 작성 글 여부 반환
     *
     * @return bool
     */
    public function isGuest()
    {
        return $this->__get('userType') == self::USER_TYPE_GUEST;
    }

    /**
     * 수정 권한 확인
     *
     * @param MemberEntityInterface $author 로그인 사용자 정보
     * @return bool
     */
    public function alterPerm(MemberEntityInterface $author)
    {
        if ($this->isGuest() === true) {
            return true;
        }

        if ($author instanceof Guest == true) {
            return false;
        }

        if ($this->__get('userId') != $author->getId()) {
            return false;
        }
        return true;
    }

    /**
     * 삭제 권한 확인
     *
     * @param MemberEntityInterface $author 로그인 사용자 정보
     * @return bool
     */
    public function deletePerm(MemberEntityInterface $author)
    {
        if ($this->isGuest() === true) {
            return true;
        }

        if ($author instanceof Guest == true) {
            return false;
        }

        if ($this->__get('userId') != $author->getId()) {
            return false;
        }
        return true;
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
            throw new Exceptions\DocumentEntityException;
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
            throw new Exceptions\DocumentEntityException;
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
            throw new Exceptions\DocumentEntityException;
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
            throw new Exceptions\DocumentEntityException;
        }
        $this->__set('published', $published);
    }
    /**
     * 승인
     *
     * @return DocumentEntity
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
     * @return DocumentEntity
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
     * @return DocumentEntity
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
     * @return DocumentEntity
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
     * @return DocumentEntity
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
     * @return DocumentEntity
     */
    public function trash()
    {
        $this->setStatus(self::STATUS_TRASH);
        // 문서를 안보이게 할 필요는 없는듯
        $this->setDisplay(self::DISPLAY_HIDDEN);
        $this->__set('deletedAt', date('Y-m-d H:i:s'));
        return $this;
    }

    /**
     * 휴지통 문서 복구
     *
     * @return DocumentEntity
     */
    public function restore()
    {
        $this->setStatus(self::STATUS_PUBLIC);
        $this->setDisplay(self::DISPLAY_VISIBLE);
        $this->__set('deletedAt', '');
        return $this;
    }

    /**
     * 임시저장
     *
     * @return DocumentEntity
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
     * @return DocumentEntity
     */
    public function notice($notice = true)
    {
        if ($notice === true) {
            $this->__set('status', self::STATUS_NOTICE);
        } else {
            $this->__set('status', self::STATUS_PUBLIC);
        }
        return $this;
    }


    /**
     * Returns unique identifier
     *
     * @return string
     */
    public function getUid()
    {
        return $this->__get('id');
    }

    /**
     * Returns instance identifier
     *
     * @return string
     */
    public function getInstanceId()
    {
        return $this->__get('instanceId');
    }

    /**
     * Returns author
     *
     * @return MemberEntityInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * get user id
     *
     * @return string
     */
    public function getUserId()
    {
        if ($this->__get('userType') == self::USER_TYPE_ANONYMITY) {
            return '';
        }
        return $this->__get('userId');
    }

    /**
     * get writer
     *
     * @return string
     */
    public function getWriter()
    {
        return $this->__get('writer');
    }


    /**
     * get member's origin id
     *
     * @return mixed
     */
    public function getMemberOriginId()
    {
        return $this->userId;
    }

    /**
     * set member entity
     *
     * @param MemberEntityInterface $entity member entity
     * @return void
     */
    public function setMemberEntity(MemberEntityInterface $entity)
    {
        $this->author = $entity;
    }
}

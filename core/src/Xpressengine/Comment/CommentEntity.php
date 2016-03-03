<?php
/**
 * This file is comment entity
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

use Xpressengine\Support\EntityTrait;
use Xpressengine\User\UserInterface;

/**
 * comment 객체
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CommentEntity
{
    use EntityTrait;

    /**
     * comment author
     *
     * @var UserInterface
     */
    protected $author;

    /**
     * hidden column
     *
     * @var array
     */
    protected $hidden = ['email', 'certifyKey', 'updatedAt', 'deletedAt'];

    /**
     * protected property when update
     *
     * @var array
     */
    protected $guarded = ['id', 'instanceId', 'targetId', 'userId'];

    /**
     * reply code character length
     *
     * @var int
     */
    protected static $replyCharlen;

    /**
     * Returns author
     *
     * @return UserInterface
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * author visible name
     *
     * @return string
     */
    public function getWriter()
    {
        return empty($this->writer) ? 'Unknown' : $this->writer;
    }

    /**
     * depth 당 문자 갯수 설정
     *
     * @param int $len 문자 갯수
     * @return void
     */
    public static function setReplyCharlen($len)
    {
        static::$replyCharlen = $len;
    }

    /**
     * depth 당 문자 갯수 반환
     *
     * @return int
     */
    public static function getReplyCharlen()
    {
        return static::$replyCharlen;
    }

    /**
     * depth 정보 반환
     *
     * @return int
     */
    public function indent()
    {
        if ($this->reply === null) {
            return 0;
        }

        return (int)(strlen($this->reply) / static::$replyCharlen);
    }

    /**
     * Visible attribute returns to array
     *
     * @return array
     */
    public function toArray()
    {
        $attributes = array_diff_key($this->getAttributes(), array_flip($this->hidden));

        $attributes['writer'] = $this->getWriter();
        $attributes['indent'] = $this->indent();

        return $attributes;
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
     * @param UserInterface $entity user entity
     * @return void
     */
    public function setMemberEntity(UserInterface $entity)
    {
        $this->author = $entity;
    }
}

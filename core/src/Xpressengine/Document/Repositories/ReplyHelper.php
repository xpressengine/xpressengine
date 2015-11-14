<?php
/**
 * ReplyHelper
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @mainpage
 * hiha
 */
namespace Xpressengine\Document\Repositories;

use Xpressengine\Document\DocumentEntity;
use Xpressengine\Document\Exceptions\ReplyLimitationException;

/**
 * ReplyHelper
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ReplyHelper
{

    /**
     * reply code character length
     *
     * @var int
     */
    protected $replyCharLen;

    /**
     * @param int $replyCharLen reply character length
     */
    public function __construct($replyCharLen)
    {
        $this->replyCharLen = $replyCharLen;
    }

    /**
     * Set reply code
     *
     * @param DocumentEntity $doc       new comment object
     * @param DocumentEntity $parent    parent comment object
     * @param string|null    $lastReply last reply character
     * @return void
     * @throws ReplyLimitationException
     */
    public function setReply(DocumentEntity &$doc, DocumentEntity $parent, $lastReply)
    {
        $doc->head = $parent->head;

        $charLen = $this->getReplyCharLen();

        $lastChar = null;
        if ($lastReply !== null) {
            $lastChar = substr($lastReply, -1 * $charLen);
        }

        $doc->reply = $parent->reply . $this->makeReplyChar($lastChar);
    }

    /**
     * Reply character length
     *
     * @return int
     */
    public function getReplyCharLen()
    {
        return $this->replyCharLen;
    }

    /**
     * Make next reply code characters
     *
     * @param string $prevChars previous child reply code character
     * @return string
     * @throws ReplyLimitationException
     */
    private function makeReplyChar($prevChars = null)
    {
        $std = '0123456789abcdefghijklmnopqrstuvwxyz';
        $std = str_split($std, 1);

        if ($prevChars === null) {
            return str_repeat($std[0], $this->getReplyCharLen());
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
}

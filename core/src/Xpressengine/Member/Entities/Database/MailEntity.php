<?php
/**
 * This file is user mail model
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
namespace Xpressengine\Member\Entities\Database;

use Xpressengine\Member\Entities\Entity;
use Xpressengine\Member\Entities\MailEntityInterface;

/**
 * 회원의 메일 정보를 저장하는 클래스이다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MailEntity extends Entity implements MailEntityInterface
{
    /**
     * 이메일 주소를 반환한다.
     *
     * @param bool $onlyEmailId true일 경우, 이메일의 `@`와 도메인을 제외한 앞부분만 반환한다.
     *
     * @return mixed
     */
    public function getAddress($onlyEmailId = false)
    {
        if ($onlyEmailId) {
            $arr = explode('@', $this->getAttribute('address'));
            return array_shift($arr);
        }
        return $this->getAttribute('address');
    }

    /**
     * Mail object를 string 형식으로 반환한다.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->address;
    }

    /**
     * 이메일을 소유한 회원의 아이디를 반환한다.
     *
     * @return string
     */
    public function getMemberId()
    {
        return $this->getAttribute('memberId');
    }
}

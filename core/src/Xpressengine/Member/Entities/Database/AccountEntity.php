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

/**
 * 사용자의 계정 정보를 저장하는 클래스
 * 각 사용자는 여러개의 계정을 가질 수 있다. 만약 한 회원이 소셜로그인을 통해 외부계정으로 로그인을 할 경우 외부계정에 대한 정보가 이 클래스 하나에 저장된다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @codeCoverageIgnore
 */
class AccountEntity extends Entity
{
}

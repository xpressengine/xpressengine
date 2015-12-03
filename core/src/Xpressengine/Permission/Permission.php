<?php
/**
 * This file is a standard permission.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Permission;

use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Entities\Guest;
use Xpressengine\Permission\Exceptions\NotSupportedException;

/**
 * permission 의 기본이 되는 추상 클래스
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
abstract class Permission
{
    /**
     * Target of permission checked
     *
     * @var mixed
     */
    protected $target;

    /**
     * User instance
     *
     * @var MemberEntityInterface
     */
    protected $user;

    /**
     * Supported action keyword of current permission
     *
     * @var array
     */
    protected $actions = [];

    /**
     * 요청한 action 을 처리할 수 있는 권한이 있는지 확인 함.
     *
     * @param string   $action   action keyword
     * @param callable $callable side checker
     * @return bool
     * @throws NotSupportedException
     */
    public function ables($action, callable $callable = null)
    {
        if ($this->support($action) === false) {
            throw new NotSupportedException(['name' => $action]);
        }

        if (is_callable($callable) && call_user_func_array($callable, [$this->target, $this->user]) === true) {
            return true;
        }

        return $this->judge($action);
    }

    /**
     * 권한 유무 판별
     *
     * @param string $action action keyword
     * @return bool
     */
    abstract protected function judge($action);

    /**
     * 'ables' 반대 기능
     *
     * @param string   $action   action keyword
     * @param callable $callable side checker
     * @return bool
     */
    public function unables($action, callable $callable = null)
    {
        return $this->ables($action, $callable) === false;
    }

    /**
     * 현재 객체가 판별할 수 있는 action 목록
     *
     * @return array
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * 요청한 action 을 현재 permission 에서 체크 가능한지 여부 판별
     *
     * @param string $action action keyword
     * @return bool
     */
    protected function support($action)
    {
        return array_search($action, array_merge($this->actions, Action::all())) !== false;
    }

    /**
     * 전달된 사용자가 guest 인지 확인
     *
     * @return bool
     */
    protected function isGuest()
    {
        return $this->user instanceof Guest;
    }

    /**
     * 권한체크할 대상 사용자를 지정
     *
     * @param MemberEntityInterface $user user instance
     * @return void
     */
    public function setUser(MemberEntityInterface $user)
    {
        $this->user = $user;
    }
}

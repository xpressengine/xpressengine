<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User;

use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\SessionGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Xpressengine\Support\Exceptions\AccessDeniedHttpException;
use Xpressengine\User\Models\Guest;
use Xpressengine\User\Models\User;

/**
 * 이 클래스는 Xpressengine의 회원 인증 기능을 처리하는 클래스이다.
 * 이 클래스의 주요 기능은 사용자를 로그인, 현재 로그인된 사용자의 로그아웃,
 * 로그인된 사용자의 정보를 반환하는 역할을 한다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Guard extends SessionGuard implements GuardInterface
{
    /**
     * @var array admin auth config
     */
    private $adminAuthConfig;

    /**
     * Create a new authentication guard.
     *
     * @param string       $name            gurad name
     * @param UserProvider $provider        user provider
     * @param Session      $session         session store
     * @param array        $adminAuthConfig adminauth config
     * @param Request      $request         request
     *
     * @return void
     */
    public function __construct(
        $name,
        UserProvider $provider,
        Session $session,
        $adminAuthConfig,
        Request $request = null
    ) {
        $this->adminAuthConfig = $adminAuthConfig;
        parent::__construct($name, $provider, $session, $request);
    }

    /**
     * 관리자 인증 검사
     *
     * @param bool $refresh 인증 세션 시간 갱신 여부
     *
     * @return mixed
     */
    public function checkAdminAuth($refresh = false)
    {
        $key = $this->adminAuthConfig['session'];
        $expire = $this->adminAuthConfig['expire'];
        if ($expire === 0) {
            return true;
        }

        $now = time();
        $timeout = $this->session->get($key, false);
        if ($timeout !== false && $timeout > $now) {
            if ($refresh) {
                $this->refreshAdminAuth();
            }
            return true;
        }
        return false;
    }

    /**
     * 관리자 인증 시도
     *
     * @param array $credentials 인증 정보
     *
     * @return mixed
     */
    public function attemptAdminAuth($credentials)
    {
        if ($this->checkAdminAuth(true)) {
            return true;
        }
        $password = $credentials['password'];

        if ($password && $this->adminAuthConfig['password'] === $password) {
            $this->refreshAdminAuth();
            return true;
        }
        return false;
    }

    /**
     * 관리자 인증 상태 세션의 유효기간 갱신
     *
     * @return void
     */
    protected function refreshAdminAuth()
    {
        $key = $this->adminAuthConfig['session'];
        $expire = $this->adminAuthConfig['expire'];
        $time = time() + ($expire * 60);
        $this->session->put($key, $time);
    }

    /**
     * 관리자 인증 상태 세션의 유효기간 갱신 삭제
     *
     * @return void
     */
    protected function clearAdminAuth()
    {
        $key = $this->adminAuthConfig['session'];
        $this->session->remove($key);
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     *
     * @throws AccessDeniedHttpException
     */
    public function authenticate()
    {
        $user = $this->user();
        if ($user instanceof User) {
            return $user;
        }

        throw new AccessDeniedHttpException();
    }

    /**
     * 현재 사용자의 로그인 여부를 체크한다.
     *
     * @return bool 로그인 상태일 경우 true, 로그아웃 상태일 경우 false를 반환
     */
    public function check()
    {
        return !is_null(parent::user());
    }

    /**
     * 현재 로그인한 사용자의 정보를 반환한다.
     * 만약 로그인한 사용자가 없을 경우 Guest의 인스턴스를 반환한다.
     *
     * @return UserInterface
     */
    public function user()
    {
        return parent::user() ?: $this->makeGuest();
    }

    /**
     * 현재 로그인한 사용자의 id를 반환한다.
     *
     * @return mixed 로그인 사용자의 id
     */
    public function id()
    {
        if ($this->loggedOut) {
            return null;
        }

        $recaller = $this->recaller();
        $id = $this->session->get($this->getName(), $recaller ? $recaller->id() : null);

        if (is_null($id) && $this->check()) {
            $id = $this->user()->getAuthIdentifier();
        }

        return $id;
    }

    /**
     * 현재 로그인한 사용자를 로그아웃 시킨다.
     *
     * @return void
     */
    public function logout()
    {
        $user = $this->user();

        // If we have an event dispatcher instance, we can fire off the logout event
        // so any further processing can be done. This allows the developer to be
        // listening for anytime a user signs out of this application manually.
        $this->clearUserDataFromStorage();
        $this->clearAdminAuth();

        if ($this->check()) {
            $this->cycleRememberToken($user);
        }

        if (isset($this->events)) {
            $this->events->dispatch(new Logout($user));
        }

        // Once we have fired the logout event we will clear the users out of memory
        // so they are no longer available as the user is no longer considered as
        // being signed into this application and should not be available here.
        $this->user = $this->makeGuest();

        $this->loggedOut = true;
    }

    /**
     * Guest 회원 인스턴스를 생성하여 반환한다.
     * Guest 회원 인스턴스는 보통 로그아웃 상태인 회원을 위해 사용된다.
     *
     * @return Guest
     */
    public function makeGuest()
    {
        return new Guest();
    }
}

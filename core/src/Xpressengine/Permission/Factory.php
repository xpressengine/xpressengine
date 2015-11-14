<?php
/**
 * This file is a provided permission factory.
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

use Closure;
use Illuminate\Auth\AuthManager;
use Illuminate\Routing\RouteCollection;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Permission\Permissions\RoutePermission;
use Xpressengine\Permission\Permissions\InstancePermission;
use Xpressengine\Permission\Exceptions\InvalidArgumentException;
use Xpressengine\Permission\Exceptions\NotMatchedInstanceException;

/**
 * # Factory
 * 요청에 맞는 적절한 타입의 permission 객체를 제공해주는
 * 패키지 메인 클래스.
 *
 * ### app binding : xe.permission 으로 바인딩 되어 있음
 * Permission Facade 로 접근 가능
 *
 * ### Usage
 * #### register
 * * 권한 등록
 * ```php
 * $grant = new Xpressengine\Permission\Grant();
 * $grant->set('access', 'guest');
 * $grant->set('create', 'member');
 * $grant->set('read', 'guest');
 * $grant->set('update', 'group', ['group_id_1', 'group_id_2']);
 * $grant->add('update', 'user', ['user_id_1', 'user_id_2']);
 * $grant->set('delete', [
 *  'rating' => 'super',
 *  'group' => ['group_id_1', 'group_id_2'],
 *  'user' => ['user_id_1', 'user_id_2'],
 * ]);
 * // 저장소에 등록
 * Permission::register('instance', 'board.qna', $grant);
 * ```
 *
 * * 제외
 * ```php
 * // except 메서드를 사용해 특정 사용자의 권한을 제외시킬 수 있다.
 * // except 는 사용자 아이디만 등록 되어진다.
 * $grant->except('access', ['user_id_1', 'user_id_2']);
 * ```
 *
 * #### check
 * * basic
 * ```php
 * $permission = Permission::instance('board.qna');
 * if ($permission->unables(Action::CREATE)) {
 *  // user has not grant at given action
 * }
 * ```
 *
 * * 사용자 지정
 * ```php
 * $user = Member::find($id);
 * $permission = Permission::instance('board.qna', $user);
 * ```
 * > user 가 지정되지 않으면 현재 로그인 한 user 를 대상으로 함
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Factory
{
    /**
     * Authenticator instance
     *
     * @var AuthManager
     */
    protected $auth;

    /**
     * RouteCollection instance
     *
     * @var RouteCollection
     */
    protected $routes;

    /**
     * Repository instance
     *
     * @var PermissionRepository
     */
    protected $repo;

    /**
     * Permission extend list
     *
     * @var array
     */
    protected $extends = [];

    /**
     * Constructor
     *
     * @param AuthManager          $auth   Authenticator instance
     * @param RouteCollection      $routes RouteCollection instance
     * @param PermissionRepository $repo   Repository instance
     */
    public function __construct(AuthManager $auth, RouteCollection $routes, PermissionRepository $repo)
    {
        $this->auth   = $auth;
        $this->routes = $routes;
        $this->repo   = $repo;
    }

    /**
     * Make a permission instance
     *
     * @param string                $type    type string
     * @param mixed                 $target  a target of check has grant
     * @param MemberEntityInterface $user    user instance
     * @param string                $siteKey site key
     * @return Permission
     * @throws NotMatchedInstanceException
     */
    public function make($type, $target, MemberEntityInterface $user = null, $siteKey = 'default')
    {
        $permission = $this->resolve($type, $target, $user, $siteKey);

        if ($permission instanceof Permission === false) {
            throw new NotMatchedInstanceException(['type' => $type]);
        }

        return $permission;
    }

    /**
     * Resolve a permission instance
     *
     * @param string                $type    type string
     * @param mixed                 $target  a target of check has grant
     * @param MemberEntityInterface $user    user instance
     * @param string                $siteKey site key
     * @return Permission
     * @throws InvalidArgumentException
     */
    protected function resolve($type, $target, MemberEntityInterface $user = null, $siteKey = 'default')
    {
        $user = $user ?: $this->auth->user();

        $registered = null;
        if (is_string($target) === true) {
            $registered = $this->findRegistered($type, $target, true, $siteKey);
        }

        // extended type resolve code
        if (isset($this->extends[$type]) === true) {
            return $this->extends[$type]($target, $user, $registered);
        }

        switch ($type) {
            case 'route':
                $route = $this->routes->getByName($target);
                return new RoutePermission($route, $user, $registered);
                break;
            case 'instance':
                return new InstancePermission($target, $user, $registered);
                break;
        }

        throw new InvalidArgumentException(['name' => 'type', 'value' => $type]);
    }

    /**
     * Make permission instances by type
     *
     * @param string                $type    type string
     * @param MemberEntityInterface $user    user instance
     * @param string                $siteKey site key
     * @return Permission[]
     * @throws NotMatchedInstanceException
     */
    public function makesByType($type, MemberEntityInterface $user = null, $siteKey = 'default')
    {
        $user = $user ?: $this->auth->user();

        $permissions = [];
        $registereds = $this->repo->fetchByType($siteKey, $type);
        foreach ($registereds as $registered) {
            $ancestors = array_filter($registereds, function ($item) use ($registered) {
                $itemNames = explode('.', $item->name);
                $registeredNames = explode('.', $registered->name);
                if (count($itemNames) >= count($registeredNames)) {
                    return false;
                }

                for ($i = 0; $i < count($itemNames); $i++) {
                    if ($itemNames[$i] !== $registeredNames[$i]) {
                        return false;
                    }
                }

                return true;
            });

            if (count($ancestors) > 0) {
                uasort($ancestors, [$this, 'cmp']);
            }

            foreach ($ancestors as $ancestor) {
                $registered->addParent($ancestor);
            }

            if (isset($this->extends[$type]) === true) {
                $permission = $this->extends[$type]($registered->name, $user, $registered);
                if ($permission instanceof Permission === false) {
                    throw new NotMatchedInstanceException(['type' => $type]);
                }
                $permissions[$registered->name] = $permission;
            } else {
                switch ($type) {
                    case 'route':
                        $route = $this->routes->getByName($registered->name);
                        $permissions[$registered->name] = new RoutePermission($route, $user, $registered);
                        break;
                    case 'instance':
                        $permissions[$registered->name] = new InstancePermission($registered->name, $user, $registered);
                        break;
                }
            }
        }

        return $permissions;
    }

    /**
     * Make a route permission
     *
     * @param string                $name    route name, used 'as' keyword
     * @param MemberEntityInterface $user    user instance
     * @param string                $siteKey site key
     * @return RoutePermission
     */
    public function route($name, MemberEntityInterface $user = null, $siteKey = 'default')
    {
        return $this->make('route', $name, $user, $siteKey);
    }

    /**
     * Make a instance permission
     *
     * @param string                $name    instance name
     * @param MemberEntityInterface $user    user instance
     * @param string                $siteKey site key
     * @return InstancePermission
     */
    public function instance($name, MemberEntityInterface $user = null, $siteKey = 'default')
    {
        return $this->make('instance', $name, $user, $siteKey);
    }

    /**
     * Set a parent Registered to given Registered
     *
     * @param Registered $registered registered instance
     *
     * @return void
     */
    protected function setAncestor(Registered &$registered)
    {
        $ancestors = $this->repo->fetchAncestor($registered);
        uasort($ancestors, [$this, 'cmp']);

        foreach ($ancestors as $ancestor) {
            $registered->addParent($ancestor);
        }
    }

    /**
     * For sort
     *
     * @param Registered $a registered instance
     * @param Registered $b registered instance
     *
     * @return int
     */
    private function cmp(Registered $a, Registered $b)
    {
        $aLen = count(explode('.', $a->name));
        $bLen = count(explode('.', $b->name));

        if ($aLen == $bLen) {
            return 0;
        }

        return $aLen > $bLen ? -1 : 1;
    }

    /**
     * Register grants information
     *
     * @param string $type    permission type
     * @param string $name    target name
     * @param Grant  $grant   grant instance
     * @param string $siteKey site key
     * @return Registered
     */
    public function register($type, $name, Grant $grant, $siteKey = 'default')
    {
        $registered = $this->findRegistered($type, $name, true, $siteKey);

        $registered->setGrant($grant);

        if (empty($registered->getOriginal()) === true) {
            $registered = $this->repo->insert($registered);
        } else {
            $registered = $this->repo->update($registered);
        }

        return $registered;
    }

    /**
     * Get a registered, if not exists be created
     *
     * @param string $type    permission type
     * @param string $name    target name
     * @param bool   $new     make new object when not exists
     * @param string $siteKey site key
     * @return Registered|null
     */
    public function findRegistered($type, $name, $new = false, $siteKey = 'default')
    {
        $registered = $this->repo->findByTypeAndName($siteKey, $type, $name);
        if ($registered === null && $new === true) {
            $registered       = new Registered();
            $registered->siteKey = $siteKey;
            $registered->type = $type;
            $registered->name = $name;
        }

        if ($registered !== null) {
            $this->setAncestor($registered);
        }

        return $registered;
    }

    /**
     * Remove a registered
     *
     * @param string $type    permission type
     * @param string $name    target name
     * @param string $siteKey site key
     * @return void
     */
    public function removeRegistered($type, $name, $siteKey = 'default')
    {
        $registered = $this->repo->findByTypeAndName($siteKey, $type, $name);

        if ($registered !== null) {
            $this->repo->delete($registered);
        }
    }

    /**
     * Extend permission type
     *
     * @param string  $type    permission type
     * @param Closure $closure permission maker
     *
     * @return void
     */
    public function extend($type, Closure $closure)
    {
        $this->extends[$type] = $closure;
    }

    /**
     * Move entity hierarchy to new parent or root
     *
     * @param Registered  $registered registered object
     * @param string|null $to         to registered prefix
     *
     * @return void
     * @throws InvalidArgumentException
     */
    public function move(Registered $registered, $to = null)
    {
        $toParent = $to !== null ? $this->repo->findByTypeAndName($registered->siteKey, $registered->type, $to) : null;

        if (($to !== null && $toParent === null)
            || ($toParent !== null && $registered->type != $toParent->type)) {
            throw new InvalidArgumentException();
        }

        $parent = $registered->getParent();

        if ($parent === null) {
            if ($registered->getDepth() !== 1) {
                throw new InvalidArgumentException();
            }

            $this->repo->affiliate($registered, $to);
        } else {
            $this->repo->foster($registered, $to);
        }
    }
}

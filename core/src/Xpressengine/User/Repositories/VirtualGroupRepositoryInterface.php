<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\User\Repositories;

use Xpressengine\User\Models\UserVirtualGroup;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface VirtualGroupRepositoryInterface
{

    /**
     * 주어진 id에 해당하는 가상그룹 정보를 반환한다.
     *
     * @param string $id 조회할 가상그룹 id
     *
     * @return UserVirtualGroup
     */
    public function find($id);

    /**
     * 가상그룹 이름으로 가상그룹을 조회한다.
     *
     * @param string $title 가상그룹 이름
     *
     * @return UserVirtualGroup|null
     */
    public function findByTitle($title);

    /**
     * 회원이 소속된 가상그룹 목록을 조회한다.
     *
     * @param string $userId 회원아이디
     *
     * @return array
     */
    public function findByUserId($userId);

    /**
     * 모든 가상그룹 목록을 반환한다.
     *
     * @return array
     */
    public function all();

    /**
     * 주어진 id를 가진 가상 그룹이 있는지의 여부를 반환한다.
     *
     * @param string $id 조회할 가상그룹 id
     *
     * @return bool
     */
    public function has($id);
}

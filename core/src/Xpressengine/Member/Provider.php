<?php
/**
 *  This file is part of the Xpressengine package.
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
namespace Xpressengine\Member;

use Illuminate\Contracts\Auth\Authenticatable as BaseAuthenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Hashing\Hasher;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;

/**
 * 이 클래스는 Auth(Guard)에 회원정보를 제공하는 역할을 한다.
 * 내부적으로는 MemberRepositoryInterface를 주입받아 회원정보를 조회할 때 사용한다.
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Provider implements UserProvider
{
    /**
     * @var MemberRepositoryInterface 회원정보 저장소
     */
    protected $repo;

    /**
     * @var Hasher 비밀번호의 유효성검사를 위해 사용한다.
     */
    private $hasher;

    /**
     * 생성자
     *
     * @param MemberRepositoryInterface $memberRepo 회원정보 저장소
     * @param Hasher                    $hasher     해시코드 생성기, 비밀번호 유효성 검사를 위해 사용됨
     */
    public function __construct(MemberRepositoryInterface $memberRepo, Hasher $hasher)
    {
        $this->repo = $memberRepo;
        $this->hasher = $hasher;
    }

    /**
     * Retrieve a user by their unique identifier.
     *
     * @param  mixed $identifier member's id
     *
     * @return Authenticatable|null member entity
     */
    public function retrieveById($identifier)
    {
        return $this->repo->find($identifier, ['groups', 'mails', 'pending_mails', 'accounts']);
    }

    /**
     * Retrieve a user by by their unique identifier and "remember me" token.
     *
     * @param  mixed  $identifier member's id
     * @param  string $token      remember token
     *
     * @return Authenticatable|null member entity
     */
    public function retrieveByToken($identifier, $token)
    {
        return $this->repo->fetchOne(
            ['id' => $identifier, 'rememberToken' => $token],
            ['groups', 'mails', 'pending_mails', 'accounts']
        );
    }

    /**
     * Update the "remember me" token for the given user in storage.
     *
     * @param  BaseAuthenticatable $member member entity
     * @param  string              $token  token for update
     *
     * @return void
     */
    public function updateRememberToken(BaseAuthenticatable $member, $token)
    {
        $member->setRememberToken($token);

        $this->repo->update($member);
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials credentials for retrieving
     *
     * @return Authenticatable|null member entity
     */
    public function retrieveByCredentials(array $credentials)
    {
        $where = [];
        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                $where[$key] = $value;
            }
        }

        $member = null;
        $emailPrefix = null;

        // retrieve by email
        if (isset($where['email'])) {
            // only prefix given
            if (!str_contains($where['email'], '@')) {
                $emailPrefix = $where['email'];
                $members = $this->repo->searchByEmailPrefix(
                    $emailPrefix,
                    ['groups', 'mails', 'pending_mails', 'accounts']
                );
                if (count($members) === 1) {
                    $member = $members[0];
                } else {
                    return null;
                }
            } else {
                $member = $this->repo->findByEmail($where['email'], ['groups', 'mails', 'pending_mails', 'accounts']);
            }

            unset($where['email']);

            if ($member === null) {
                return null;
            }
            foreach ($where as $key => $value) {
                if ($member->$key !== $value) {
                    return null;
                }
            }
        }

        if ($member === null) {
            $member = $this->repo->fetchOne($where, ['groups', 'mails', 'pending_mails', 'accounts']);
        }

        if ($member instanceof \Xpressengine\Member\Authenticatable and isset($credentials['email'])) {
            if ($emailPrefix === null) {
                $member->setEmailForPasswordReset($credentials['email']);
            }
        }

        return $member;
    }

    /**
     * Validate a user against the given credentials.
     *
     * @param  BaseAuthenticatable $member      member entity
     * @param  array               $credentials credentials for validating
     *
     * @return bool result of validation
     */
    public function validateCredentials(BaseAuthenticatable $member, array $credentials)
    {
        $plain = $credentials['password'];
        return $this->hasher->check($plain, $member->getAuthPassword());
    }
}

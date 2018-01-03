<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User;

use Illuminate\Auth\EloquentUserProvider;

/**
 * 이 클래스는 Auth(Guard)에 회원정보를 제공하는 역할을 한다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class UserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials credentials for retrieving
     *
     * @return Authenticatable|null user entity
     */
    public function retrieveByCredentials(array $credentials)
    {
        $query = $this->createModel()->newQuery();

        $where = [];
        foreach ($credentials as $key => $value) {
            if (!str_contains($key, 'password')) {
                $where[$key] = $value;
            }
        }

        $user = null;
        $emailPrefix = null;

        // retrieve by email
        if (isset($where['email'])) {
            $email = $where['email'];

            // only prefix given
            if (!str_contains($email, '@')) {
                $emailPrefix = $email;

                $query = $query->whereHas(
                    'emails',
                    function ($q) use ($emailPrefix) {
                        $q->where('address', 'like', $emailPrefix.'@%');
                    }
                )->get();

                if (count($query) === 1) {
                    $user = $query->first();
                } else {
                    return null;
                }
            } else {
                $user = $query->whereHas(
                    'emails',
                    function ($q) use ($email) {
                        $q->where('address', $email);
                    }
                )->first();
            }

            unset($where['email']);

            // when no user having email
            if ($user === null) {
                return null;
            }

            // check other fields
            foreach ($where as $key => $value) {
                if ($user->$key !== $value) {
                    return null;
                }
            }

            // password reset을 위한 요청일 때를 위하여 필요한 email 필드를 지정해 줌
            if ($user instanceof Authenticatable) {
                if ($emailPrefix === null) {
                    $user->setEmailForPasswordReset($credentials['email']);
                }
            }
        }

        if ($user === null) {
            // retrieve user without email
            foreach ($where as $key => $value) {
                if (strpos($key, 'password') === false) {
                    $query->where($key, $value);
                }
            }
            $user = $query->first();
        }

        return $user;
    }
}

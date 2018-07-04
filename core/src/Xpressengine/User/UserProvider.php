<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
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
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Xpressengine\User\Contracts\CanResetPassword;
use Xpressengine\User\Events\UserRetrievedEvent;

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
    public $dispatcher;
    /**
     * Create a new database user provider.
     *
     * @param \Illuminate\Contracts\Hashing\Hasher    $hasher     hasher
     * @param string                                  $model      model
     * @param \Illuminate\Contracts\Events\Dispatcher $dispatcher dispatcher
     * @return void
     */
    public function __construct(HasherContract $hasher, $model, Dispatcher $dispatcher)
    {
        parent::__construct($hasher, $model);
        $this->dispatcher = $dispatcher;
    }

    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials credentials for retrieving
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null user entity
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
            unset($where['email']);

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
                }
            } else {
                $user = $query->whereHas(
                    'emails',
                    function ($q) use ($email) {
                        $q->where('address', $email);
                    }
                )->first();
            }

            if ($user !== null) {
                // check other fields
                foreach ($where as $key => $value) {
                    if ($user->$key !== $value) {
                        $user = null;
                    }
                }
            }

            // password reset을 위한 요청일 때를 위하여 필요한 email 필드를 지정해 줌
            if ($user instanceof CanResetPassword) {
                if ($emailPrefix === null) {
                    $user->setEmailForPasswordReset($credentials['email']);
                }
            }
        } else {
            // retrieve user without email
            foreach ($where as $key => $value) {
                if (strpos($key, 'password') === false) {
                    $query->where($key, $value);
                }
            }
            $user = $query->first();
        }

        $this->dispatcher->dispatch(new UserRetrievedEvent($user, $credentials));

        return $user;
    }
}

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
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

        if (isset($where['status']) == true) {
            $where['status'] = is_array($where['status']) ? $where['status'] : [$where['status']];
        }

        $user = null;
        $emailPrefix = null;

        // retrieve by email
        if (isset($where['email'])) {
            $email = $where['email'];
            unset($where['email']);

            //login_id를 사용해서 로그인
            if (!str_contains($email, '@')) {
                $user = $query->where('login_id', $email)->first();
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
                    if ($key === 'status') {
                        if (in_array($user->status, $value)) {
                            continue;
                        }
                    } else {
                        if ($user->$key === $value) {
                            continue;
                        }
                    }

                    $user = null;
                    break;
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
                    if ($key === 'status') {
                        $query->whereIn($key, $value);
                    } else {
                        $query->where($key, $value);
                    }
                }
            }
            $user = $query->first();
        }

        $this->dispatcher->dispatch(new UserRetrievedEvent($user, $credentials));

        return $user;
    }
}

<?php
/**
 * UserEmail
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

namespace Xpressengine\User\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\EmailInterface;
use Xpressengine\User\Exceptions\AlreadyConfirmedEmailException;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserEmail extends DynamicModel implements EmailInterface
{
    /**
     * @var string
     */
    protected $table = 'user_email';

    /**
     * @var bool
     */
    protected $dynamic = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'address'
    ];

    /**
     * set relationship with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 이메일 주소를 반환한다.
     *
     * @param  bool  $onlyEmailId  true일 경우, 이메일의 `@`와 도메인을 제외한 앞부분만 반환한다.
     *
     * @return mixed
     */
    public function getAddress($onlyEmailId = false)
    {
        return $this->getAttribute('address');
    }

    /**
     * 이메일을 소유한 회원의 아이디를 반환한다.
     *
     * @return string
     */
    public function getUserId()
    {
        $user = $this->getAttribute('user');
        return $user->getId();
    }

    /**
     * 메일의 인증코드를 반환한다.
     *
     * @return bool
     */
    public function getConfirmationCode()
    {
        throw new AlreadyConfirmedEmailException();
    }

    /**
     * 인증된 메일인지 확인한다
     *
     * @return bool
     */
    public function isConfirmed()
    {
        return true;
    }
}

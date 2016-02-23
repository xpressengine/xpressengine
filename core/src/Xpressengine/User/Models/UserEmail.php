<?php
/**
 * UserEmail
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
namespace Xpressengine\User\Models;

use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\Member\Exceptions\AlreadyConfirmedEmailException;
use Xpressengine\User\EmailInterface;
use Xpressengine\User\EmailProviderInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserEmail extends DynamicModel implements EmailInterface, EmailProviderInterface
{
    protected $table = 'user_email';

    protected $dynamic = false;

    protected $fillable = [
        'userId',
        'address'
    ];

    /**
     * set relationship with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    /**
     * 이메일 주소를 반환한다.
     *
     * @param bool $onlyEmailId true일 경우, 이메일의 `@`와 도메인을 제외한 앞부분만 반환한다.
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
    public function getMemberId()
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
     * 이메일 주소로 등록대기 이메일 정보를 조회한다.
     *
     * @param string   $address 조회할 이메일 주소
     * @param string[] $with    entity와 함께 반환할 relation 정보
     *
     * @return UserEmail
     */
    public function findByAddress($address, $with = [])
    {
        return static::where('address', $address)->with($with)->first();
    }

    /**
     * 주어진 회원이 소유한 이메일 목록을 조회한다.
     *
     * @param string        $userId user id
     * @param string[]|null $with   entity와 함께 반환할 relation 정보
     *
     * @return PendingEmail[]
     */
    public function findByMember($userId, $with = null)
    {
        return static::where('userId', $userId)->with($with)->get();
    }

    /**
     * 주어진 회원이 소유한 이메일을 삭제한다.
     *
     * @param string $userIds 삭제할 이메일을 소유한 회원의 id
     *
     * @return integer
     */
    public function deleteByMemberIds($userIds)
    {
        return static::whereIn('userId', $userIds)->delete();
    }

    /**
     * 주어진 회원이 소유한 이메일의 인증 코드를 반환한다.
     *
     * @param string        $memberId member id
     * @param string        $code     mail confirmation code
     * @param string[]|null $with     entity와 함께 반환할 relation 정보
     *
     * @return EmailInterface
     */
    public function findByConfirmationCode($memberId, $code, $with = null)
    {
        throw new AlreadyConfirmedEmailException();
    }
}

<?php
/**
 * UserAccount
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
use Xpressengine\User\AccountInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserAccount extends DynamicModel implements AccountInterface
{

    protected $table = 'user_account';

    public $incrementing = false;

    protected $fillable = [
        'userId',
        'address'
    ];

    /**
     * @var bool use dynamic query
     */
    protected $dynamic = false;

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
     * 계정을 소유한 회원의 아이디를 반환한다.
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->getAttribute('userId');
    }

    /**
     * 계정의 밴더를 반환한다.
     *
     * @return string
     */
    public function getProvider()
    {
        return $this->getAttribute('provider');
    }

    /**
     * 계정에 할당된 이메일 주소를 반환한다.
     *
     * @return string|null
     */
    public function getEmailAddress()
    {
        return $this->getAttribute('email');
    }
}

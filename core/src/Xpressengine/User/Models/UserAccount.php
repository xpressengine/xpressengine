<?php
/**
 * UserAccount
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
use Xpressengine\User\AccountInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserAccount extends DynamicModel implements AccountInterface
{

    protected $table = 'user_account';

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'email',
        'account_id',
        'provider',
        'token',
        'token_secret',
        'data'
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
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 계정을 소유한 회원의 아이디를 반환한다.
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->getAttribute('user_id');
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

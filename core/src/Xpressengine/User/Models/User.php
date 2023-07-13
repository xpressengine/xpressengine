<?php
/**
 * User
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

use Closure;
use Illuminate\Auth\Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Xpressengine\User\Contracts\CanResetPassword as CanResetPasswordContract;
use Xpressengine\User\Notifications\ResetPassword as ResetPasswordNotification;
use Xpressengine\Database\Eloquent\DynamicModel;
use Xpressengine\User\Rating;
use Xpressengine\User\UserInterface;

/**
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class User extends DynamicModel implements
    UserInterface,
    AuthenticatableContract,
    CanResetPasswordContract,
    AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use Notifiable;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string
     */
    protected $table = 'user';

    /**
     * @var bool use dynamic query
     */
    protected $dynamic = true;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var string[]
     */
    protected $dates = [
        'password_updated_at',
        'login_at'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'email',
        'login_id',
        'display_name',
        'password',
        'rating',
        'status',
        'introduction',
        'profile_image_id',
        'password_updated_at'
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'display_name',
        'introduction',
        'profileImage'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profileImage'
    ];

    /**
     * @var \Closure 회원의 프로필 이미지 Resolver.
     * 프로필 이미지 아이디에 해당하는 프로필 이미지 URL을 반환한다.
     */
    protected static $profileImageResolver;

    /**
     * @var string 비밀번호 초기화 요청을 처리할 때, 입력된 이메일을 저장함
     */
    protected $emailForPasswordReset;

    /**
     * @var string getDisplayName()메소드가 실행될 때 사용할 필드
     */
    public static $displayField = 'display_name';

    public const STATUS_ACTIVATED = 'activated';
    public const STATUS_DENIED = 'denied';
    public const STATUS_PENDING_ADMIN = 'pending_admin';
    public const STATUS_PENDING_EMAIL = 'pending_email';

    /**
     * @var array
     */
    public static $status = [
        self::STATUS_DENIED,
        self::STATUS_ACTIVATED,
        self::STATUS_PENDING_ADMIN,
        self::STATUS_PENDING_EMAIL
    ];

    /**
     * User constructor.
     *
     * @param  array  $attributes  attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->setProxyOptions(['group' => 'user']);
        $dynamicAttributes = app('xe.dynamicField')->getDynamicAttributes('user');
        $this->makeVisible($dynamicAttributes);
        parent::__construct($attributes);
    }

    /**
     * setProfileImageResolver
     *
     * @param  Closure  $callback  회원의 프로필 이미지를 처리하기 위한 resolver
     *
     * @return void
     */
    public static function setProfileImageResolver(Closure $callback)
    {
        static::$profileImageResolver = $callback;
    }

    /**
     * set relationship with user groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allSiteGroups()
    {
        return $this->belongsToMany(UserGroup::class, 'user_group_user', 'user_id', 'group_id');
    }

    /**
     * set relationship with user groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        $site_key = $this->site_key ?? \XeSite::getCurrentSiteKey();

        return $this->belongsToMany(UserGroup::class, 'user_group_user', 'user_id', 'group_id')->where(
            'site_key',
            $site_key
        );
    }

    /**
     * set relationship with user accounts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasMany(UserAccount::class, 'user_id');
    }

    /**
     * set relationship with emails
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emails()
    {
        return $this->hasMany(UserEmail::class, 'user_id');
    }

    /**
     * set relationship with pendingEmail
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pendingEmail()
    {
        return $this->hasOne(PendingEmail::class, 'user_id');
    }

    /**
     * set relationship with user term agrees
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function allSiteAgreedTerms()
    {
        return $this->belongsToMany(Term::class, 'user_term_agrees', 'user_id', 'term_id');
    }

    /**
     * set relationship with user term agrees
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function agreedTerms()
    {
        $site_key = $this->site_key ?? \XeSite::getCurrentSiteKey();
        return $this->belongsToMany(Term::class, 'user_term_agrees', 'user_id', 'term_id')->where(
            'user_terms.site_key',
            $site_key
        )->whereNull('user_term_agrees.deleted_at');
    }

    /**
     * Get profile_image
     *
     * @return string
     */
    public function getProfileImageAttribute()
    {
        return $this->getProfileImage();
    }

    /**
     * Get the e-mail address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset()
    {
        // 만약 로그인시 사용된 이메일이 따로 지정돼 있을 경우 그 이메일을 사용한다.
        return $this->emailForPasswordReset ?? $this->email;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token  token for password reset
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * setEmailForPasswordReset() 메소드에서 반환할 email 정보를 지정한다.
     *
     * @param  string  $email  지정할 email주소
     *
     * @return void
     */
    public function setEmailForPasswordReset($email)
    {
        $this->emailForPasswordReset = $email;
    }

    /**
     * Get the unique identifier
     *
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }

    /**
     * Get the name for display
     *
     * @return string
     */
    public function getDisplayName()
    {
        $field = static::$displayField;

        if (app('xe.config')->getVal('user.register.use_display_name') === false) {
            $field = app('xe.user')->isUseLoginId() === true ? 'login_id' : 'email';
        }

        return $this->getAttribute($field);
    }

    /**
     * Get the rating of user
     *
     * @return string
     */
    public function getRating()
    {
        return $this->getAttribute('rating');
    }

    /**
     * Finds whether user has super rating.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->getRating() === Rating::SUPER;
    }

    /**
     * Finds whether user has manager or super rating.
     *
     * @return bool
     */
    public function isManager()
    {
        return Rating::compare($this->getRating(), Rating::MANAGER) >= 0;
    }

    /**
     * Get the status of user
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->getAttribute('status');
    }

    /**
     * Get profile image URL of user
     *
     * @return string
     */
    public function getProfileImage()
    {
        $resolver = static::$profileImageResolver;
        return $resolver($this->profile_image_id);
    }

    /**
     * Get groups a user belongs
     *
     * @return array
     */
    public function getGroups()
    {
        return $this->getAttribute('groups') ?: [];
    }

    /**
     * Get Pending Email of current user
     *
     * @return PendingEmail
     */
    public function getPendingEmail()
    {
        return $this->pendingEmail;
    }

    /**
     * 회원이 소유한 계정 중에 주어진 provider를 가진 계정을 반환한다.
     *
     * @param  string  $provider  provider
     *
     * @return UserAccount
     */
    public function getAccountByProvider(string $provider)
    {
        foreach ($this->getAttribute('accounts') as $account) {
            if ($account->provider === $provider) {
                return $account;
            }
        }

        return null;
    }

    /**
     * add this user to groups
     *
     * @param  mixed  $groups  groups
     *
     * @return static
     */
    public function joinGroups($groups)
    {
        // todo: increment group's count!!
        $this->groups()->attach($groups);
        return $this;
    }

    /**
     * leave groups
     *
     * @param  array  $groups  groups
     *
     * @return static
     */
    public function leaveGroups(array $groups)
    {
        // todo: decrement group's count!!
        $this->groups()->detach($groups);
        return $this;
    }

    /**
     * 최종 로그인 시간을 기록한다.
     *
     * @param  mixed  $time  로그인 시간
     *
     * @return void
     */
    public function setLoginTime($time = null)
    {
        if ($time === null) {
            $time = $this->freshTimestamp();
        }
        $this->login_at = $time;
    }

    /**
     * loginAt 처리, loginAt이 지정되지 않았을 경우, null을 반환하도록 처리한다.
     *
     * @param  string  $value  date time string
     *
     * @return \Carbon\Carbon|null
     */
    public function getLoginAtAttribute($value)
    {
        if ($value === null) {
            return null;
        }

        $at = $this->asDateTime($value);
        if ($at->timestamp <= 0) {
            return null;
        }

        return $at;
    }

    /**
     * @param $displayName
     * @return mixed
     */
    public function getDisplayNameAttribute($displayName)
    {
        if (app('xe.user')->isUseDisplayName() === false) {
            return app('xe.user')->isUseLoginId() === true ? $this->login_id : $this->email;
        }

        return $displayName;
    }

    /**
     * Get Terms a user agreed
     *
     * @return Collection
     */
    public function getAgreedTerms()
    {
        return $this->getAttribute('agreedTerms');
    }
}

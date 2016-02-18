<?php
/**
 * This file is part of the Xpressengine package.
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
namespace Xpressengine\User;

use BadMethodCallException;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Support\Collection;
use Xpressengine\Member\Exceptions\AccountAlreadyExistsException;
use Xpressengine\Member\Exceptions\CannotDeleteMemberHavingSuperRatingException;
use Xpressengine\Member\Exceptions\DisplayNameAlreadyExistsException;
use Xpressengine\Member\Exceptions\MailAlreadyExistsException;
use Xpressengine\Register\Container;
use Xpressengine\Support\Exceptions\InvalidArgumentException;
use Xpressengine\User\Models\PendingEmail;
use Xpressengine\User\Models\User;
use Xpressengine\User\Models\UserAccount;
use Xpressengine\User\Models\UserEmail;
use Xpressengine\User\Models\UserGroup;

/**
 * 회원 및 회원과 관련된 데이터(그룹정보, 계정정보, 이메일 정보 등)를 조회하거나 처리할 때에 UserHandler를 사용할 수 있습니다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserHandler
{

    /**
     * 차단된 회원의 상태
     */
    const STATUS_DENIED = 'denied';

    /**
     * 활성화된 회원의 상태
     */
    const STATUS_ACTIVATED = 'activated';

    /**
     * @var array 회원이 가질 수 있는 상태 목록
     */
    public static $status = [
        self::STATUS_DENIED,
        self::STATUS_ACTIVATED
    ];

    /**
     * @var User 회원 저장소
     */
    protected $users;

    /**
     * @var UserAccount 회원계정 저장소
     */
    protected $accounts;

    /**
     * @var UserGroup 그룹 저장소
     */
    protected $groups;

    /**
     * @var UserEmail 회원 이메일 저장소
     */
    protected $emails;

    /**
     * @var PendingEmail 회원 등록대기 이메일 저장소
     */
    private $pendingEmails;

    /**
     * @var Hasher 해시코드 생성기, 비밀번호 해싱을 위해 사용됨
     */
    protected $hasher;

    /**
     * @var Container Xpressengine 레지스터
     */
    protected $container;

    /**
     * @var array 개인정보 설정 페이지의 섹션 리스트
     */
    protected $settingsSections = [];

    /**
     * @var Validator 유효성 검사기. 비밀번호 및 표시이름(dispalyName)의 유효성 검사를 위해 사용됨
     */
    private $validator;

    /**
     * @var bool 이메일 인증의 사용여부
     */
    private $useEmailConfirm;

    /**
     * constructor.
     *
     * @param User             $users           User 회원 저장소
     * @param UserAccount      $accounts        UserAccount 회원계정 저장소
     * @param UserGroup        $groups          UserGroup 그룹 저장소
     * @param UserEmail        $mails           회원 이메일 저장소
     * @param PendingEmail     $pendingEmails   회원 등록대기 이메일 저장소
     * @param Hasher           $hasher          해시코드 생성기, 비밀번호 해싱을 위해 사용됨
     * @param Validator        $validator       유효성 검사기. 비밀번호 및 표시이름(dispalyName)의 유효성 검사를 위해 사용됨
     * @param Container        $container       Xpressengine 레지스터
     * @param boolean          $useEmailConfirm 이메일 인증의 사용여부
     */
    public function __construct(
        User $users,
        UserAccount $accounts,
        UserGroup $groups,
        UserEmail $mails,
        PendingEmail $pendingEmails,
        Hasher $hasher,
        Validator $validator,
        Container $container,
        $useEmailConfirm
    ) {
        $this->users = $users;
        $this->accounts = $accounts;
        $this->groups = $groups;
        $this->emails = $mails;
        $this->hasher = $hasher;
        $this->validator = $validator;
        $this->container = $container;
        $this->pendingEmails = $pendingEmails;
        $this->useEmailConfirm = $useEmailConfirm;
    }


    /**
     * User 회원 저장소를 반환한다.
     *
     * @return User
     */
    public function users()
    {
        return $this->users;
    }

    /**
     * UserAccount 회원계정 저장소를 반환한다.
     *
     * @return UserAccount
     */
    public function accounts()
    {
        return $this->accounts;
    }

    /**
     * UserGroup 그룹 저장소를 반환한다.
     *
     * @return UserGroup
     */
    public function groups()
    {
        return $this->groups;
    }

    /**
     * 회원 이메일 저장소를 반환한다.
     *
     * @return UserEmail
     */
    public function emails()
    {
        return $this->emails;
    }

    /**
     * 회원 등록대기 이메일 저장소를 반환한다.
     *
     * @return PendingEmail
     */
    public function pendingEmails()
    {
        return $this->pendingEmails;
    }

    /**
     * 주어진 정보로 신규회원을 등록한다. 회원정보에 대한 유효성검사도 병행하며, 회원관련 정보(그룹, 이메일, 등록대기 이메일, 계정)도 동시에 추가한다.
     *
     * @param array $data 신규회원 정보
     *
     * @return User 신규 등록된 회원정보
     */
    public function create(array $data)
    {

        $this->validateForCreate($data);

        /* 회원가입 절차 */
        $userData = array_except(
            $data,
            ['emailConfirmed', 'groupId', 'password_confirmation', 'account']
        );

        // insert user
        if (array_has($userData, 'password')) {
            $userData['password'] = $this->hasher->make($userData['password']);
        }
        $user = $this->users->create($userData);

        // insert mail
        if (isset($userData['email'])) {
            $mailData = [
                'userId' => $user->id,
                'address' => $user->email,
            ];
            if ($this->useEmailConfirm === false || array_get($data, 'emailConfirmed', false)) {
                $mail = $this->emails->create($mailData);
                $user->emails = [$mail];
            } else {
                $mail = $this->pendingEmails->create($mailData);
                $user->pending_emails = [$mail];
            }
        }

        // join group
        $groupIds = array_get($data, 'groupId', []);
        if (count($groupIds) > 0) {
            $groups = $this->groups->whereIn('id', $groupIds)->get();
            $user->joinGroups($groups->all());
        }

        // insert accounts
        if (isset($data['account'])) {
            $accountData = $data['account'];
            $account = $this->accounts()->create(
                [
                    'userId' => $user->id,
                    'accountId' => array_get($accountData, 'accountId'),
                    'email' => array_get($accountData, 'email', array_get($data, 'email')),
                    'provider' => array_get($accountData, 'provider'),
                    'data' => array_get($accountData, 'data'),
                    'token' => array_get($accountData, 'token'),
                ]
            );
            $user->accounts()->save($account);
        }

        return $user;
    }

    /**
     * 회원탈퇴 처리를 한다. 회원관련 정보(그룹, 이메일, 등록대기 이메일, 계정)도 동시에 삭제한다.
     *
     * @param string|string[] $userIds 탈퇴할 회원의 회원아이디 목록
     *
     * @return void
     */
    public function leave($userIds)
    {

        /** @var User[] $users */
        $users = $this->users->whereIn('id', $userIds)->with(['groups', 'emails'])->get();

        $ratings = array_pluck($users, 'rating');
        if (in_array(Rating::SUPER, $ratings)) {
            throw new CannotDeleteMemberHavingSuperRatingException();
        }

        foreach ($users as $user) {
            // except user from user's groups
            $user->groups()->detach();
            $user->delete();
        }

        // delete user's mails
        $this->emails->deleteByMemberIds($userIds);
        $this->pendingEmails->deleteByMemberIds($userIds);

        // delete user's accounts
        $this->accounts->deleteByMemberIds($userIds);
    }


    /**
     * 신규회원의 정보를 유효성 검사한다.
     *
     * @param array $data 회원의 정보
     *
     * @return bool 유효성검사 결과, 통과할 경우 true, 실패할 경우 false
     */
    public function validateForCreate(array $data)
    {
        // 필수 요소 검사
        if (!isset($data['status'], $data['rating'], $data['displayName'])) {
            throw new InvalidArgumentException();
        }

        // email이나 account중 하나는 반드시 있어야 한다.
        if (!isset($data['email']) && !isset($data['account'])) {
            $e = new InvalidArgumentException();
            $e->setMessage('email이나 account중 하나가 반드시 있어야 합니다.');
            throw $e;
        }

        // email, displayName 중복검사
        if (isset($data['email'])) {
            if ($this->emails->findByAddress($data['email']) !== null) {
                throw new MailAlreadyExistsException();
            }
        }

        // displayName 검사
        $this->validateDisplayName($data['displayName']);

        // account 검사
        if (isset($data['account'])) {
            $account = $data['account'];
            if (!isset($account['accountId'], $account['provider'], $account['data'], $account['token'])) {
                $e = new InvalidArgumentException();
                $e->setMessage('account 정보가 올바르지 않습니다.');
                throw $e;
            }

            if ($this->accounts->where(array_only($account, ['accountId', 'providor'])) !== null) {
                throw new AccountAlreadyExistsException();
            }
        }

        return true;
    }

    /**
     * 표시이름(displayName)에 대한 유효성 검사를 한다. 표시이름이 형식검사와 중복검사를 병행한다.
     *
     * @param string $name 유효성 검사를 할 표시이름
     *
     * @return bool  유효성검사 결과, 통과할 경우 true, 실패할 경우 false
     */
    public function validateDisplayName($name)
    {
        if ($name === null || empty($name)) {
            $e = new InvalidArgumentException();
            $e->setMessage('회원이름은 공백이 될 수 없습니다.');
            throw $e;
        }

        $validate = $this->validator->make(
            ['name' => $name],
            ['name' => ['display_name']]
        );

        if ($validate->fails()) {
            $e = new InvalidArgumentException();
            $e->setMessage('회원이름 형식이 잘못되었습니다.');
            throw $e;
        }

        if ($this->users->where(['displayName' => $name])->first() !== null) {
            throw new DisplayNameAlreadyExistsException();
        }

        return true;
    }

    /**
     * 비밀번호에 대한 유효성 검사를 한다.
     *
     * @param string $password 유효성 검사를 할 비밀번호
     *
     * @return bool  유효성검사 결과, 통과할 경우 true, 실패할 경우 false
     */
    public function validatePassword($password)
    {
        $validate = $this->validator->make(
            ['password' => $password],
            [
                'password' => ['password']
            ]
        );

        if ($validate->fails()) {
            $messages = $validate->messages();
            $message = current($messages->get('password'));
            $e = new InvalidArgumentException();
            $e->setMessage($message);
            throw $e;
        }

        return true;
    }

    /**
     * MemberHandler는 알지 못하는 메소드가 호출될 경우, 호출된 메소드를 파악하여 담당 Repository를 찾고,
     * 담당 Repository의 해당 메소드를 호출하는 Proxy 역할을 한다.
     * 이를 사용하면, 서드파티 개발자들은 특정 Repository를 직접 사용하지 않고 MemberHandler를 사용하여 원하는 기능을 실행할 수 있다.
     *
     * @param string $method    호출된 method 명
     * @param array  $arguments 파라메터 목록
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        $prefixes = get_class_methods(RepositoryInterface::class);

        $repositories = [
            'Member',
            'Group',
            'Account',
            'Mail',
            'PendingMail',
        ];

        $prefix = null;
        $postfix = null;
        foreach ($prefixes as $needle) {
            if ($needle != '' && strpos($method, $needle) === 0) {
                if ($prefix === null || strlen($prefix) < strlen($needle)) {
                    $prefix = $needle; // has
                    $postfix = substr($method, strlen($prefix)); // Member
                }
            }
        }

        if ($prefix === null) {
            throw new BadMethodCallException("Call to undefined method {get_class($this)}::{$method}()");
        }

        $repoName = 'Member';
        foreach ($repositories as $needle) {
            if ($needle != '' && strpos($postfix, $needle) === 0) {
                $repoName = $needle; // Member
                $postfix = substr($postfix, strlen($repoName)) ?: '';
                break;
            }
        }

        $repository = $this->{'get'.$repoName.'Repository'}();
        $methodName = $prefix.$postfix;

        if (method_exists($repository, $methodName)) {
            return call_user_func_array([$repository, $methodName], $arguments);
        }

        throw new BadMethodCallException("Call to undefined method {get_class($repository)}::{$method}()");
    }

    /**
     * 이메일 인증의 사용 여부를 반환한다.
     *
     * @return bool 이메일 인증 사용 여부
     */
    public function usingEmailConfirm()
    {
        return $this->useEmailConfirm;
    }

    /**
     * 개인 회원정보 설정 페이지의 섹션 목록을 반환한다.
     * 개인 회원정보 설정 페이지는 여러개의 섹션(메뉴)로 구성된다. 기본적으로 Xpressengien은 '회원 기본정보 설정' 섹션이 가지고 있고,
     * 다른 서드파티에서 자유롭게 섹션을 추가할 수 있다. 예) 소셜로그인 플러그인의 '외부 로그인 설정' 섹션
     * 이 메소드는 이렇게 등록된 섹션 목록을 반환한다.
     *
     * @return array 등록된 회원정보 설정 페이지 섹션 목록
     */
    public function getSettingsSections()
    {
        $menus = $this->container->get('user/settings/section');
        return array_merge($this->settingsSections, $menus ?: []);
    }
}

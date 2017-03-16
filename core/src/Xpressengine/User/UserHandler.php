<?php
/**
 * This file is part of the Xpressengine package.
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

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory as Validator;
use Xpressengine\Register\Container;
use Xpressengine\Support\Exceptions\InvalidArgumentException;
use Xpressengine\User\Exceptions\AccountAlreadyExistsException;
use Xpressengine\User\Exceptions\CannotDeleteUserHavingSuperRatingException;
use Xpressengine\User\Exceptions\DisplayNameAlreadyExistsException;
use Xpressengine\User\Exceptions\MailAlreadyExistsException;
use Xpressengine\User\Repositories\PendingEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserAccountRepositoryInterface;
use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;
use Xpressengine\User\Repositories\UserRepositoryInterface;

/**
 * 회원 및 회원과 관련된 데이터(그룹정보, 계정정보, 이메일 정보 등)를 조회하거나 처리할 때에 UserHandler를 사용할 수 있습니다.
 * UserHandler는 `XeUser` 파사드를 통해 쉽게 사용할 수 있습니다.
 *
 * ## 회원 조회
 *
 * 회원 정보를 조회할 때에는 `UserRepository`를 사용하십시오. `UserRepository`는 UserHandler를 통하여 가져올 수 있습니다.
 *
 * ```
 * $userRepository = XeUser::users();
 * ```
 *
 * > UserRepository는 laravel의 Eloquent 모델의 사용법을 대부분 그대로 사용할 수 있습니다.
 * laravel Eloquent 모델의 사용법은 [라라벨 문서](https://laravel.com/docs/5.2/eloquent)를 참조하십시오.
 *
 * ### 회원아이디로 회원조회
 *
 * 회원 아이디로 회원 조회할 때에는 `find` 메소드를 사용하십시오.
 *
 * ```php
 * $user = XeUser::users()->find($id);
 * $username = $user->getDisplayName();
 * ```
 *
 * 여러 회원을 조회할 수도 있습니다.
 *
 * ```php
 * $ids = [1,2,3];
 * $users = XeUser::users()->find($ids);
 *
 * foreach($users as $user) {
 * ...
 * }
 * ```
 *
 * ### 회원 정보로 회원조회
 *
 * 다양하고 복잡한 조건으로 회원을 조회할 수도 있습니다. 자세한 사용법은 [라라벨 문서](https://laravel.com/docs/5.2/eloquent)를 참조하십시오.
 *
 * ```php
 * // displayName이 foo인 회원 조회
 * $user = XeUser::users()->where('displayName', 'foo')->first();
 * ```
 *
 * ```php
 * // displayName이 foo로 시작하는 모든 회원 조회
 * $user = XeUser::users()->where('displayName', 'like', '%foo')->get();
 * ```
 *
 *
 * ## 신규 회원 추가
 *
 * UserHandler는 복잡한 회원 생성 과정을 한번에 처리해주는 `create` 메소드를 제공합니다.
 * `create` 메소드는 입력한 신규회원 정보에 대한 유효성 검사후 신규회원을 생성합니다.
 * 또한 회원의  계정(account), 이메일(email) 정보도 자동으로 추가되며, 소솔될 그룹에 대한 정보가 전달되었을 경우, 그룹에 추가시켜주기도 합니다.
 *
 * ```php
 * $data = [
 * 'displayName' => 'foo',
 * 'email' => 'foo@email.com',
 * //...
 * ];
 *
 * $newUser = XeUser::create($data);
 * ```
 *
 * 신규 회원의 계정(account) 정보를 같이 등록할 수도 있습니다.
 *
 * ```php
 * $data = [
 * 'displayName' => 'foo',
 * 'email' => 'foo@email.com',
 * //...
 * ]
 *
 * $data['account'] = [
 * 'provider' => 'facebook',
 * 'token' => '3DIfdkwwfdsie...',
 * 'id' => 'id of facebook user',
 * 'data' => '...'
 * ]
 *
 * $newUser = XeUser::create($data);
 * ```
 *
 * 신규회원이 소속될 회원그룹을 지정할 수도 있습니다.
 *
 * ```php
 * $data = [
 * 'displayName' => 'foo',
 * 'email' => 'foo@email.com',
 * 'groupId' => [21,23] // 그룹아이디가 21, 23인 그룹에 회원을 소속시킴
 * ]
 *
 * $newUser = XeUser::create($data);
 * ```
 *
 * 만약 유효성검사 및 관련 정보(account, email, group) 등록을 하지않고 신규회원 정보만 추가하고싶다면 UserRepository를 사용하십시오.
 *
 * ```php
 * $data = [
 * 'displayName' => 'foo',
 * 'email' => 'foo@email.com',
 * 'password' => '...'
 * ]
 *
 * $newUser = XeUser::users()->create($data);
 * ```
 *
 * > `주의!` UserRepository의 `create` 메소드는 `password`를 암호화하지 않고 바로 저장합니다.
 * 먼저 `password` 필드를 직접 암호화하십시오.
 *
 *
 * ## 회원정보 수정
 *
 * `update` 메소드를 사용하면 회원정보를 변경할 수 있습니다. 유효성 검사 및 프로필 이미지 처리, 소속그룹 변경도 동시에 처리합니다.
 *
 * ```
 * $user = XeUser::find(20);
 * XeUser::update($user, ['displayName' => 'bar']);
 * ```
 *
 * ## 회원삭제
 *
 * `leave` 메소드를 사용하면 특정 회원을 탈퇴시킬 수 있습니다. `leave` 메소드를 사용하면
 * 탈퇴시킬 회원의 관련정보(account, email)도 같이 삭제됩니다.
 *
 * ```php
 * $ids = [12,23,34];
 * XeUser::leave($ids); // 3명의 회원을 탈퇴시킴
 * ```
 *
 * UserRepository의 `delete` 메소드를 사용하여 회원을 삭제할 수도 있습니다. 단, 이 메소드를 사용하면 삭제될 회원과 관련된 정보는 함께 삭제되지 않습니다.
 *
 * ```php
 * $user = XeUser::find(12);
 * XeUser::delete($user);
 * ```
 *
 * ## 회원과 관련된 정보의 조회 및 처리
 *
 * 회원계정(account), 회원이메일(email), 회원 승인대기 이메일(pending email), 회원그룹(group)과 같은
 * 회원과 관련된 정보도 UserHandler를 사용하여 조회하고 처리할 수 있습니다.
 *
 * 회원과 관련된 정보에 대한 생성(create), 삭제(delete), 업데이트(update) 기능은 UserHandler에서 직접 제공합니다.
 * 단, 회원과 관련된 정보에 대한 조회(retrieve) 기능은 각각의 Repository를 통해 실행해야 합니다.
 *
 * UserHandler에서 제공하는 생성(create), 삭제(delete), 업데이트(update) 기능은 아래 코드를 참고하십시오.
 *
 * ```php
 *
 * // 그룹정보 생성/수정/삭제
 * $groupData = [
 * 'name' => '정회원',
 * 'description' => '기본회원',
 * ];
 *
 * $group = XeUser::createGroup($groupData);
 * XeUser::updateGroup($group, ['name' => '기본회원']);
 * XeUser::deleteGroup($group);
 *
 * // 이메일정보 생성/수정/삭제
 * $user = XeUser::find('123');
 * $data = [
 * 'address' => 'foo@email.com'
 * ];
 * $confirmed = true; // 승인|승인대기 이메일 구분
 *
 * $email = XeUser::createEmail($user, $data, $confirmed);
 * XeUser::updateEmail($email, ['address' => 'bar@email.com']);
 * XeUser::deleteEmail($email);
 *
 * // 계정정보 생성/수정/삭제
 * $data = [
 * 'provider' => 'facebook',
 * // ....
 * ]
 *
 * $account = XeUser::createAccount($user, array $data);
 * XeUser::updateAccount($account, ['data'=>'...']);
 * XeUser::deleteAccount($account);
 * ```
 *
 * ### 회원계정(account)
 *
 * XE에서 각각의 회원(user)는 여러개의 외부 계정을 가질 수 있습니다.
 * 만약 한 회원이 facebook, google, naver 등 여러개의 외부 계정을 소유하고 있다면, 소유한 계정중 하나를 이용하여 로그인할 수 있습니다.
 *
 * 회원계정을 조회할 때에는 UserAccountRepository를 사용하십시오.
 * UserAccountRepository는 UserHandler를 통하여 가져올 수 있습니다.
 *
 * ```php
 * $accountRepository = XeUser::accounts();
 * ```
 *
 * 한 회원이 소유한 계정 목록을 조회할 수 있습니다.
 *
 * ```php
 * // 회원계정아이디로 회원계정정보 조회
 * $userId = '123';
 * $accounts = XeUser::accounts()->findByUserId($accountId);
 * ```
 *
 * 위 코드는 아래 코드로 대체할 수도 있습니다.
 *
 * ```php
 * $user = XeUser::users()->find('123');
 * $accounts = $user->accounts;
 * ```
 *
 * > UserAccountRepository는 laravel의 Eloquent 모델의 사용법을 대부분 그대로 사용할 수 있습니다.
 * laravel Eloquent 모델의 사용법은 [라라벨 문서](https://laravel.com/docs/5.2/eloquent)를 참조하십시오.
 *
 * ### 회원 이메일(email)
 *
 * XE에서 각각의 회원은 여러개의 이메일을 가질 수 있습니다.
 * 만약 한 회원이 여러개의 이메일을 소유하고 있다면, 소유한 이메일 중 하나와 비밀번호를 사용하여 로그인 할 수 있습니다.
 *
 * 회원의 이메일을 조회할 때에는 UserEmailRepository를 사용하십시오.
 * UserEmailRepository는 UserHandler를 통하여 가져올 수 있습니다.
 *
 * ```php
 * $emailRepository = XeUser::emails();
 * ```
 *
 * 이메일 주소를 사용하여 이메일정보 조회할 수 있습니다.
 *
 * ```php
 * $email = XeUser::emails()->findByAddress('myaddress@xpressengine.com');
 * ```
 *
 * ### 승인 대기중인 이메일(pending email)
 *
 * 회원이 소유한 이메일은 승인된 이메일과 승인 대기중인 이메일로 구분됩니다.
 * 승인된 이메일(email)과 승인대기 이메일(pendingEmail)은 별도의 테이블에 저장됩니다.
 * 승인된 이메일은 한 회원이 여러개 가질 수 있지만, 승인대기 이메일은 한 회원당 하나만 가질 수 있습니다.
 *
 * 승인대기 이메일 주소로는 로그인을 할 수 없습니다.
 *
 * 회원의 승인대기 이메일을 조회할 때에는 PendingEmailRepository를 사용하십시오.
 * PendingEmailRepository는 UserHandler를 통하여 가져올 수 있습니다.
 *
 * ```php
 * $pendingEmailRepository = XeUser::pendingEmails();
 * ```
 *
 * ```php
 * $pendingEmail = XeUser::pendingEmails()->findByUserId('123');
 * ```
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
     * @var UserRepositoryInterface User Repository
     */
    protected $users;

    /**
     * @var UserAccountRepositoryInterface UserAccount Repository
     */
    protected $accounts;

    /**
     * @var UserGroupRepositoryInterface UserGroup Repository
     */
    protected $groups;

    /**
     * @var UserEmailRepositoryInterface UserEmail Repository
     */
    protected $emails;

    /**
     * @var PendingEmailRepositoryInterface PendingEmail Repository
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
     * @var UserImageHandler
     */
    private $imageHandler;

    /**
     * constructor.
     *
     * @param UserRepositoryInterface         $users           User 회원 저장소
     * @param UserAccountRepositoryInterface  $accounts        UserAccount 회원계정 저장소
     * @param UserGroupRepositoryInterface    $groups          UserGroup 그룹 저장소
     * @param UserEmailRepositoryInterface    $mails           회원 이메일 저장소
     * @param PendingEmailRepositoryInterface $pendingEmails   회원 등록대기 이메일 저장소
     * @param UserImageHandler                $imageHandler    image handler
     * @param Hasher                          $hasher          해시코드 생성기, 비밀번호 해싱을 위해 사용됨
     * @param Validator                       $validator       유효성 검사기. 비밀번호 및 표시이름(dispalyName)의 유효성 검사를 위해 사용됨
     * @param Container                       $container       Xpressengine 레지스터
     * @param boolean                         $useEmailConfirm 이메일 인증의 사용여부
     */
    public function __construct(
        UserRepositoryInterface $users,
        UserAccountRepositoryInterface $accounts,
        UserGroupRepositoryInterface $groups,
        UserEmailRepositoryInterface $mails,
        PendingEmailRepositoryInterface $pendingEmails,
        UserImageHandler $imageHandler,
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
        $this->imageHandler = $imageHandler;
    }

    /**
     * User 회원 저장소를 반환한다.
     *
     * @return UserRepositoryInterface
     */
    public function users()
    {
        return $this->users;
    }

    /**
     * UserAccount 회원계정 저장소를 반환한다.
     *
     * @return UserAccountRepositoryInterface
     */
    public function accounts()
    {
        return $this->accounts;
    }

    /**
     * UserGroup 그룹 저장소를 반환한다.
     *
     * @return UserGroupRepositoryInterface
     */
    public function groups()
    {
        return $this->groups;
    }

    /**
     * 회원 이메일 저장소를 반환한다.
     *
     * @return UserEmailRepositoryInterface
     */
    public function emails()
    {
        return $this->emails;
    }

    /**
     * 회원 등록대기 이메일 저장소를 반환한다.
     *
     * @return PendingEmailRepositoryInterface
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
     * @return UserInterface 신규 등록된 회원정보
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
        $user = $this->users()->create($userData);

        // insert mail
        if (isset($userData['email'])) {
            $mailData = [
                'userId' => $user->id,
                'address' => $user->email,
            ];
            if ($this->useEmailConfirm === false || array_get($data, 'emailConfirmed', false)) {
                $mail = $this->emails()->create($user, $mailData);
            } else {
                $mail = $this->pendingEmails()->create($user, $mailData);
            }
        }

        // join group
        $groupIds = array_get($data, 'groupId', []);
        if (count($groupIds) > 0) {
            $user->joinGroups($groupIds);
        }

        // insert accounts
        if (isset($data['account'])) {
            $accountData = $data['account'];
            $account = $this->accounts()->create(
                $user,
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
     * 회원정보를 업데이트 한다.
     * 필드: email, displayName, password, status, introduction, profileImgFile, groupId
     *
     * @param UserInterface $user     user
     * @param array         $userData user data
     *
     * @return UserInterface
     */
    public function update(UserInterface $user, $userData)
    {
        $this->validateForUpdate($user, $userData);

        // encrypt password
        if (!empty($userData['password'])) {
            $userData['password'] = $this->hasher->make($userData['password']);
        } else {
            unset($userData['password']);
        }

        // resolve profileImage
        if (!empty($userData['profileImgFile'])) {
            $profileFile = $userData['profileImgFile'];
            $userData['profileImageId'] = $this->imageHandler->updateUserProfileImage($user, $profileFile);
        }

        // resolve group
        $groups = array_get($userData, 'groupId');

        // email, displayName, introduction, password, status, rating
        $userData = array_except($userData, ['groupId', 'profileImgFile']);

        foreach ($userData as $key => $value) {
            $user->{$key} = $value;
        }

        $user->save();

        // join new group
        if ($groups !== null) {
            $changes = $user->groups()->sync($groups);
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

        /** @var UserInterface[] $users */
        $users = $this->users()->whereIn('id', (array) $userIds)->with(['groups', 'emails'])->get();

        $ratings = array_pluck($users, 'rating');
        if (in_array(Rating::SUPER, $ratings)) {
            throw new CannotDeleteUserHavingSuperRatingException();
        }

        // delete user's emails
        $this->emails()->deleteByUserIds($userIds);
        $this->pendingEmails()->deleteByUserIds($userIds);

        // delete user's accounts
        $this->accounts()->deleteByUserIds($userIds);

        // resolve group
        foreach ($users as $user) {
            // except user from user's groups
            $user->groups()->detach();
            $user->delete();
        }
        // todo: remove profile image
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
            if ($this->emails()->findByAddress($data['email']) !== null) {
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

            if ($this->accounts()->where(array_only($account, ['accountId', 'provider']))->first() !== null) {
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

        if ($this->users()->where(['displayName' => $name])->first() !== null) {
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
            $e->setMessage(xe_trans($message));
            throw $e;
        }

        return true;
    }

    /**
     * 회원의 정보를 업데이트할 때 필요한 유효성 검사를 한다.
     *
     * @param UserInterface $user user
     * @param array         $data data
     *
     * @return bool 유효성검사 결과, 통과할 경우 true, 실패할 경우 false
     */
    public function validateForUpdate(UserInterface $user, array $data)
    {
        if (!empty($data['password'])) {
            $this->validatePassword($data['password']);
        }

        if (array_get($data, 'displayName') !== null) {
            if ($user->displayName !== $data['displayName']) {
                $this->validateDisplayName($data['displayName']);
            }
        }

        return true;
    }

    /**
     * 새로운 그룹을 추가한다.
     *
     * @param array $data data
     *
     * @return GroupInterface
     */
    public function createGroup(array $data)
    {
        $group = $this->groups()->create($data);
        return $group;
    }

    /**
     * 그룹을 수정한다
     *
     * @param GroupInterface $group group
     * @param array          $data  data
     *
     * @return GroupInterface
     */
    public function updateGroup(GroupInterface $group, array $data = [])
    {
        $this->groups()->update($group, $data);
        return $group;
    }

    /**
     * 그룹을 삭제한다
     *
     * @param GroupInterface $group group
     *
     * @return bool
     */
    public function deleteGroup(GroupInterface $group)
    {
        return $this->groups()->delete($group);
    }

    /**
     * 새로운 이메일을 생성한다
     *
     * @param UserInterface $user      user
     * @param array         $data      data
     * @param bool          $confirmed confirmed
     *
     * @return EmailInterface
     */
    public function createEmail(UserInterface $user, array $data, $confirmed = true)
    {
        if ($confirmed === true) {
            $email = $this->emails()->create($user, $data);
        } else {
            $email = $this->pendingEmails()->create($user, $data);
        }
        return $email;
    }

    /**
     * 이메일을 수정한다
     *
     * @param EmailInterface $email email
     * @param array          $data  data
     *
     * @return EmailInterface
     */
    public function updateEmail(EmailInterface $email, array $data = [])
    {
        if ($email->isConfirmed()) {
            $this->emails()->update($email, $data);
        } else {
            $this->pendingEmails()->update($email, $data);
        }
        return $email;
    }

    /**
     * 이메일을 삭제한다
     *
     * @param EmailInterface $email email
     *
     * @return bool
     */
    public function deleteEmail(EmailInterface $email)
    {
        if ($email->isConfirmed()) {
            return $this->emails()->delete($email);
        } else {
            return $this->pendingEmails()->delete($email);
        }
    }

    /**
     * 새로운 계정을 추가한다.
     *
     * @param UserInterface $user user
     * @param array         $data data
     *
     * @return void
     */
    public function createAccount(UserInterface $user, array $data)
    {
        $this->accounts()->create($user, $data);
    }

    /**
     * 계정을 수정한다
     *
     * @param AccountInterface $account account
     * @param array            $data    data
     *
     * @return AccountInterface
     */
    public function updateAccount(AccountInterface $account, array $data = [])
    {
        $this->accounts()->update($account, $data);
        return $account;
    }

    /**
     * 계정을 삭제한다
     *
     * @param string $account account
     *
     * @return void
     */
    public function deleteAccount($account)
    {
        $this->accounts()->delete($account);
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
     * 개인 회원정보 설정 페이지는 여러개의 섹션(메뉴)로 구성된다.
     * 기본적으로 Xpressengien은 '회원 기본정보 설정' 섹션이 가지고 있고,
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

    /**
     * __call
     *
     * @param string $method     method name
     * @param array  $parameters parameters
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        $users = $this->users();
        return call_user_func_array([$users, $method], $parameters);
    }
}

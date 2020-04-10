<?php
/**
 * This file is part of the Xpressengine package.
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

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Validation\Rule;
use Xpressengine\Config\ConfigManager;
use Xpressengine\Register\Container;
use Xpressengine\Support\Exceptions\InvalidArgumentException;
use Xpressengine\User\Exceptions\AccountAlreadyExistsException;
use Xpressengine\User\Exceptions\CannotDeleteUserHavingSuperRatingException;
use Xpressengine\User\Exceptions\InvalidAccountInfoException;
use Xpressengine\User\Models\User;
use Xpressengine\User\Models\UserTermAgree;
use Xpressengine\User\Repositories\PendingEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserAccountRepositoryInterface;
use Xpressengine\User\Repositories\UserEmailRepositoryInterface;
use Xpressengine\User\Repositories\UserGroupRepositoryInterface;
use Xpressengine\User\Repositories\UserRepositoryInterface;

/**
 * 회원 및 회원과 관련된 데이터(그룹정보, 계정정보, 이메일 정보 등)를 조회하거나 처리할 때에 UserHandler를 사용할 수 있습니다.
 * UserHandler는 `XeUser` 파사드를 통해 쉽게 사용할 수 있습니다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserHandler
{
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
    protected static $container;

    /**
     * @var Validator 유효성 검사기. 비밀번호 및 표시이름(dispalyName)의 유효성 검사를 위해 사용됨
     */
    private $validator;

    /**
     * @var UserImageHandler
     */
    private $imageHandler;

    /**
     * @var ConfigManager $configManager config manager
     */
    private $configManager;

    /**
     * constructor.
     *
     * @param UserRepositoryInterface         $users         User 회원 저장소
     * @param UserAccountRepositoryInterface  $accounts      UserAccount 회원계정 저장소
     * @param UserGroupRepositoryInterface    $groups        UserGroup 그룹 저장소
     * @param UserEmailRepositoryInterface    $mails         회원 이메일 저장소
     * @param PendingEmailRepositoryInterface $pendingEmails 회원 등록대기 이메일 저장소
     * @param UserImageHandler                $imageHandler  image handler
     * @param Hasher                          $hasher        해시코드 생성기, 비밀번호 해싱을 위해 사용됨
     * @param Validator                       $validator     유효성 검사기. 비밀번호 및 표시이름(dispalyName)의 유효성 검사를 위해 사용됨
     * @param ConfigManager                   $configManager ConfigManager
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
        ConfigManager $configManager
    ) {
        $this->users = $users;
        $this->accounts = $accounts;
        $this->groups = $groups;
        $this->emails = $mails;
        $this->hasher = $hasher;
        $this->validator = $validator;
        $this->pendingEmails = $pendingEmails;
        $this->imageHandler = $imageHandler;
        $this->configManager = $configManager;
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
        $data['rating'] = $data['rating'] ?? Rating::USER;
        $data['status'] = $data['status'] ?? $this->configManager->getVal('user.register.register_process', User::STATUS_ACTIVATED);
        if ($this->configManager->getVal('user.register.use_display_name') === false && isset($data['display_name']) === false) {
            $data['display_name'] = $data['login_id'];
        }

        $this->validateForCreate($data);

        /* 회원가입 절차 */
        $userData = array_except(
            $data,
            ['group_id', 'password_confirmation', 'account', '_token']
        );

        // insert user
        if (array_has($userData, 'password')) {
            $userData['password'] = $this->hasher->make($userData['password']);
        }

        $user = $this->users()->create($userData);

        // insert mail, delete pending mail
        if (isset($userData['email'])) {
            $mailData = [
                'user_id' => $user->id,
                'address' => $user->email,
            ];
            $this->emails()->create($user, $mailData);
            $pendingEmail = $this->pendingEmails()->findByUserId($user->id);
            if ($pendingEmail !== null) {
                $this->deleteEmail($pendingEmail);
            }
        }

        // join group
        $groupIds = array_get($data, 'group_id', []);
        if (count($groupIds) > 0) {
            $user->joinGroups($groupIds);
        }

        // insert accounts
        if (isset($data['account'])) {
            $accountData = $data['account'];
            $account = $this->accounts()->create(
                $user,
                [
                    'user_id' => $user->id,
                    'account_id' => array_get($accountData, 'account_id'),
                    'email' => array_get($accountData, 'email', array_get($data, 'email')),
                    'provider' => array_get($accountData, 'provider'),
                    'token' => array_get($accountData, 'token'),
                    'token_secret' => array_get($accountData, 'token_secret'),
                ]
            );
            $user->accounts()->save($account);
        }

        // save term agree
        if (isset($data['user_agree_terms'])) {
            foreach ($data['user_agree_terms'] as $termId) {
                $newTermAgree = new UserTermAgree();
                $newTermAgree->fill([
                    'user_id' => $user->id,
                    'term_id' => $termId
                ])->save();
            }
        }

        return $user;
    }

    /**
     * 회원정보를 업데이트 한다.
     * 필드: email, display_name, password, status, introduction, profile_img_file, group_id
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
        if (array_get($userData, 'profile_img_file') !== null) {
            $profileFile = $userData['profile_img_file'];

            if ($profileFile === false) {
                $this->imageHandler->removeUserProfileImage($user);
                $userData['profile_image_id'] = null;
            } else {
                $userData['profile_image_id'] = $this->imageHandler->updateUserProfileImage($user, $profileFile);
            }
        }

        // resolve group
        $groups = array_get($userData, 'group_id');

        // email, display_name, introduction, password, status, rating
        $userData = array_except($userData, ['group_id', 'profile_img_file']);

        $user = $this->users()->update($user, $userData);

        // join new group
        if ($groups !== null) {
            $user->groups()->sync($groups);
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

        foreach ($users as $user) {
            // except user from user's groups
            $user->groups()->detach();
            $user->delete();

            // remove profle image
            $this->imageHandler->removeUserProfileImage($user);
        }
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
        if (!isset($data['status'], $data['rating'], $data['display_name'])) {
            throw new InvalidArgumentException();
        }

        // email이나 account중 하나는 반드시 있어야 한다.
        if (!isset($data['email']) && !isset($data['account'])) {
            throw new InvalidArgumentException();
        }

        // email 검사
        if (isset($data['email'])) {
            $this->validateEmail($data['email']);
        }

        if (isset($data['login_id'])) {
            $this->validateLoginId($data['login_id']);
        }

        // displayName 검사
        $this->validateDisplayName($data['display_name']);

        // account 검사
        if (isset($data['account'])) {
            $account = $data['account'];
            if (!isset($account['account_id'], $account['provider'], $account['token'])) {
                throw new InvalidAccountInfoException();
            }

            if ($this->accounts()->where(array_only($account, ['account_id', 'provider']))->first() !== null) {
                throw new AccountAlreadyExistsException();
            }
        }
        return true;
    }

    /**
     * 표시이름(display_name)에 대한 유효성 검사를 한다. 표시이름 형식검사 및 옵션에 따른 중복검사를 병행한다.
     * 3.0.8 버전부터 중복 허용 가능 옵션 추가
     *
     * @param string             $name 유효성 검사를 할 표시이름
     * @param UserInterface|null $user user object
     *
     * @return bool  유효성검사 결과, 통과할 경우 true, 실패할 경우 false
     */
    public function validateDisplayName($name, UserInterface $user = null)
    {
        if (empty($name)) {
            $name = null;
        }

        $displayNameRules = ['display_name'];
        if (app('xe.config')->getVal('user.register.display_name_unique') === true) {
            $displayNameRules[] = Rule::unique('user')->where(function ($query) use ($user) {
                if ($user) {
                    $query->where('id', '!=', $user->getId());
                }
            });
        }

        $this->validator->make(
            ['display_name' => $name],
            ['display_name' => $displayNameRules]
        )->validate();

        return true;
    }

    /**
     * LoginId에 대한 유효성 검사
     *
     * @param string             $loginId 유효성 검사를 할 LoginId
     * @param UserInterface|null $user    user object
     *
     * @return bool
     */
    public function validateLoginId($loginId, UserInterface $user = null)
    {
        $rules = [
            'required',
            'login_id',
            Rule::unique('user')->where(function ($query) use ($user) {
                if ($user) {
                    $query->where('id', '!=', $user->getId());
                }
            })
        ];

        $this->validator->make(
            ['login_id' => $loginId],
            ['login_id' => $rules]
        )->validate();

        return true;
    }

    /**
     * validateEmail
     *
     * @param string $address email address
     *
     * @return bool
     */
    public function validateEmail($address)
    {
        if (empty($address)) {
            $address = null;
        }

        $this->validator->make(
            ['email' => $address],
            ['email' => [
                'email',
                'required',
                Rule::unique('user', 'email'),
                Rule::unique('user_account', 'email'),
            ]]
        )->validate();

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
        if (array_get($data, 'display_name') !== null) {
            if (strcmp($user->display_name, $data['display_name']) !== 0) {
                $this->validateDisplayName($data['display_name'], $user);
            }
        }

        if (array_get($data, 'login_id') !== null) {
            if (strcmp($user->login_id, $data['login_id']) !== 0) {
                $this->validateLoginId($data['login_id'], $user);
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
     * @return AccountInterface
     */
    public function createAccount(UserInterface $user, array $data)
    {
        return $this->accounts()->create($user, $data);
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
     * 개인 회원정보 설정 페이지의 섹션 목록을 반환한다.
     * 개인 회원정보 설정 페이지는 여러개의 섹션(메뉴)로 구성된다.
     * 기본적으로 Xpressengien은 '회원 기본정보 설정' 섹션이 가지고 있고,
     * 다른 서드파티에서 자유롭게 섹션을 추가할 수 있다. 예) 소셜로그인 플러그인의 '외부 로그인 설정' 섹션
     * 이 메소드는 이렇게 등록된 섹션 목록을 반환한다.
     *
     * @return array 등록된 회원정보 설정 페이지 섹션 목록
     */
    public static function getSettingsSections()
    {
        return static::$container->get('user/settings/section') ?: [];
    }

    /**
     * Set a menu for user setting page
     *
     * @param string $id    id
     * @param array  $value value
     * @return void
     */
    public static function setSettingsSections($id, $value)
    {
        static::$container->push('user/settings/section', $id, $value);
    }

    /**
     * 회원가입시 회원가입 정보 입력 페이지에서 사용자에게 출력할 입력폼 목록을 반환한다.
     *
     * @return mixed
     */
    public static function getRegisterParts()
    {
        return static::$container->get('user/register/form', []);
    }

    /**
     * Set register form parts
     *
     * @param array $parts form parts
     * @return void
     */
    public static function setRegisterParts($parts = [])
    {
        $keys = array_map(function ($part) {
            return $part::ID;
        }, $parts);

        static::$container->set('user/register/form', array_combine($keys, array_values($parts)));
    }

    /**
     * Add register form part
     *
     * @param string $class form part class
     * @return void
     */
    public static function addRegisterPart($class)
    {
        static::$container->push('user/register/form', $class::ID, $class);
    }

    /**
     * Set Container instance
     *
     * @param Container $container container instance
     * @return void
     */
    public static function setContainer(Container $container)
    {
        static::$container = $container;
    }

    /**
     * Get Container instance
     *
     * @return Container
     */
    public static function getContainer()
    {
        return static::$container;
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

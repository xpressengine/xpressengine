<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Member;

use BadMethodCallException;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Contracts\Validation\Factory as Validator;
use Illuminate\Support\Collection;
use Xpressengine\Member\Entities\Database\AccountEntity;
use Xpressengine\Member\Entities\Database\MailEntity;
use Xpressengine\Member\Entities\Database\MemberEntity;
use Xpressengine\Member\Entities\Database\PendingMailEntity;
use Xpressengine\Member\Entities\Guest;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Member\Exceptions\AccountAlreadyExistsException;
use Xpressengine\Member\Exceptions\CannotDeleteMemberHavingSuperRatingException;
use Xpressengine\Member\Exceptions\DisplayNameAlreadyExistsException;
use Xpressengine\Member\Exceptions\MailAlreadyExistsException;
use Xpressengine\Member\Repositories\AccountRepositoryInterface;
use Xpressengine\Member\Repositories\GroupRepositoryInterface;
use Xpressengine\Member\Repositories\MailRepositoryInterface;
use Xpressengine\Member\Repositories\MemberRepositoryInterface;
use Xpressengine\Member\Repositories\PendingMailRepositoryInterface;
use Xpressengine\Member\Repositories\RepositoryInterface;
use Xpressengine\Member\Repositories\VirtualGroupRepositoryInterface;
use Xpressengine\Register\Container;
use Xpressengine\Support\Exceptions\InvalidArgumentException;

/**
 *
 * 회원 및 회원과 관련된 데이터(그룹정보, 계정정보, 이메일 정보 등)를 조회하거나 처리할 때에 MemberHandler를 사용할 수 있습니다.
 *
 * ## 회원조회
 *
 * ### 회원아이디로 회원조회
 *
 * `findMember` 메소드를 사용하여 회원 아이디로 회원조회를 할 수 있습니다.
 *
 * ```php
 * $member = Member::findMember($id);
 *
 * $name = $member->displayName;
 * ```
 *
 * 두번째 파라메터에 같이 가져올 회원관련 정보를 지정할 수 있습니다.
 * 두번째 파라메터에 지정할 수 있는 정보는 `accounts`, `groups`, `mails`, `pending_mails`가 있습니다.
 *
 * ```php
 * $member = Member::findMember($id, ['accounts', 'groups', 'mails'];
 *
 * $emails = $member->mails;
 *
 * foreach($emails as $email)
 * {
 * // 회원의 이메일주소 목록 출력
 * echo $email->address;
 * }
 * ```
 *
 * 만약 여러아이디에 해당하는 회원 목록을 조회하고 싶을 때에는 `findAllMember` 메소드를 사용하십시오
 *
 * ```php
 * $ids = [1,2,3];
 * $members = Member::findAllMember($ids);
 *
 * foreach($members as $member) {
 * ...
 * }
 * ```
 *
 * ### 회원 정보로 회원조회
 *
 * #### 단 한명의 회원정보 조회하기
 *
 * `fetchOneMember` 메소드를 사용하여 단 한명의 회원을 조회할 수 있습니다.
 *
 * ```php
 * $where = [
 * 'displayName' => 'foo',
 * ];
 *
 * $member = Member::fetchOneMember($where);
 * ```
 *
 * #### 조건에 해당하는 모든 회원정보 조회하기
 *
 * `fetchAllMember` 메소드를 사용하여 조건에 해당하는 모든 회원정보를 조회할 수 있습니다.
 *
 * ```php
 * $where = [
 * 'displayName' => 'foo',
 * ];
 *
 * $members = Member::fetchAllMember($where);
 *
 * ```
 *
 * #### Pagination된 조회결과 가져오기
 *
 * `fetchMember` 메소드를 사용하여 회원을 조회할 수 있습니다.
 * 이 메소드는 기본적으로 조회된 목록을 pagination하여 보여줍니다.
 *
 * > pagination의 page정보는 별도로 지정하지 않을 경우 현재 요청된 url의 page 파라메터를 사용합니다.
 * > pagination의 perPage정보는 별도로 지정하지 않을 경우 10으로 설정됩니다.
 *
 * ```php
 * $where = [
 * 'displayName' => 'foo',
 * ];
 *
 * $members = Member::fetchMember($where);
 * ```
 *
 * 회원관련정보를 같이 조회하고 싶을 때에는 두번째 파라메터를 사용하세요.
 *
 * ```php
 * $memberWithEmails = Member::fetchMember($where, ['mails']);
 * ```
 *
 * pagination정보(page, perPage, sort)를 자세히 지정하고 싶을 때에는, 세번째 파라메터를 사용하세요.
 *
 * ```php
 * // 5개 조회,
 * $members = Member::fetchMember($where, null, 5);
 * ```
 *
 * page:2, limit:5로 pagination을 설정할 경우
 *
 * ```php
 * // 2페이지의 5개 조회
 * $members = Member::fetchMember($where, null, [2, 5]);
 * ```
 *
 * 만약 특정 필드로 sorting을 하고 싶을 경우
 * ```php
 * // 변경일 순으로 2페이지의 5개 조회
 * $navigation = new stdClass();
 *
 * $navigation->page = 2;
 * $navigation->perPage = 5;
 * $navigation->order = 'desc';
 * $navigation->sort = 'updatedAt';
 *
 * $members = Member::fetchMember($where, null, $navigation);
 * ```
 *
 *
 * ### 모든 회원 조회
 *
 * #### 모든 회원 조회
 *
 * `allMember` 메소드를 사용하여 모든 회원을 조회할 수 있습니다.
 *
 * ```php
 * $allMembers = Member::allMember();
 * ```
 *
 * #### Pagination을 사용하여 모든 회원조회
 *
 * `pagenateMember` 메소드를 사용하여 pagination된 모든 회원을 조회할 수 있습니다.
 *
 * ```php
 * $members = Member::paginateMember();
 *
 * ```
 *
 * 회원관련정보를 같이 조회할 수 있습니다.
 *
 * ```php
 * $members = Member::paginateMember(['accounts']);
 * ```
 * pagination정보(page, perPage, sort)를 자세히 지정하고 싶을 때에는, 두번째 파라메터를 사용하세요.
 *
 * ```php
 * // 2페이지의 5개 조회
 * $members = Member::paginateMember(null, [2, 5]);
 * ```
 *
 *
 * ## 신규 회원 추가
 *
 * `create` 메소드를 사용하여 신규회원을 추가할 수 있습니다. `create` 메소드를 사용하면, 입력한 신규회원 정보에 대한 유효성 검사후 저장됩니다.
 *
 * ```php
 *
 * $data = [
 * 'displayName' => 'foo',
 * 'email' => 'foo@email.com',
 * //...
 * ]
 * $createdMember = Member::create($data);
 * ```
 *
 * 신규 회원의 외부 계정(account) 정보도 같이 추가할 수 있습니다.
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
 * $createdMember = Member::create($data);
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
 * $createdMember = Member::create($data);
 * ```
 *
 * 만약 유효성검사를 하지않고 직접 신규회원을 추가하고싶다면 `insertMember` 메소드를 사용하십시오.
 *
 * ```php
 * $data = [
 * 'displayName' => 'foo',
 * 'email' => 'foo@email.com',
 * 'password' => '...'
 * ]
 *
 * $createdMember = Member::insert($data);
 * ```
 *
 * > `주의!` `insertMember` 메소드는 `password`를 암호화하지 않고 바로 저장합니다.`password` 필드를 반드시 직접 암호화하십시오.
 *
 *
 * ## 회원정보 수정
 *
 * `updateMember` 메소드를 사용하면 회원정보를 변경할 수 있습니다.
 *
 * ```
 * $member = Member::find(20);
 * $member->displayName = 'modified name';
 *
 * $member = Member::updateMember($member);
 * ```
 *
 * ## 회원삭제
 *
 * `leave` 메소드를 사용하면 특정 회원을 탈퇴시킬 수 있습니다. `leave` 메소드를 사용하면
 * 탈퇴시킬 회원의 관련정보(accounts, mails, pending_mails, groups)도 같이 삭제됩니다.
 *
 * ```php
 * $ids = [12,23,34];
 * Member::leave($ids); // 3명의 회원을 탈퇴시킴
 * ```
 *
 * `deleteMember` 메소드를 사용하여 회원을 삭제할 수도 있습니다. 단, 이 메소드를 사용하면 삭제될 회원과 관련된 정보는 함께 삭제되지 않습니다.
 *
 * ```php
 * $member = Member::find(12);
 * Member::deleteMember($member);
 * ```
 *
 *
 * ## 회원과 관련된 정보의 조회 및 처리
 *
 * 회원계정(accounts), 회원이메일(mails), 회원 등록대기 이메일(pending_mails), 회원그룹(groups)과 같은 회원과 관련된 정보도
 * MemberHandler를 사용하여 조회하고 처리할 수 있습니다.
 *
 * 회원에 사용했던 메소드 중에 `create`, `leave` 메소드를 제외한 메소드는 회원과 관련된 정보에도 똑같은 방식으로 사용될 수 있습니다.
 *
 * 회원을 조회할 때 `findMember`를 사용합니다.
 * 만약 회원계정으로 조회할 때에는 'Member'를 'Account'로 변경한 `findAccount` 메소드를 사용하면 됩니다.
 *
 *
 * ```php
 * // 회원계정아이디로 회원계정정보 조회
 * $accountId = 123;
 * $account = Member::findAccount($accountId); // 메소드명에 Member 대신 Account 사용
 *
 * // 회원아이디로 회원이메일정보 조회
 * $mail = Member::fetchMail([
 * 'memberId'=>12
 * ]);
 *
 * ```
 *
 * 아래의 메소드는 회원, 회원계정, 회원그룹, 회원이메일, 회원 등록대기 이메일에 동일하게 적용될 수 있는 메소드 목록입니다.
 * 각 메소드명 뒤에 `Member`, `Account`, `Group`, `Mail`, `PendingMail`을 붙여서 사용하면 됩니다.
 * ```
 * has($id);
 *
 * find($id, $with = null);
 *
 * findAll($ids, $with = null);
 *
 * fetch($wheres, $with = null, $perPage = 10);
 *
 * fetchOne($wheres, $with = null);
 *
 * fetchAll($wheres, $with = null);
 *
 * paginate($with = null, $perPage = 10);
 *
 * all($with = null);
 *
 * search($searches, $wheres = null, $with = null, $perPage = 10);
 *
 * count($wheres = null);
 *
 * update($entity);
 *
 * delete($entity);
 *
 * insert($entity);
 * ```
 *
 * @category    Member
 * @package     Xpressengine\Member
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class MemberHandler
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
     * @var MemberRepositoryInterface 회원 저장소
     */
    protected $members;

    /**
     * @var AccountRepositoryInterface 회원계정 저장소
     */
    protected $accounts;

    /**
     * @var GroupRepositoryInterface 그룹 저장소
     */
    protected $groups;

    /**
     * @var VirtualGroupRepositoryInterface 가상그룹 저장소
     */
    protected $virtualGroups;

    /**
     * @var MailRepositoryInterface 회원 이메일 저장소
     */
    protected $mails;

    /**
     * @var PendingMailRepositoryInterface 회원 등록대기 이메일 저장소
     */
    private $pendingMails;

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
     * @param MemberRepositoryInterface       $members         MemberRepositoryInterface 회원 저장소
     * @param AccountRepositoryInterface      $accounts        AccountRepositoryInterface 회원계정 저장소
     * @param GroupRepositoryInterface        $groups          GroupRepositoryInterface 그룹 저장소
     * @param VirtualGroupRepositoryInterface $virtualGroups   가상그룹 저장소
     * @param MailRepositoryInterface         $mails           회원 이메일 저장소
     * @param PendingMailRepositoryInterface  $pendingMails    회원 등록대기 이메일 저장소
     * @param Hasher                          $hasher          해시코드 생성기, 비밀번호 해싱을 위해 사용됨
     * @param Validator                       $validator       유효성 검사기. 비밀번호 및 표시이름(dispalyName)의 유효성 검사를 위해 사용됨
     * @param Container                       $container       Xpressengine 레지스터
     * @param boolean                         $useEmailConfirm 이메일 인증의 사용여부
     */
    public function __construct(
        MemberRepositoryInterface $members,
        AccountRepositoryInterface $accounts,
        GroupRepositoryInterface $groups,
        VirtualGroupRepositoryInterface $virtualGroups,
        MailRepositoryInterface $mails,
        PendingMailRepositoryInterface $pendingMails,
        Hasher $hasher,
        Validator $validator,
        Container $container,
        $useEmailConfirm
    ) {
        $this->members = $members;
        $this->accounts = $accounts;
        $this->groups = $groups;
        $this->virtualGroups = $virtualGroups;
        $this->mails = $mails;
        $this->hasher = $hasher;
        $this->validator = $validator;
        $this->container = $container;
        $this->pendingMails = $pendingMails;
        $this->useEmailConfirm = $useEmailConfirm;
    }


    /**
     * MemberRepositoryInterface 회원 저장소를 반환한다.
     *
     * @return MemberRepositoryInterface
     */
    public function getMemberRepository()
    {
        return $this->members;
    }

    /**
     * AccountRepositoryInterface 회원계정 저장소를 반환한다.
     *
     * @return AccountRepositoryInterface
     */
    public function getAccountRepository()
    {
        return $this->accounts;
    }

    /**
     * GroupRepositoryInterface 그룹 저장소를 반환한다.
     *
     * @return GroupRepositoryInterface
     */
    public function getGroupRepository()
    {
        return $this->groups;
    }

    /**
     * 가상그룹 저장소를 반환한다.
     *
     * @return VirtualGroupRepositoryInterface
     */
    public function getVirtualGroupRepository()
    {
        return $this->virtualGroups;
    }

    /**
     * 회원 이메일 저장소를 반환한다.
     *
     * @return MailRepositoryInterface
     */
    public function getMailRepository()
    {
        return $this->mails;
    }

    /**
     * 회원 등록대기 이메일 저장소를 반환한다.
     *
     * @return PendingMailRepositoryInterface
     */
    public function getPendingMailRepository()
    {
        return $this->mails;
    }

    /**
     * 주어진 정보로 신규회원을 등록한다. 회원정보에 대한 유효성검사도 병행하며, 회원관련 정보(그룹, 이메일, 등록대기 이메일, 계정)도 동시에 추가한다.
     *
     * @param array $data 신규회원 정보
     *
     * @return MemberEntityInterface 신규 등록된 회원정보
     */
    public function create(array $data)
    {

        $this->validateForCreate($data);

        /* 회원가입 절차 */
        $memberData = array_except(
            $data,
            ['emailConfirmed', 'groupId', 'password_confirmation', 'account']
        );

        // insert member
        if (array_has($memberData, 'password')) {
            $memberData['password'] = $this->hasher->make($memberData['password']);
        }
        $member = $this->members->insert(new MemberEntity($memberData));

        // insert mail
        if (isset($memberData['email'])) {
            $mailData = [
                'memberId' => $member->id,
                'address' => $member->email,
            ];
            if ($this->useEmailConfirm === false || array_get($data, 'emailConfirmed', false)) {
                $mail = new MailEntity($mailData);
                $mail = $this->mails->insert($mail);
                $member->mails = [$mail];
            } else {
                $mail = new PendingMailEntity($mailData);
                $mail = $this->pendingMails->insert($mail);
                $member->pending_mails = [$mail];
            }
        }

        // join group
        $groupIds = array_get($data, 'groupId', []);
        if (count($groupIds) > 0) {
            $groups = $this->groups->findAll($groupIds);
            foreach ($groups as $group) {
                $this->groups->addUser($group, $member);
            }
            $member->groups = $groups;
        }

        // insert accounts
        if (isset($data['account'])) {
            $accountData = $data['account'];
            $account = new AccountEntity(
                [
                    'memberId' => $member->id,
                    'accountId' => array_get($accountData, 'accountId'),
                    'email' => array_get($accountData, 'email', array_get($data, 'email')),
                    'provider' => array_get($accountData, 'provider'),
                    'data' => array_get($accountData, 'data'),
                    'token' => array_get($accountData, 'token'),
                ]
            );
            $account = $this->accounts->insert($account);
            $member->accounts = new Collection([$account]);
        }
        return $member;
    }

    /**
     * 회원탈퇴 처리를 한다. 회원관련 정보(그룹, 이메일, 등록대기 이메일, 계정)도 동시에 삭제한다.
     *
     * @param string|string[] $memberIds 탈퇴할 회원의 회원아이디 목록
     *
     * @return void
     */
    public function leave($memberIds)
    {

        $members = $this->members->findAll((array) $memberIds, ['groups', 'mails']);

        $ratings = array_pluck($members, 'rating');
        if (in_array(Rating::SUPER, $ratings)) {
            throw new CannotDeleteMemberHavingSuperRatingException();
        }

        foreach ($members as $member) {
            // except from member's groups
            if (isset($member->groups)) {
                foreach ($member->groups as $group) {
                    $this->groups->exceptUser($group, $member);
                }
            }
            // delete member
            $this->members->delete($member);
        }

        // delete member's mails
        $this->mails->deleteByUserIds($memberIds);
        $this->pendingMails->deleteByMemberIds($memberIds);

        // delete member's accounts
        $this->accounts->deleteByUserIds($memberIds);
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

        // email이나 account중 하나가 반드시 있어야 한다.
        if (!isset($data['email']) && !isset($data['account'])) {
            $e = new InvalidArgumentException();
            $e->setMessage('email이나 account중 하나가 반드시 있어야 합니다.');
            throw $e;
        }

        // email, dispalyName 중복검사
        if (isset($data['email'])) {
            if ($this->findMailByAddress($data['email']) !== null) {
                throw new MailAlreadyExistsException();
            }
        }

        // displayName 검사
        $this->validateDisplayName($data['displayName']);

        if (isset($data['account'])) {
            $account = $data['account'];
            if (!isset($account['accountId'], $account['provider'], $account['data'], $account['token'])) {
                $e = new InvalidArgumentException();
                $e->setMessage('account 정보가 올바르지 않습니다.');
                throw $e;
            }

            if ($this->fetchOneAccount(array_only($account, ['accountId', 'providor'])) !== null) {
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

        if ($this->members->fetchOne(['displayName' => $name]) !== null) {
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
        $menus = $this->container->get('member/settings/section');
        return array_merge($this->settingsSections, $menus ?: []);
    }

    /**
     * 주어진 entity에 연관된 회원정보를 생성하여 연결시켜준다.
     *
     * @param AssociateInterface $entity 회원정보를 연결할 entity
     *
     * @return AssociateInterface 회원정보가 연결된 entity
     */
    public function associate(AssociateInterface $entity)
    {
        $memberId = $entity->getMemberOriginId();
        $entity->setMemberEntity($memberId !== null ? $this->getMemberRepository()->find($memberId) : new Guest());

        return $entity;
    }

    /**
     * 주어진 entity들에 연관된 회원정보를 생성하여 연결시켜준다.
     *
     * @param AssociateInterface[] $entities 회원정보를 연결할 entity들
     *
     * @return AssociateInterface[] 회원정보가 연결된 entity들
     */
    public function associates($entities)
    {
        $memberIds = [];
        foreach ($entities as $entity) {
            $memberId = $entity->getMemberOriginId();

            if ($memberId == null) {
                $entity->setMemberEntity(new Guest());
                continue;
            }

            if (!isset($memberIds[$memberId])) {
                $memberIds[$memberId] = [];
            }
            $memberIds[$memberId][] = $entity;
        }
        $members = $this->getMemberRepository()->findAll(array_keys($memberIds));

        foreach ($members as $member) {
            foreach ($memberIds[$member->getId()] as $entity) {
                $entity->setMemberEntity($member);
            }
        }

        return $entities;
    }
}

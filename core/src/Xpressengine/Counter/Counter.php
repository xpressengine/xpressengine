<?php
/**
 * Counter
 *
 * PHP version 5
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Counter;

use Xpressengine\Counter\Exceptions\GuestNotSupportException;
use Xpressengine\Counter\Exceptions\InvalidOptionException;
use Xpressengine\Counter\Models\CounterLog;
use Xpressengine\Http\Request;
use Xpressengine\User\Models\Guest;
use Xpressengine\User\UserInterface;

/**
 * Counter
 *
 * * Factory 에 의해서 인스턴스 생성
 * * $name, $options 멤버 변수를 이용해서 등록, 조회, 삭제할 때
 * counter_logs 테이블의 counterName, counterOption 컬럼에 사용
 * * $name 에 따라 여러 유형의 Counter 인스턴스를 만들 수 있음
 * * $options 는 $name 에서 사용할 option 항목
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Counter
{
    /**
     * model class name
     *
     * @var
     */
    protected $model = CounterLog::class;

    /**
     * @var Request
     */
    protected $request;

    /**
     * 카운터 이름
     *
     * @var string
     */
    protected $name;

    /**
     * 카운터에 사용할 선택 항목
     *
     * @var array
     */
    protected $options = [];

    /**
     * 비회원 지원
     *
     * @var bool
     */
    protected $guest = false;

    /**
     * Counter constructor.
     *
     * @param Request $request request
     * @param string  $name    counter name
     * @param array   $options counter options
     */
    public function __construct(Request $request, $name, $options = [])
    {
        $this->request = $request;
        $this->name = $name;
        $this->options = $options;
    }

    /**
     * 비회원 지원 설정
     *
     * @param bool $use guest support flag
     * @return void
     */
    public function setGuest($use = true)
    {
        $this->guest = $use;
    }

    /**
     * get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * get options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * check option
     *
     * @param string $option counter option
     * @return void
     * @throws InvalidOptionException
     */
    protected function checkOption($option)
    {
        if (count($this->options) === 0 && $option !== '') {
            throw new InvalidOptionException(['name' => $this->name, 'option' => $option]);
        } elseif (count($this->options) > 0 && in_array($option, $this->options) === false) {
            throw new InvalidOptionException(['name' => $this->name, 'option' => $option]);
        }
    }

    /**
     * check support guest
     *
     * @param UserInterface|null $user user
     * @return void
     * @throws GuestNotSupportException
     */
    protected function checkGuest(UserInterface $user = null)
    {
        if ($this->guest == false && ($user == null || $user instanceof Guest)) {
            throw new GuestNotSupportException(['name' => $this->name]);
        }
    }

    /**
     * has by name
     *
     * @param string             $targetId targetId
     * @param UserInterface|null $user     user instance
     * @return bool
     */
    public function hasByName($targetId, UserInterface $user = null)
    {
        return $this->getByName($targetId, $user) !== null;
    }

    /**
     * has log
     *
     * @param string             $targetId target id
     * @param UserInterface|null $user     user instance
     * @param string             $option   counter option
     * @return bool
     */
    public function has($targetId, UserInterface $user = null, $option = '')
    {
        return $this->get($targetId, $user, $option) !== null;
    }

    /**
     * add log
     *
     * @param string             $targetId target id
     * @param UserInterface|null $user     user instance
     * @param string             $option   counter option
     * @param int                $point    point
     * @return void
     */
    public function add($targetId, UserInterface $user = null, $option = '', $point = 1)
    {
        $this->checkOption($option);
        $this->checkGuest($user);

        $counterLog = $this->newModel();
        $counterLog->counter_name = $this->name;
        $counterLog->counter_option = $option;
        $counterLog->target_id = $targetId;
        if ($user == null || $user instanceof Guest) {
            $counterLog->user_id = '';
        } else {
            $counterLog->user_id = $user->getId();
        }

        $counterLog->point = $point;
        $counterLog->ipaddress = $this->request->ip();
        $counterLog->created_at = $counterLog->freshTimestamp();

        $counterLog->save();
    }

    /**
     * remove log
     *
     * @param string             $targetId target id
     * @param UserInterface|null $user     user instance
     * @param string             $option   counter option
     * @return void
     */
    public function remove($targetId, UserInterface $user = null, $option = '')
    {
        $this->checkOption($option);
        $this->checkGuest($user);

        if ($this->guest == true && ($user == null || $user instanceof Guest)) {
            $this->newModel()->where('target_id', $targetId)->where('ipaddress', $this->request->ip())
                ->where('counter_name', $this->name)->where('counter_option', $option)->delete();
        } else {
            $this->newModel()->where('target_id', $targetId)->where('user_id', $user->getId())
                ->where('counter_name', $this->name)->where('counter_option', $option)->delete();
        }
    }

    /**
     * get log
     *
     * @param string             $targetId target id
     * @param UserInterface|null $user     user instance
     * @param string             $option   counter option
     * @return CounterLog|null
     */
    public function get($targetId, UserInterface $user = null, $option = '')
    {
        if ($this->guest === true && ($user === null || $user instanceof Guest)) {
            return $this->newModel()->where('target_id', $targetId)->where('ipaddress', $this->request->ip())
                ->where('counter_name', $this->name)->where('counter_option', $option)->first();
        } else {
            return $this->newModel()->where('target_id', $targetId)->where('user_id', $user->getId())
                ->where('counter_name', $this->name)->where('counter_option', $option)->first();
        }
    }

    /**
     * get log by name
     * 옵션을 사용하는 Counter 에서 로그를 확인 할 때
     * 등록된 옵션은 제외하고 확인하려고 할 수 있음
     *
     * @param string             $targetId target id
     * @param UserInterface|null $user     user instance
     * @return CounterLog|null
     */
    public function getByName($targetId, UserInterface $user = null)
    {
        if ($this->guest == true && ($user == null || $user instanceof Guest)) {
            return $this->newModel()->where('target_id', $targetId)->where('ipaddress', $this->request->ip())
                ->where('counter_name', $this->name)->first();
        } else {
            return $this->newModel()->where('target_id', $targetId)->where('user_id', $user->getId())
                ->where('counter_name', $this->name)->first();
        }
    }

    /**
     * get point sum
     *
     * @param string $targetId target id
     * @param string $option   counter option
     * @return int
     */
    public function getPoint($targetId, $option = '')
    {
        $this->checkOption($option);

        return $this->newModel()->where('target_id', $targetId)
            ->where('counter_name', $this->name)->where('counter_option', $option)->sum('point');
    }

    /**
     * put log
     *
     * @param string             $targetId target id
     * @param UserInterface|null $user     user instance
     * @param string             $option   counter option
     * @param int                $point    point
     * @return void
     */
    public function putPoint($targetId, UserInterface $user = null, $option = '', $point = 1)
    {
        $this->checkOption($option);
        $this->checkGuest($user);

        $query = $this->newModel()
            ->where('target_id', $targetId)
            ->where('counter_name', $this->name)
            ->where('counter_option', $option);
        if ($user == null || $user instanceof Guest) {
            $userId= '';
        } else {
            $userId = $user->getId();
        }
        $counterLog = $query->where('user_id', $userId)->first();

        if ($counterLog !== null) {
            $counterLog->point = $point;
            $counterLog->save();
        }
    }

    /**
     * get users
     *
     * @param string $targetId target id
     * @param string $option   counter option
     * @return array
     */
    public function getUsers($targetId, $option = '')
    {
        $this->checkOption($option);

        $logs = $this->newModel()->where('target_id', $targetId)
            ->where('counter_name', $this->name)->where('counter_option', $option)->get();

        $users = [];
        foreach ($logs as $log) {
            $users[] = $log->user;
        }
        return $users;
    }

    /**
     * The name of CounterLog model class
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Create model instance
     *
     * @return CounterLog
     */
    public function newModel()
    {
        $class = $this->getModel();

        return new $class;
    }
}

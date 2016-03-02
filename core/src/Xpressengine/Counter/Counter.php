<?php
/**
 * Counter
 *
 * PHP version 5
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Counter;

use Xpressengine\Counter\Exceptions\GuestNotSupportException;
use Xpressengine\Counter\Exceptions\InvalidOptionException;
use Xpressengine\Counter\Models\CounterLog;
use Xpressengine\Http\Request;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\User\Models\Guest;

/**
 * Counter
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Counter
{
    /**
     * @var Request
     */
    protected $request;

    protected $name;

    protected $options = [];

    /**
     * guest type user support
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
     * set guest support option
     *
     * @param $use
     */
    public function setGuest($use = true)
    {
        $this->guest = $use;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * check option
     *
     * @param string $option counter option
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

    public function hasByName($targetId, MemberEntityInterface $user = null)
    {
        return $this->getByName($targetId, $user) !== null;
    }

    /**
     * has log
     *
     * @param string                     $targetId target id
     * @param MemberEntityInterface|null $user
     * @param string                     $option counter option
     * @return bool
     */
    public function has($targetId, MemberEntityInterface $user = null, $option = '')
    {
        return $this->get($targetId, $user, $option) !== null;
    }

    /**
     * add log
     *
     * @param string                     $targetId target id
     * @param MemberEntityInterface|null $user
     * @param string                     $option counter option
     * @param int $point
     */
    public function add($targetId, MemberEntityInterface $user = null, $option = '', $point = 1)
    {
        $this->checkOption($option);

        if ($this->guest == false && ($user == null || $user instanceof Guest)) {
            throw new GuestNotSupportException(['name' => $this->name]);
        }

        $counterLog = new CounterLog;
        $counterLog->counterName = $this->name;
        $counterLog->counterOption = $option;
        $counterLog->targetId = $targetId;
        if ($user == null || $user instanceof Guest) {
            $counterLog->userId = '';
        } else {
            $counterLog->userId = $user->getId();
        }

        $counterLog->point = $point;
        $counterLog->ipaddress = $this->request->ip();

        $counterLog->save();
    }

    /**
     * remove log
     *
     * @param string                     $targetId target id
     * @param MemberEntityInterface|null $user
     * @param string                     $option counter option
     * @return mixed
     */
    public function remove($targetId, MemberEntityInterface $user = null, $option = '')
    {
        $this->checkOption($option);

        if ($this->guest == true && ($user == null || $user instanceof Guest)) {
            CounterLog::where('targetId', $targetId)->where('ipaddress', $this->request->ip())
                ->where('counterName', $this->name)->where('counterOption', $option)->delete();
        } else {
            return CounterLog::where('targetId', $targetId)->where('userId', $user->getId())
                ->where('counterName', $this->name)->where('counterOption', $option)->delete();
        }
    }

    /**
     * get log
     *
     * @param string                     $targetId target id
     * @param MemberEntityInterface|null $user
     * @param string                     $option counter option
     * @return mixed
     */
    public function get($targetId, MemberEntityInterface $user = null, $option = '')
    {
        $this->checkOption($option);

        if ($this->guest == true && ($user == null || $user instanceof Guest)) {
            return CounterLog::where('targetId', $targetId)->where('ipaddress', $this->request->ip())
                ->where('counterName', $this->name)->where('counterOption', $option)->first();
        } else {
            return CounterLog::where('targetId', $targetId)->where('userId', $user->getId())
                ->where('counterName', $this->name)->where('counterOption', $option)->first();
        }
    }

    public function getByName($targetId, MemberEntityInterface $user = null)
    {
        if ($this->guest == true && ($user == null || $user instanceof Guest)) {
            return CounterLog::where('targetId', $targetId)->where('ipaddress', $this->request->ip())
                ->where('counterName', $this->name)->first();
        } else {
            return CounterLog::where('targetId', $targetId)->where('userId', $user->getId())
                ->where('counterName', $this->name)->first();
        }
    }

    /**
     * get point sum
     *
     * @param string $targetId target id
     * @param string $option   counter option
     * @return mixed
     */
    public function getPoint($targetId, $option = '')
    {
        $this->checkOption($option);

        return CounterLog::where('targetId', $targetId)
            ->where('counterName', $this->name)->where('counterOption', $option)->sum('point');
    }

    /**
     * get users
     *
     * @param string $targetId target id
     * @param string $option   counter option
     * @return mixed
     */
    public function getUsers($targetId, $option = '')
    {
        $this->checkOption($option);

        return CounterLog::where('targetId', $targetId)
            ->where('counterName', $this->name)->where('counterOption', $option)->users;
    }
}
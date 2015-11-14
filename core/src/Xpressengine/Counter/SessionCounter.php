<?php
/**
 * SessionCounter class
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

use Illuminate\Session\SessionInterface;

/**
 * SessionCounter
 *
 * * 비회원인 경우 세션을 이용해 카운트 할 수 있도록 지원
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class SessionCounter
{

    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $option = 'default';

    /**
     * session name
     */
    const SESSION_NAME = 'COUNTER';

    /**
     * option name
     */
    const OPTION_SESSION_NAME = 'COUNTER_OPTION';

    /**
     * create instance
     *
     * @param SessionInterface $session session store
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;

        if ($this->session->get(self::SESSION_NAME) == null) {
            $this->session->set(self::SESSION_NAME, []);
        }
    }

    /**
     * counterName, counterOption 설정
     *
     * @param string $name   counter name
     * @param string $option counter option
     * @return void
     */
    public function init($name, $option)
    {
        $this->name = $name;
        $this->option = $option;
    }

    /**
     * session 정보 반환
     *
     * @return array
     */
    private function getSession()
    {
        $session = $this->session->get(self::SESSION_NAME);

        if (empty($session[$this->name])) {
            $session[$this->name] = [];
        }
        return $session[$this->name];
    }

    /**
     * session 정보 업데이트
     *
     * @param array $session session information
     * @return void
     */
    private function putSession($session)
    {
        $this->session->set(self::SESSION_NAME, array_merge(
            $this->session->get(self::SESSION_NAME),
            [$this->name => $session]
        ));
    }

    /**
     * add counter log
     *
     * @param string $targetId target id(document id)
     * @return void
     */
    public function add($targetId)
    {
        $session = $this->getSession();

        if (!in_array($targetId, $session)) {
            $session[] = $targetId;
        }

        $this->putSession($session);
    }

    /**
     * 세션 정보 제거
     *
     * @param string $targetId target id(document id)
     * @return void
     */
    public function remove($targetId)
    {
        $session = $this->getSession();
        $key = array_search($targetId, $session);
        if ($key !== false) {
            unset($session[$key]);
        }

        $this->putSession($session);
    }

    /**
     * 카운터에 포함 되어있는지 반환
     *
     * @param string $targetId target id(document id)
     * @return bool
     */
    public function invoked($targetId)
    {
        $session = $this->getSession();
        return in_array($targetId, $session);
    }
}

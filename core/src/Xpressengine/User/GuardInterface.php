<?php
/**
 *  This file is part of the Xpressengine package.
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

use Illuminate\Contracts\Auth\Guard as GuardContract;
use Xpressengine\User\Models\Guest;

/**
 * 이 인터페이스는 Xpressengine의 인증클래스가 구현해야 하는 인터페이스이다.
 * Laravel의 기본 인터페이스에 makeGuest가 추가되었다.
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface GuardInterface extends GuardContract
{
    /**
     * Guest 회원 인스턴스를 생성하여 반환한다.
     *
     * @return Guest
     */
    public function makeGuest();

    /**
     * 관리자 인증 검사
     *
     * @param bool $refresh 인증 세션 시간 갱신 여부
     *
     * @return mixed
     */
    public function checkAdminAuth($refresh = false);

    /**
     * 관리자 인증 시도
     *
     * @param array $credentials 인증 정보
     *
     * @return mixed
     */
    public function attemptAdminAuth($credentials);
}

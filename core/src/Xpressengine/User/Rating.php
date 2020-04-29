<?php
/**
 * This file is a rating of user
 *
 * PHP version 7
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User;

use Xpressengine\User\Exceptions\UnknownCriterionException;

/**
 * 회원의 등급을 나타내는 클래스
 * 키워드를 통해 더 높은 등급인지 판별해주는 기능을 제공함
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Rating
{
    /**
     * Guest 회원 등급
     */
    const GUEST = 'guest';

    /**
     * 일반 회원 등급
     */
    const USER = 'user';

    /**
     * 관리자 회원등급
     */
    const MANAGER = 'manager';

    /**
     * 최고 관리자 회원등급
     */
    const SUPER = 'super';

    /**
     * 회원등급 목록
     *
     * @var array
     */
    protected static $ratings = [self::GUEST, self::USER, self::MANAGER, self::SUPER];

    /**
     * 주어진 키워드와 기준이 되는 키워드의 등급의 높낮이 비교
     *
     * @param string $type      target rating keyword
     * @param string $criterion criterion keyword
     *
     * @return int
     * @throws UnknownCriterionException
     */
    public static function compare($type, $criterion)
    {
        $inKey = array_search($type, static::$ratings);
        $criterionKey = array_search($criterion, static::$ratings);

        if ($criterionKey === false) {
            throw new UnknownCriterionException(compact('criterion'));
        }

        if ($inKey == $criterionKey) {
            return 0;
        }

        return $inKey > $criterionKey ? 1 : -1;
    }

    /**
     * 사용 가능한 회원등급을 반환
     *
     * guest 는 비회원 상태이므로 배제시킴
     *
     * @return array
     */
    public static function getUsableAll()
    {
        return array_diff(static::$ratings, [static::GUEST]);
    }

    /**
     * getAll
     *
     * @return array
     */
    public static function getAll()
    {
        return static::$ratings;
    }
}

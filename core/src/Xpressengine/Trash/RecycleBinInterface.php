<?php
/**
 * RecycleBinInterface
 *
 * PHP version 7
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Trash;

/**
 * RecycleBinInterface
 *
 * 휴지통 패키지에 등록하기 위해서 이 인터페이스를 따라야 한다.
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface RecycleBinInterface
{
    /**
     * 휴지통 이름 반환
     *
     * @return string
     */
    public static function name();

    /**
     * 휴지통 비우기 처리할 때 수행해야 할 코드 입력
     * TrashManager 에서 휴지통 비우기(clean()) 가 처리될 때 사용
     *
     * @return void
     */
    public static function clean();

    /**
     * 휴지통 패키지에서 각 휴지통의 상태를 알 수 있도록 정보를 반환
     * 휴지통에 얼마만큼의 정보가 있는지 알려주기 위한 인터페이스
     *
     * @return string
     */
    public static function summary();
}

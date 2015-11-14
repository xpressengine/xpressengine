<?php
/**
 * class Undo for Facade
 *
 * PHP version 5
 *
 * @category    Undo
 * @package     Xpressengine\Undo
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * 현재 package를 facade로 이용하기 위한 클래스
 * 호출됐을시 연결할 대상을 지정 함
 *
 *
 * @category    Undo
 * @package     Xpressengine\Undo
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Undo  extends Facade
{
    /**
     * connect to
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'xe.undo';
    }
}

<?php
/**
 * TrashManager
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Trash;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Register\Container;
use Closure;

/**
 * # TrashManager
 * 이 클래스는 Xpressengine에서 사용되는 휴지통을 관리하고 처리한다.
 * 휴지통은 별도의 데이터를 담고 있지 않는다.
 * 이 클래스는 전체 휴지통을 공통의 인터페이스로 관리하고
 * 휴지통 비우는 작업을 처리하는데 목적이 있다.
 * * 각 패키지 또는 모듈은 휴지통을 갖을 수 있다.
 * * 각 패키지 또는 모듈은 휴지통을 비우기 위한 별도의 작업을 할 필요가 없으며
 * Trash 패키지가 휴지통 비우는 작업을 대신한다.
 *
 * ## TrashManager 에 휴지통 등록
 * ```php
 *
 * Trash::register(NAMESPACE\CLASS_NAME::class);
 *
 * ```
 *
 * ## 휴지통 정보 출력
 * ```php
 *
 * $trashes = Trash::gets();
 * foreach ($trashes as $trash) {
 *   echo $trash::summary();
 * }
 *
 * ```
 *
 * ## 휴지통 비우기
 * ```php
 *
 * Trash::clean();
 *
 * ```
 *
 *  $register = new Container();
 *
 *  // blue 테마를 Xpressengine의 theme로 등록할 경우 Key는 'theme|blue'로 지정할 수 있다.
 *  $register->add('theme/blue', 'Theme\Blue');
 *
 *  // 등록된 모든 테마 목록('theme')을 조회
 *  $registeredThemes = $register->get('theme'); // output: ['theme|blue' => 'Theme\Blue']
 *
 *  // key가 'theme|blue'인 요소를 조회
 *  $registeredThemes = $register->get('theme|blue'); // output: 'Theme\Blue'
 *
 * ```
 *
 * # Command
 * * 휴지통을 위한 command를 제공합니다.
 *
 * ## 휴지통 정보 확인
 * ```
 *
 * php artisan trash
 *
 * php artisan trash basket-name
 *
 * php artisan trash --names=basket-name1,basket-name2,..
 *
 * ```
 *
 * ## 휴지통 비우기
 * ```
 *
 * php artisan trash clean
 *
 * php artisan trash clean basket-name
 *
 * php artisan trash clean --names=basket-name1,basket-name2,..
 *
 * ```
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 */
class TrashManager
{

    /**
     * @var Container
     */
    protected $register;

    /**
     * @var VirtualConnectionInterface
     */
    protected $conn;

    const REGISTER_KEY = 'trash';

    /**
     * create instance
     *
     * @param Container                  $register container
     * @param VirtualConnectionInterface $conn     database connection
     */
    public function __construct(Container $register, VirtualConnectionInterface $conn)
    {
        $this->register = $register;
        $this->conn = $conn;

        $this->register->set(self::REGISTER_KEY, []);
    }

    /**
     * 휴지통 등록
     *
     * @param string $className 휴지통 class 이름
     * @return void
     */
    public function register($className)
    {
        $this->register->push(self::REGISTER_KEY, $className);
    }

    /**
     * 휴지통 반환
     *
     * @return WasteInterface[]
     */
    public function gets()
    {
        return $this->register->get(self::REGISTER_KEY);
    }

    /**
     * 휴지통 이름 반환
     *
     * @return array
     */
    public function names()
    {
        $wastes = $this->gets();

        $names = [];
        foreach ($wastes as $waste) {
            $names[] = [
                'name' => $waste::name(),
                'waste' => $waste,
            ];
        }

        return $names;
    }

    /**
     * 휴지통 비우기
     *
     * @param array   $wastes   waste list
     * @param Closure $callback call back
     * @return void
     */
    public function clean($wastes = [], Closure $callback = null)
    {
        if ($wastes == []) {
            $wastes = $this->gets();
        }

        foreach ($wastes as $waste) {
            if (is_subclass_of($waste, '\Xpressengine\Trash\WasteInterface') === false) {
                throw new Exceptions\InvalidWasteException;
            }
        }

        foreach ($wastes as $waste) {
            /**
             * Todo callback 을 어떻게 할지..
             */
            $ret = $waste::clean();
            if ($callback != null) {
                call_user_func_array($callback, [$ret]);
            }
        }
    }
}

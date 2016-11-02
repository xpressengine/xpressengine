<?php
/**
 * TrashManager
 *
 * PHP version 5
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Trash;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Register\Container;
use Closure;
use Xpressengine\Trash\Exceptions\NotFoundRecycleBinException;

/**
 * TrashManager
 *
 * * Xpressengine에서 사용되는 휴지통을 관리하고 휴지통 비우기 처리
 * * 휴지통은 별도의 데이터를 담고 있지 않고 휴지통을 비우는 요청이 발생할 경우
 * 구현체를 실행함
 * * 실제 데이터를 삭제하는 과정은 각 구현체가 직접 처리
 *
 * ## TrashManager 에 휴지통 등록
 * ```php
 *
 * XeTrash::register(NAME_SPACE\CLASS_NAME::class);
 *
 * ```
 *
 * ## 휴지통 요약 정보 확인
 * ```php
 *
 * $bins = XeTrash::gets();
 * foreach ($bins as $bin) {
 *   echo $bin::summary();
 * }
 *
 * ```
 *
 * ## 전체 휴지통 비우기
 * ```php
 *
 * XeTrash::clean();
 *
 * ```
 *
 * # Command
 * * 휴지통을 위한 command 제공
 *
 * ## 휴지통 정보 확인
 * ```
 *
 * php artisan trash
 *
 * php artisan trash recycle-bin-name
 *
 * php artisan trash recycle-bin-name1,recycle-bin-name2,..
 *
 * ```
 *
 * ## 휴지통 비우기
 * ```
 *
 * php artisan trash:clean
 *
 * php artisan trash:clean recycle-bin-name
 *
 * php artisan trash:clean recycle-bin-name1,recycle-bin-name2,..
 *
 * ```
 *
 * @category    Trash
 * @package     Xpressengine\Trash
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
     * 전체 휴지통 반환
     *
     * @return RecycleBinInterface[]
     */
    public function gets()
    {
        return $this->register->get(self::REGISTER_KEY);
    }

    /**
     * 휴지통 반환
     *
     * @param string $name name
     * @return RecycleBinInterface
     */
    public function get($name)
    {
        $names = $this->bins();
        if (empty($names[$name])) {
            throw new NotFoundRecycleBinException;
        }

        return $names[$name];
    }

    /**
     * 휴지통 이름 반환
     *
     * @return array
     */
    public function bins()
    {
        $bins = [];
        foreach ($this->gets() as $bin) {
            $bins[$bin::name()] = $bin;
        }

        return $bins;
    }

    /**
     * 휴지통 비우기
     *
     * @param array   $bins     bin list
     * @param Closure $callback call back
     * @return void
     */
    public function clean($bins = [], Closure $callback = null)
    {
        if ($bins == []) {
            $bins = $this->gets();
        }

        foreach ($bins as $bin) {
            if (is_subclass_of($bin, '\Xpressengine\Trash\RecycleBinInterface') === false ||
                is_subclass_of($bin, '\Xpressengine\Trash\RecycleBinInterface') === false) {
                throw new Exceptions\InvalidRecycleBinException;
            }
        }

        /** @var RecycleBinInterface $bin */
        foreach ($bins as $bin) {
            $bin::clean();
            if ($callback != null) {
                call_user_func_array($callback, []);
            }
        }
    }
}

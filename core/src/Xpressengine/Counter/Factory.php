<?php
/**
 * Factory
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

use Xpressengine\Http\Request;
use Xpressengine\Interception\InterceptionHandler;

/**
 * Factory
 * 설정에 따라 Counter 인스턴스를 획득하여 사용할 수 있도록 함
 *
 * Factory::make() 로 반환된 Counter 는 Interception Proxy 인스턴스로 intercept 할 수 있음,
 * Counter class 에서 제공하는 모든 메소드에 intercept 할 수 있음
 *
 * ## app binding
 * * xe.counter 로 바인딩 되어있음
 * * XeCounter Facade 로 접근이 가능함
 *
 * ## 사용법
 *
 * ### Counter 인스턴스 반환
 * ```php
 * // 문서 조회에 사용할 카운터 반환
 * $readCounter = XeCounter::make($request, 'read');
 *
 * // 투표(찬성, 반대)에 사용할 카운터 반환
 * $voteCounter = XeCounter::make($request, 'vote', ['accent', diccent']);
 * ```
 *
 * ### 문서 조회할 때 로그 기록 후 총 조회수 반환
 * ```php
 * $readCounter = XeCounter::make($request, 'read');
 *
 * $user = Auth::user();
 * if ($readCounter->has($documentId, $user) === true) {
 *   $readCounter->add($documentId, $user);
 * }
 *
 * $readCounter = $readCounter->getPoint($documentId);
 * ```
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Factory
{
    /**
     * Counter 를 Intercept 할 수 있도록 proxy 를 만들어 놓음
     *
     * @var string
     */
    protected $proxy;

    /**
     * Factory constructor.
     *
     * @param InterceptionHandler $interception intercption handler
     */
    public function __construct(InterceptionHandler $interception)
    {
        $this->proxy = $interception->proxy(Counter::class, 'Counter');
    }

    /**
     * counter instance 반환
     *
     * @param Request $request request
     * @param string  $name    counter name
     * @param array   $options counter options
     * @return Counter
     */
    public function make(Request $request, $name, $options = [])
    {
        return new $this->proxy($request, $name, $options);
    }
}

<?php
/**
 * Factory
 *
 * PHP version 7
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Counter;

use Xpressengine\Http\Request;
use Xpressengine\Interception\InterceptionHandler;

/**
 * Factory
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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

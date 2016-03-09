<?php
/**
 * CounterHandler
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

use Xpressengine\Http\Request;
use Xpressengine\Interception\InterceptionHandler;

/**
 * CounterHandler
 *
 * @category    Counter
 * @package     Xpressengine\Counter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Factory
{
    protected $proxy;

    public function __construct(InterceptionHandler $interception)
    {
        $this->proxy = $interception->proxy(Counter::class, 'Counter');
    }

    public function make(Request $request, $name, $options = [])
    {
        return new $this->proxy($request, $name, $options);
    }
}

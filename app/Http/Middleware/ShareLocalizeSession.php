<?php
/**
 * ShareLocalizeSession.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Foundation\Application;

/**
 * Class ShareLocalizeSession
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ShareLocalizeSession
{
    /**
     * Application instance
     *
     * @var Application
     */
    private $app;

    /**
     * LangPreprocessor constructor.
     *
     * @param Application $app Application instance
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request request
     * @param \Closure                 $next    to be called next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($id = $this->getShareSessionId($request)) {
            $this->app['session']->flush();
            $this->app['session']->setId($id);
            $this->app['session']->start();
        }

        if ($request->method() === 'GET' && array_has($queries = $request->query->all(), '_s')) {
            $queries = array_except($queries, '_s');
            return redirect($request->url().(count($queries) > 0 ? '?'.http_build_query($queries) : ''));
        }

        return $next($request);
    }

    /**
     * Get the session id for shared
     *
     * @param \Illuminate\Http\Request $request request
     * @return null|string
     */
    protected function getShareSessionId($request)
    {
        if (!$this->isShouldSessionBeShared($request)) {
            return null;
        }

        return $this->app['session']->isValidId($id = decrypt($request->get('_s'))) ? $id : null;
    }

    /**
     * Determine if the session id should be shared
     *
     * @param \Illuminate\Http\Request $request request
     * @return bool
     */
    protected function isShouldSessionBeShared($request)
    {
        return $this->app['config']['xe.lang.locale_type'] === 'domain' &&
            $request->method() === 'GET' &&
            $request->get('_s');
    }
}

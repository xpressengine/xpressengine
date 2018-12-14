<?php
/**
 * ExceptAppendableVerifyCsrfToken.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
namespace App\Http\Middleware;

use Closure;

/**
 * Class ExceptAppendableVerifyCsrfToken
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ExceptAppendableVerifyCsrfToken extends VerifyCsrfToken
{
    /**
     * Excepted routes
     *
     * @var array
     */
    protected static $staticExcept = [];

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request request
     * @param Closure                  $next    to be called next
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws mixed
     */
    public function handle($request, Closure $next)
    {
        $this->except = array_merge($this->except, static::$staticExcept);

        return parent::handle($request, $next);
    }

    /**
     * Register the route for excepted.
     *
     * @param string $path route path
     * @return void
     */
    public static function setExcept($path)
    {
        static::$staticExcept[] = $path;
        static::$staticExcept = array_unique(static::$staticExcept);
    }

    /**
     * Unregister the route for excepted.
     *
     * @param string $path route path
     * @return void
     */
    public static function unsetExcept($path)
    {
        foreach (static::$staticExcept as $idx => $exceptPath) {
            if ($exceptPath === $path) {
                unset(static::$staticExcept[$idx]);
                break;
            }
        }
    }
}

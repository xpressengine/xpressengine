<?php
/**
 * LangPreprocessor.php
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

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;
use Closure;
use Xpressengine\Http\Request;
use Xpressengine\User\Rating;

/**
 * Class LangPreprocessor
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class LangPreprocessor
{
    /**
     * Application instance
     *
     * @var Application
     */
    private $app;

    /**
     * Map for name
     *
     * @var array
     */
    private $mapSeqName = [];

    /**
     * Map for key
     *
     * @var array
     */
    private $mapSeqKey = [];

    /**
     * Map for multi line
     *
     * @var array
     */
    private $mapSeqMultiLine = [];

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
     * @param Request $request request
     * @param Closure $next    to be called next
     * @return Response
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->has('xe_use_request_preprocessor') && $this->available()) {
            $this->prepare($request);
        }

        /** @var Response $response */
        $response = $next($request);

        if ($request->has('xe_use_request_preprocessor') && $this->available()) {
            $this->conduct($request);
        }

        return $response;
    }

    /**
     * Indicate it is available.
     *
     * @return bool
     */
    private function available()
    {
        return in_array($this->app['auth']->user()->getRating(), [Rating::SUPER, Rating::MANAGER]);
    }

    /**
     * Handle an request before dispatch router.
     *
     * @param Request $request request
     * @return void
     */
    private function prepare($request)
    {
        $fields = $request->all();
        foreach ($fields as $key => $value) {
            if ($params = $this->app['xe.translator']->parsePreprocessor($key)) {
                list($kSeq, $seq, $command) = $params;
                switch ( $command ) {
                    case 'name':
                        $this->mapSeqName[$seq] = $value;
                        break;

                    case 'key':
                        $this->mapSeqKey[$seq] = $value ?: $this->app['xe.translator']->genUserKey();
                        break;

                    case 'multiline':
                        $this->mapSeqMultiLine[$seq] = $value;
                        break;

                    case 'locale':
                        $name = $this->mapSeqName[$seq];
                        $key = $this->mapSeqKey[$seq];
                        $request->merge([$name => $key]);
                        break;
                }
            }
        }
    }

    /**
     * Handle an request after dispatch router.
     *
     * @param Request $request request
     * @return void
     */
    private function conduct($request)
    {
        $fields = $request->all();
        foreach ($fields as $key => $value) {
            if ($params = $this->app['xe.translator']->parsePreprocessor($key)) {
                list($kSeq, $seq, $command) = $params;
                if ($command == 'locale') {
                    list($kSeq, $seq, $kLocale, $locale) = $params;
                    $key = $this->mapSeqKey[$seq];
                    $multiLine = isset($mapSeqMultiLine[$seq]);
                    $this->app['xe.translator']->save($key, $locale, $value, $multiLine);
                }
            }
        }
    }
}

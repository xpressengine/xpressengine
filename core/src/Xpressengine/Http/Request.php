<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Http
 * @package     Xpressengine\Http
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Http;

use Closure;
use Illuminate\Config\Repository;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

/**
 * Request 클래스
 *
 * PHP version 7
 *
 * @category    Http
 * @package     Xpressengine\Http
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Request extends \Illuminate\Http\Request
{
    /**
     * 현재 요청이 mobile 페이지의 요청인지 판단하는 resolver
     * 이 클래스는 이 resolver를 사용하여 mobile 페이지 요청인지 판단한다.
     *
     * @var Closure
     */
    protected $mobileResolver;

    /**
     * @var ParameterBag
     */
    protected $originInputSource;

    /**
     * @var Repository
     */
    protected $config;

    /**
     * @var bool
     */
    protected $localeSegment = false;

    /**
     * 현재 요청이 모바일 페이지 요청인지 조회한다.
     * $fromUserAgent가 true일 경우 사용자가 강제로 지정한 모드
     *
     * @param bool $fromUserAgent true일 경우, 브라우저의 user agent만으로 판단한다.
     *
     * @return bool
     */
    public function isMobile($fromUserAgent = false)
    {
        return call_user_func($this->getMobileResolver(), $this, $fromUserAgent);
    }

    /**
     * 브라우저의 user agent만으로 현재 요청이 모바일 페이지 요청인지 조회한다.
     *
     * @return mixed
     */
    public function isMobileByAgent()
    {
        return call_user_func($this->getMobileResolver(), $this, true);
    }

    /**
     * mobile resolver를 지정한다.
     *
     * @param Closure $callback resolver
     *
     * @return void
     */
    public function setMobileResolver(Closure $callback)
    {
        $this->mobileResolver = $callback;
    }

    /**
     * movile resolver를 반환한다.
     *
     * @return Closure
     */
    public function getMobileResolver()
    {
        return $this->mobileResolver ?: function () {
        };
    }

    /**
     * Set Illuminate config
     *
     * @param Repository $config config repository instance
     * @return void
     */
    public function setConfig(Repository $config)
    {
        $this->config = $config;
    }

    /**
     * Check request to manage
     *
     * @return bool
     */
    public function isManageRequest()
    {
        return $this->segment(1) == $this->config->get('xe.routing.settingsPrefix');
    }

    /**
     * Create an Illuminate request from a Symfony instance.
     *
     * @param SymfonyRequest $request request instance
     * @return \Xpressengine\Http\Request
     */
    public static function createFromBase(SymfonyRequest $request)
    {
        $request = parent::createFromBase($request);

        $request->originInputSource = new ParameterBag($request->all());

        return $request;
    }

    /**
     * Get all of the origin input and files for the request.
     *
     * @return array
     */
    public function originAll()
    {
        return $this->originInputSource->all();
    }

    /**
     * Retrieve an origin input item from the request.
     *
     * @param string            $key     input item key
     * @param string|array|null $default default value
     * @return string|array
     */
    public function originInput($key = null, $default = null)
    {
        return Arr::get($this->originAll(), $key, $default);
    }

    /**
     * Get a subset of the origin items from the input data.
     *
     * @param array $keys item keys
     * @return array
     */
    public function originOnly($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = [];

        $input = $this->originAll();

        foreach ($keys as $key) {
            Arr::set($results, $key, Arr::get($input, $key));
        }

        return $results;
    }

    /**
     * Get all of the origin input except for a specified array of items.
     *
     * @param array|mixed $keys item keys
     * @return array
     */
    public function originExcept($keys)
    {
        $keys = is_array($keys) ? $keys : func_get_args();

        $results = $this->originAll();

        Arr::forget($results, $keys);

        return $results;
    }

    /**
     * Get the current path info for the request.
     *
     * @return string
     */
    public function path()
    {
        $path = $this->rawPath();

        if ($this->enabledLocaleSegment()) {
            $locale = $this->getLocale();
            $path = trim(Str::startsWith($path, $locale) ? substr($path, strlen($locale)) : $path, '/');
        }

        return $path;

    }

    /**
     * Get the current raw path info for the request.
     *
     * @return string
     */
    public function rawPath()
    {
        return parent::path();
    }

    /**
     * Get a raw segment from the URI (1 based index).
     *
     * @param int          $index   segment index
     * @param string|null  $default default value
     * @return string|null
     */
    public function rawSegment($index, $default = null)
    {
        return Arr::get($this->rawSegments(), $index - 1, $default);
    }

    /**
     * Get all of the raw segments for the request path.
     *
     * @return array
     */
    public function rawSegments()
    {
        $segments = explode('/', rawurldecode($this->rawPath()));

        return array_values(array_filter($segments, function ($value) {
            return $value !== '';
        }));
    }

    /**
     * Get the locale.
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->enabledLocaleSegment() ? $this->rawSegment(1) : parent::getLocale();
    }

    /**
     * Enables locale segment
     *
     * @return void
     */
    public function enableLocaleSegment()
    {
        $this->localeSegment = true;
    }

    /**
     * Determine if locale segment is enabled
     *
     * @return bool
     */
    public function enabledLocaleSegment()
    {
        return $this->localeSegment === true;
    }
}

<?php

/**
 * TrustProxies.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace App\Http\Middleware;

use Fideloper\Proxy\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class TrustProxies
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array
     */
    protected $proxies;

    /**
     * The current proxy header mappings.
     *
     * @var null|string|int
     */
    protected $headers = Request::HEADER_X_FORWARDED_ALL;
}
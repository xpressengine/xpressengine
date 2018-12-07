<?php
/**
 * EncryptCookies.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * Class EncryptCookies
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array
     */
    protected $except = [
        'locale'
    ];
}

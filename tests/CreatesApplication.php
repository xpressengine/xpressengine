<?php
/**
 * CreatesApplication.php
 *
 * PHP version 7
 *
 * @category    Tests
 * @package     Tests
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

/**
 * Trait CreatesApplication
 *
 * @category    Tests
 * @package     Tests
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}

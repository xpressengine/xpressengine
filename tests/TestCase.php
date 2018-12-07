<?php
/**
 * TestCase.php
 *
 * PHP version 7
 *
 * @category    Tests
 * @package     Tests
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Abstract Class TestCase
 *
 * @category    Tests
 * @package     Tests
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}

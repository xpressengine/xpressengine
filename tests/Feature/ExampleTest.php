<?php
/**
 * ExampleTest.php
 *
 * PHP version 7
 *
 * @category    Tests
 * @package     Tests\Feature
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ExampleTest
 *
 * @category    Tests
 * @package     Tests\Feature
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

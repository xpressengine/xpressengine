<?php
/**
 * Login.php
 *
 * PHP version 7
 *
 * @category    Tests
 * @package     Tests\Browser\Pages
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;
use Laravel\Dusk\Page as BasePage;

/**
 * Class Login
 *
 * @category    Tests
 * @package     Tests\Browser\Pages
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class Login extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/auth/login';
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        $browser->assertPathIs($this->url());
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
        ];
    }
}

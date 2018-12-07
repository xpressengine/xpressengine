<?php
/**
 * Install.php
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
 * Class Install
 *
 * @category    Tests
 * @package     Tests\Browser\Pages
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class Install extends BasePage
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/install';
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

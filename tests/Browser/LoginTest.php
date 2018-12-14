<?php
/**
 * LoginTest.php
 *
 * PHP version 7
 *
 * @category    Tests
 * @package     Tests\Browser
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\Install;
use Tests\Browser\Pages\Login;

/**
 * Class LoginTest
 *
 * @category    Tests
 * @package     Tests\Browser
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class LoginTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     * @group login
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login());
            $browser->waitForText('계정에 로그인');
            $browser->assertSee('계정에 로그인');
            $browser->type('email', 'admin@admin.net');
            $browser->type('password', 'admin');
            $browser->press('로그인');
        });
    }
}

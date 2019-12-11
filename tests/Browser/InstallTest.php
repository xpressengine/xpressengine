<?php
/**
 * InstallTest.php
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
 * Class InstallTest
 *
 * @category    Tests
 * @package     Tests\Browser
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
class InstallTest extends DuskTestCase
{
    /**
     * @group install
     */
    public function testInstall()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Install);

            // 약관 동의
            $browser->pause(1000);
            $browser->press('.step2 a');
            $browser->waitForText('약관');
            $browser->assertSee('약관');
            $browser->press('.agree-area .xe-label-text');
            $browser->press('.__xe_step[data-step="2"] .btn-next');

            // DB & 관리자 정보 입력
            $browser
                ->type('database_host', env('DB_HOST', '127.0.0.1'))
                ->type('database_name', env('DB_DATABASE', 'xe_test'))
                ->type('database_user_name', env('DB_USERNAME', 'xe_test'))
                ->type('database_password', env('DB_PASSWORD', 'xe_test'))
                ->type('admin_email', 'admin@admin.net')
                ->type('admin_login_id', 'admin')
                ->type('admin_display_name', 'admin')
                ->type('admin_password', 'admin')
                ->type('admin_password_confirmation', 'admin');
            $browser->press('.__xe_btn_submit');
        });
    }
    /**
     * A Dusk test example.
     * @group install
     * @return void
     */
    public function testLogin()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(new Login);
            $browser->assertSee('계정에 로그인');
        });
    }
}

<?php
/**
 * DuskTestCase.php
 *
 * PHP version 7
 *
 * @category    Tests
 * @package     Tests
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

/**
 * Abstract Class DuskTestCase
 *
 * @category    Tests
 * @package     Tests
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */
abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication;
    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        if(env('DUSK_STARTDRIVER', true)) {
            static::startChromeDriver();
        }
    }
    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        if(env('DUSK_STARTDRIVER', true)) {
            $options = (new ChromeOptions)->addArguments([
                'no-sandbox',
                'disable-gpu',
                'headless'
            ]);
            return RemoteWebDriver::create(
                env('DUSK_HUB', 'http://localhost:9515'), DesiredCapabilities::chrome()->setCapability(
                    ChromeOptions::CAPABILITY, $options
                )
            );
        } else {
            return RemoteWebDriver::create(
                env('DUSK_HUB', 'http://localhost:9515'), DesiredCapabilities::chrome()
            );
        }
    }
}

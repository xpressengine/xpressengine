<?php
/**
 * ComposerRunTrait.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

use Carbon\Carbon;
use Composer\Console\Application;
use Composer\Util\Platform;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Xpressengine\Plugin\Composer\Composer;

/**
 * Trait ComposerRunTrait
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
trait ComposerRunTrait
{
    /**
     * prepareComposer
     *
     * @return void
     * @throws \Exception
     */
    protected function prepareComposer()
    {
        if (!ini_get('allow_url_fopen')) {
            throw new \Exception(
                'allow_url_fopen is turned off. allow_url_fopen must be enabled in php.ini for executing this command.'
            );
        }

        $files = [
            storage_path('app/composer.plugins.json'),
            base_path('composer.lock'),
            base_path('plugins/'),
            base_path('vendor/'),
            base_path('vendor/composer/installed.json'),
        ];

        // file permission check
        $this->warn(' Checking file permission: ');

        foreach ($files as $file) {
            $type = is_dir($file) ? 'directory' : 'file';
            $this->getOutput()->write(" $file - ");

            if (!is_writable($file)) {
                // [$file] 파일에 쓰기 권한이 없습니다. 플러그인을 설치하기 위해서는 이 파일의 쓰기 권한이 있어야 합니다.
                throw new \Exception(
                    "You have been denied permission to acccess [$file] $type. To install the plugin, you must have write permission to access this this $type."
                );
            } else {
                $this->info("passed");
            }
        }

        // composer home check
        $this->checkComposerHome();
    }
    /**
     * checkComposerHome
     *
     * @return void
     * @throws \Exception
     */
    protected function checkComposerHome()
    {
        $this->line('');
        $this->warn(" Checking COMPOSER_HOME environment variable: ");

        $config = app('xe.config')->get('plugin');
        $home = $config->get('composer_home');

        if ($home) {
            putenv("COMPOSER_HOME=$home");
        } else {
            $home = getenv('COMPOSER_HOME');
        }

        if (Platform::isWindows()) {
            if (!getenv('APPDATA')) {
                throw new \Exception(
                    "COMPOSER_HOME environment variable must be set for composer to run correctly. set the variable to ".route('settings.plugins.setting.show')
                );
            }
        }

        if (!$home) {
            $home = getenv('HOME');
            if (!$home) {
                throw new \Exception(
                    "COMPOSER_HOME environment variable must be set for composer to run correctly. set the variable to ".route('settings.plugins.setting.show')
                );
            }
        }

        $this->info("  passed");
    }

    /**
     * runComposer
     *
     * @param array                       $inputs
     * @param bool                        $skipPlugin
     * @param OutputInterface|string|null $output
     * @return int
     * @throws \Exception
     */
    protected function runComposer($inputs, $skipPlugin = false, $output = null)
    {
        ini_set('memory_limit', '-1');

        if ($skipPlugin) {
            define('__XE_PLUGIN_SKIP__', true);
        }

        $config = app('xe.config')->get('plugin');
        $siteToken = $config->get('site_token');
        if ($siteToken) {
            Composer::setPackagistToken($siteToken);
        }

        if (!$output) {
            $startTime = Carbon::now()->format('YmdHis');
            $output = "logs/composer-$startTime.log";
        }

        if (is_string($output)) {
            $output = new StreamOutput(fopen(storage_path($output), 'a'));
        }

        $application = new Application();
        $application->setAutoExit(false); // prevent `$application->run` method from exitting the script

        return $application->run(new ArrayInput($inputs), $output);
    }
}

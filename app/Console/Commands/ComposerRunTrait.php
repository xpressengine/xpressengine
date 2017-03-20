<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

use Composer\Console\Application;
use Composer\Util\Platform;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\Composer\Composer;

trait ComposerRunTrait
{

    protected function prepareComposer()
    {

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
            $this->output->write(" $file - ");

            if (!is_writable($file)) {
                // [$file] 파일에 쓰기 권한이 없습니다. 플러그인을 설치하기 위해서는 이 파일의 쓰기 권한이 있어야 합니다.
                throw new \Exception("You have been denied permission to acccess [$file] $type. To install the plugin, you must have write permission to access this this $type.");
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
     * @param      $inputs
     * @param bool $updateMode
     *
     * @return int
     * @internal param $path
     * @internal param $command
     *
     */
    protected function runComposer($inputs, $updateMode = true)
    {
        ignore_user_abort(true);
        ini_set('allow_url_fopen', '1');

        $memoryInBytes = function ($value) {
            $unit = strtolower(substr($value, -1, 1));
            $value = (int) $value;
            switch ($unit) {
                case 'g':
                    $value *= 1024;
                // no break (cumulative multiplier)
                case 'm':
                    $value *= 1024;
                // no break (cumulative multiplier)
                case 'k':
                    $value *= 1024;
            }

            return $value;
        };

        $memoryLimit = trim(ini_get('memory_limit'));
        // Increase memory_limit if it is lower than 1GB
        if ($memoryLimit != -1 && $memoryInBytes($memoryLimit) < 1024 * 1024 * 1024) {
            ini_set('memory_limit', '1G');
        }

        $input = new ArrayInput($inputs);
        $application = new Application();
        $application->setAutoExit(false); // prevent `$application->run` method from exitting the script


        if ($updateMode && !defined('__XE_PLUGIN_MODE__')) {
            define('__XE_PLUGIN_MODE__', true);
        }

        Composer::setPackagistToken(config('xe.plugin.packagist.site_token'));
        Composer::setPackagistUrl(config('xe.plugin.packagist.url'));

        $code = $application->run($input);
        return $code;
    }
}

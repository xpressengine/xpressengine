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
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\Composer\Composer;

trait ComposerRunTrait
{

    /**
     * runComposer
     *
     * @param $path
     * @param $command
     *
     * @return int
     */
    protected function runComposer($inputs)
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
        if (!defined('__XE_PLUGIN_MODE__')) {
            define('__XE_PLUGIN_MODE__', true);
        }

        Composer::setPackagistToken(config('xe.plugin.packagist.site_token'));
        Composer::setPackagistUrl(config('xe.plugin.packagist.url'));

        $code = $application->run($input);
        return $code;

        //$composer = $this->findComposer();
        //
        //$process = new Process($composer.' '.$command, $path, null, null, null);
        //
        //$output = $this->getOutput();
        //
        //return $process->run(
        //    function ($type, $line) use ($output) {
        //        $output->write($line);
        //    }
        //);
    }

    /**
     * findComposer
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" composer.phar';
        }

        return 'composer';
    }

}

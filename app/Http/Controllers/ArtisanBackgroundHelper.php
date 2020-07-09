<?php
/**
 * ArtisanBackgroundHelper.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Console\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ProcessUtils;
use Illuminate\Support\Str;
use phpseclib\Net\SSH2;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

/**
 * Trait ArtisanBackgroundHelper
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait ArtisanBackgroundHelper
{
    /**
     * Determine if the php binary is available
     *
     * @return bool
     */
    public function availableProcess()
    {
        return Application::phpBinary() !== false && app('config')->get('xe.console_allow_url_fopen');
    }

    /**
     * Run artisan command
     *
     * @param string   $command    artisan command
     * @param array    $parameters parameters
     * @param callable $callback callback
     * @return void
     */
    public function runArtisan($command, $parameters = [], callable $callback = null)
    {
        app()->terminating(function () use ($command, $parameters, $callback) {
            $result = $this->availableProcess() ?
                $this->runByProcess($command, $parameters) :
                $this->runByApp($command, $parameters);

            if ($callback) {
                call_user_func($callback, $result, $command, $parameters);
            }
        });
    }

    /**
     * Run artisan command on application
     *
     * @param string $command    artisan command
     * @param array  $parameters parameters
     * @return int
     */
    protected function runByApp($command, array $parameters)
    {
        ignore_user_abort(true);

        return Artisan::call($command, $parameters);
    }

    /**
     * Run artisan command by the process
     *
     * @param string $command    artisan command
     * @param array  $parameters parameters
     * @return int
     */
    protected function runByProcess($command, array $parameters)
    {
        $commands = [$command];
        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                $commands = array_merge($commands, array_map(function ($item) use ($key) {
                    return $this->buildProcessParameter($key, $item);
                }, $value));
            } else {
                $commands[] = $this->buildProcessParameter($key, $value);
            }
        }

        $commandLine = Application::formatCommandString(implode(' ', array_filter($commands)));

        if (windows_os()) {
            $commandLine = 'start "" ' . $commandLine;
        } else {
            $commandLine = $commandLine . ' 2>&1 &';
        }

        try {
            return (new Process($commandLine, base_path(), getenv(), null, 3))->run();
        } catch (ProcessTimedOutException $e) {
            // not throw exception
            return 0;
        }
    }

    /**
     * Build the parameter for the process
     *
     * @param string $key   parameter key
     * @param mixed  $value parameter value
     * @return int|null|string
     */
    protected function buildProcessParameter($key, $value)
    {
        if (is_bool($value)) {
            return $value === true ? $key : null;
        }

        $escaped = is_int($value) ? $value : ProcessUtils::escapeArgument($value);

        return Str::startsWith($key, '-') ? $key.'='.$escaped : $escaped;
    }
}

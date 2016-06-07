<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\PluginHandler;

class PluginInstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install new plugin of XpressEngine';

    /**
     * Create a new controller creator command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function fire(PluginHandler $handler)
    {
        // php artisan plugin:install [--activate] <plugin name> [<version>]

        $name = $this->argument('name');

        $version = $this->argument('version') ?: '*';

        $vendor = PluginHandler::PLUGIN_VENDOR_NAME;

        $command = "require $vendor/$name:$version";

        $this->info(PHP_EOL."Running 'composer $command'.".PHP_EOL);

        if($this->runComposer(base_path(), $command) !== 0) {
            throw new \Exception('Plugin Installation was faild.');
        }

        $this->info(PHP_EOL."Plugin '$name' is installed.".PHP_EOL);

        $activate = $this->option('activate');

        if($activate) {
            $this->activatePlugin($name);
            $this->info("Plugin '$name' is activated.".PHP_EOL);
        }
    }

    /**
     * runComposer
     *
     * @param $path
     * @param $command
     *
     * @return int
     */
    protected function runComposer($path, $command)
    {
        $composer = $this->findComposer();

        $process = new Process($composer.' '.$command, $path, null, null, null);

        $output = $this->output;

        return $process->run(
            function ($type, $line) use ($output) {
                $output->write($line);
            }
        );
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

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the plugin'],
            ['version', InputArgument::OPTIONAL, 'The version of the plugin'],
        ];
    }

    protected function getOptions()
    {
        return [
            ['activate', null, InputOption::VALUE_NONE, 'activate installed plugin', null]
        ];
    }

    /**
     * activatePlugin
     *
     * @param $name
     *
     * @return void
     */
    protected function activatePlugin($name)
    {
        /** @var PluginHandler $handler */
        $handler = app('xe.plugin');
        $handler->getAllPlugins(true);

        if ($handler->isActivated($name) === false) {
            $handler->activatePlugin($name);
        }
    }

}

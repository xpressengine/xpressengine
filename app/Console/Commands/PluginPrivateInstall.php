<?php
/**
 * PluginPrivateInstall.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace App\Console\Commands;

/**
 * Class PluginPrivateInstall
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginPrivateInstall extends PluginCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:private_install {name : The name of the plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the plugin in the private folder.';

    /**
     * @return void
     * @throws \Throwable
     */
    public function handle()
    {
        $name = $this->argument('name');
        $path = app('path.privates') . DIRECTORY_SEPARATOR . $name;

        $this->startPrivate(function () use ($name, $path) {
            $this->writeRequire('install', [
                ['name' => $packageName = 'xpressengine-plugin/' . $name, 'version' => '*']
            ]);

            $this->composerUpdate([$packageName]);
        });
    }
}

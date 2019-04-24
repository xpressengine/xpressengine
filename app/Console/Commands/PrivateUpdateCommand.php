<?php
/**
 * PrivateUpdateCommand.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Xpressengine\Plugin\PluginHandler;

/**
 * Class PrivateUpdateCommand
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PrivateUpdateCommand extends ShouldOperation
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'private:update {name : The name of the plugin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the private plugin.';

    /**
     * Execute the console command.
     *
     * @param PluginHandler $handler plugin handler instance
     * @return void
     * @throws \Exception
     */
    public function handle(PluginHandler $handler)
    {
        if (!$plugin = $handler->getPlugin($name = $this->argument('name'))) {
            throw new \Exception("The plugin[$name] is not found.");
        }

        if (!$plugin->isPrivate()) {
            throw new \Exception("The plugin[$name] is not private plugin");
        }

        if ($activated = $plugin->isActivated()) {
            $handler->deactivatePlugin($name);
        }

        $this->info('Unlink plugin');
        $this->output->write('  - Unlinking ... ');
        unlink($plugin->getPath());
        $this->info('done');

        $this->writer->reset()->cleanOperation();
        $this->writer->install($packageName = 'xpressengine-plugin/'.$name, '*');
        $this->writer->write();

        $this->info('Run composer update command');
        $this->line('> composer update');
        $result = $this->composerUpdate([$packageName]);

        if (0 !== $result) {
            throw new \Exception('Fail to run composer update');
        }

        if ($activated) {
            $handler->activatePlugin($name);
        }

        $this->output->success('Plugin is updated.');
    }
}

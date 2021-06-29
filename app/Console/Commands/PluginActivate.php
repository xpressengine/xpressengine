<?php
/**
 * PluginActivate.php
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
 * Class PluginActivate
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginActivate extends PluginCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'plugin:activate
                        {plugin* : The plugin to activate.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Activate a plugin of XpressEngine';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $plugins = $this->getPluginList($this->argument('plugin'));

        foreach ($plugins as $id => $plugin) {
            if ($plugin === null) {
                throw new \Exception('Plugin not found : '.$id);
            }

            if (!$plugin->isActivated()) {
                $this->line("Activating $id");
                $this->handler->activatePlugin($plugin->getId());
                $this->output->success("$id is activated");
            } else {
                $this->output->success("$id is already activated");
            }
        }
    }

    /**
     * Get plugins data.
     *
     * @param array $pluginIds plugin ids
     * @return array
     * @throws \Exception
     */
    protected function getPluginList($pluginIds)
    {
        $collection = $this->handler->getAllPlugins(true);
        return $collection->getList($pluginIds);
    }
}

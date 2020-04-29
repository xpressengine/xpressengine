<?php
/**
 * PluginUninstall.php
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

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;

/**
 * Class PluginUninstall
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginUninstall extends PluginCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'plugin:uninstall
                        {plugin* : The plugin for uninstall}
                        {--f|force : deactivate the plugin if plugin is activated.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall plugin of XpressEngine';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(Filesystem $filesystem)
    {
        $data = $this->getPluginData($this->argument('plugin'));

        // 플러그인 정보 출력
        // 삭제 플러그인 정보
        $this->warn(PHP_EOL."Information of the plugin that should be uninstalled:");
        foreach ($data as $info) {
            $this->line('  '. $info['title'] .' - '. $info['name'].':'.$info['version'].PHP_EOL);
        }

        // 안내 멘트 출력
        // 위 플러그인을 삭제합니다. 플러그인을 삭제하면 사이트가 정상적으로 작동하지 않을 수 있습니다.
        $this->output->warning("Above plugin will be uninstalled. After the plugin is deleted, the site may not work well.");
        if ($this->input->isInteractive() && $this->confirm(
                "Above plugin will be uninstalled.  \r\n ".
                "After the plugin is uninstalled, the site may not work well. \r\n ".
                "It may take up to a few minutes. \r\n ".
                "Do you want to remove the plugin?"
            ) === false
        ) {
            return;
        }

        $this->startPlugin(function () use ($data, &$composed) {
            $this->checkActivated($data);

            // 플러그인 uninstall 실행
            $this->processUninstall($data);

            $stables = Collection::make($data)->filter(function ($info) {
                return !$info['plugin']->hasVendor();
            })->all();

            if (count($stables) > 0) {
                $this->writeRequire('uninstall', $stables);

                $packages = array_pluck($stables, 'name');
                // composer update를 실행합니다. 최대 수분이 소요될 수 있습니다.
                $this->warn('Composer update command is running.. It may take up to a few minutes.');
                $this->line(" composer update --with-dependencies " . implode(' ', $packages));

                $this->composerUpdate($packages);

                // composer 실행을 마쳤습니다.
                $this->warn('Composer update command is finished.' . PHP_EOL);

                $composed = true;
            }
        }, function () {
            $this->printFailedPlugins();
        });

        if (isset($composed)) {
            $this->printChangedPlugins($changed = $this->getChangedPlugins());

            $uninstalled = array_get($changed, 'uninstalled', []);
            if (count($uninstalled) < 1) {
                $this->output->error(
                // $name:$version 플러그인을 삭제하지 못했습니다. 플러그인 간의 의존관계로 인해 삭제가 불가능할 수도 있습니다.
                // 플러그인 간의 의존성을 살펴보시기 바랍니다.
                    "Uninstall failed. Because of the dependencies between plugins, " .
                    "Uninstall may not be able to success. Please check the plugin's dependencies."
                );
            }

            foreach ($uninstalled as $name => $version) {
                $this->output->success("$name:$version plugin is uninstalled");
            }
        }

        $develops = Collection::make($data)->filter(function ($info) {
            return $info['plugin']->hasVendor();
        });

        foreach ($develops as $info) {
            if (!$filesystem->deleteDirectory(plugins_path($info['id']))) {
                $this->output->warning(
                    'Unable to remove ['.$info['name'].'] plugin. Please delete the directory of plugin manually.'
                );
            } else {
                $this->output->success($info['name'] . ":" . $info['version'] . " plugin is uninstalled");
            }
        }

    }

    /**
     * Get plugins data.
     *
     * @param array $plugins plugins
     * @return array
     * @throws \Exception
     */
    protected function getPluginData($plugins)
    {
        $data = [];
        foreach ($plugins as $key) {
            list($id, $version) = $this->parse($key);

            // 플러그인이 이미 설치돼 있는지 검사
            if (!$plugin = $this->handler->getPlugin($id)) {
                // 설치되어 있지 않은 플러그인입니다.
                throw new \Exception('Plugin not found');
            }

            $data[] = [
                'id' => $id,
                'name' => $plugin->getName(),
                'version' => $plugin->getVersion(),
                'title' => $plugin->getTitle(),
                'plugin' => $plugin,
            ];
        }

        return $data;
    }

    /**
     * Check activated.
     *
     * @param array $data data for plugins
     * @return void
     * @throws \Exception
     */
    protected function checkActivated(array $data)
    {
        foreach ($data as $info) {
            if ($info['plugin']->isActivated()) {
                if (!$this->option('force')) {
                    // 활성화된 플러그인은 삭제할 수 없습니다. 비활성화 한 후 삭제하려면 -f or --force 옵션을 사용하십시오.
                    throw new \Exception(
                        'It is not possible to uninstall the active plug-ins. ".
                        "If you want to deactivate plugin before uninstall, please use the -f or --force option.'
                    );
                }

                $this->deactivatePlugin($info['id']);
            }
        }
    }

    /**
     * The process before delete plugin file.
     *
     * @param array $data data for plugins
     * @return void
     * @throws \Exception
     */
    protected function processUninstall(array $data)
    {
        foreach ($data as $info) {
            $this->handler->uninstallPlugin($info['id']);
        }
    }
}

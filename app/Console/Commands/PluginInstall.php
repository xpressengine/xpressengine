<?php
/**
 * PluginInstall.php
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
 * Class PluginInstall
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
class PluginInstall extends PluginCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'plugin:install
                        {plugin* : The plugin for install. if you want specify version then use "plugin:version"}
                        {--activate : Activate the plugin after install}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install new plugin of XpressEngine';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $data = $this->getPluginData($this->argument('plugin'));

        // 플러그인 정보 출력
        // 설치 플러그인 정보
        $this->warn(PHP_EOL."Information of the plugin that should be installed:");
        foreach ($data as $info) {
            $this->line('  '. $info['title'] .' - '. $info['name'].':'.$info['version'].PHP_EOL);
        }
        // 안내 멘트 출력
        if ($this->input->isInteractive() && $this->confirm(
            // 위 플러그인을 다운로드합니다.
            // 위 플러그인이 의존하는 다른 플러그인이 함께 다운로드 될 수 있으며, 수분이 소요될수 있습니다.
            // 플러그인을 다운로드 하시겠습니까?
                "Above plugin will be downloaded. \r\n ".
                "Dependent plugins can be downloaded together. \r\n ".
                "It may take up to a few minutes. Do you want to download the plugin?"
            ) === false
        ) {
            return;
        }

        $this->startPlugin(function () use ($data) {
            $this->writeRequire('install', $data);

            $packages = array_pluck($data, 'name');
            // composer update를 실행합니다. 최대 수 분이 소요될 수 있습니다.
            $this->warn('Composer update command is running.. It may take up to a few minutes.');
            $this->line(" composer update --with-dependencies " . implode(' ', $packages));

            $this->composerUpdate($packages);

            // composer 실행을 마쳤습니다.
            $this->warn('Composer update command is finished.'.PHP_EOL);

        }, function () {
            $this->printFailedPlugins();
        });

        // changed plugin list 정보 출력
        $this->printChangedPlugins($changed = $this->getChangedPlugins());

        $installed = array_get($changed, 'installed', []);
        if (count($installed) < 1) {
            $this->output->error(
            // $name:$version 플러그인을 설치하지 못했습니다. 플러그인 간의 의존관계로 인해 설치가 불가능할 수도 있습니다.
            // 플러그인 간의 의존성을 살펴보시기 바랍니다.
                "Installation failed. Because of the dependencies between plugins, ".
                "Installation may not be able to success. Please check the plugin's dependencies."
            );
        } else {
            $this->activate(array_pluck($data, 'id'));

            foreach ($installed as $name => $version) {
                $this->output->success("$name:$version plugin is installed");
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
            if ($this->handler->getPlugin($id) !== null) {
                // 이미 설치되어 있는 플러그인입니다.
                throw new \Exception('The plugin is already installed.');
            }

            $data[] = $this->getPluginInfo($id, $version);
        }

        return $data;
    }

    /**
     * Activate plugins.
     *
     * @param array $ids plugin ids
     * @return void
     */
    private function activate($ids)
    {
        if ($this->option('activate')) {
            foreach ($ids as $id) {
                $this->activatePlugin($id);
            }
        }
    }
}

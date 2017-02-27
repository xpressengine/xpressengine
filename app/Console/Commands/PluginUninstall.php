<?php

namespace App\Console\Commands;

use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class PluginUninstall extends PluginCommand
{
    /**
     * The console command name.
     * php artisan plugin:install [--without-activate] <plugin name> [<version>]
     * @var string
     */
    protected $signature = 'plugin:uninstall
                        {plugin_id : The plugin id for install}
                        {--deactivate : deactivate the plugin if plugin is activated.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall plugin of XpressEngine';

    /**
     * Execute the console command.
     *
     * @param PluginHandler      $handler
     * @param PluginProvider     $provider
     * @param ComposerFileWriter $writer
     *
     * @return bool|null
     * @throws \Exception
     */
    public function fire(PluginHandler $handler, PluginProvider $provider, ComposerFileWriter $writer)
    {
        $this->init($handler, $provider, $writer);

        // php artisan plugin:uninstall <plugin name>

        $id = $this->argument('plugin_id');

        // 플러그인이 설치돼 있는지 검사
        $plugin = $handler->getPlugin($id);
        if($plugin === null) {
            // 설치되어 있지 않은 플러그인입니다
            throw new \Exception('Plugin not found');
        }

        if(file_exists($plugin->getPath('vendor'))) {
            // 개발모드의 플러그인입니다. 개발모드의 플러그인을 삭제하려면 직접 플러그인 디렉토리를 삭제하시기 바랍니다.
            throw new \Exception('The plugin is in develop mode. To remove a plugin development mode, please delete the directory of plug-in directly.');
        }

        // 설치가능 환경인지 검사
        // - check writable of composer.plugin.json
        if(!is_writable($composerFile = storage_path('app/composer.plugins.json'))) {
            // [$pluginDir] 파일에 쓰기 권한이 없습니다. 플러그인을 삭제하기 위해서는 이 파일의 쓰기 권한이 있어야 합니다.
            throw new \Exception("You have been denied permission to acccess [$composerFile] file. To uninstall the plugin, you must have write permission to access this this file.");
        }

        // - check writable of plugins/ directory
        if(!is_writable($pluginDir = base_path('plugins'))) {
            // [$pluginDir] 디렉토리에 쓰기 권한이 없습니다. 플러그인을 삭제하기 위해서는 이 디렉토리의 쓰기 권한이 있어야 합니다.
            throw new \Exception("You have been denied permission to acccess [$pluginDir] directory. To uninstall the plugin, you must have write permissions to access this directory.");
        }

        $title = $plugin->getTitle();
        $name = $plugin->getName();
        $version = $plugin->getVersion();

        // 플러그인 정보 출력
        // 삭제 플러그인 정보
        $this->warn(PHP_EOL." Information of the plugin that should be uninstalled:");
        $this->line("  $title - $name:$version".PHP_EOL);

        // 안내 멘트 출력
        // 위 플러그인을 삭제합니다. 플러그인을 삭제하면 사이트가 정상적으로 작동하지 않을 수 있습니다.
        $this->output->warning("Above plugin will be uninstalled. After the plugin is deleted, the site may not work well.");
        if ($this->input->isInteractive() && $this->confirm(
                "Above plugin will be uninstalled. After the plugin is uninstalled, the site may not work well. \r\n It may take up to a few minutes. \r\n Do you want to remove the plugin?"
            ) === false
        ) {
            return null;
        }

        if($this->option('deactivate')) {
            $handler->deactivatePlugin($id);
        }

        if($plugin->isActivated()) {
            // 활성화된 플러그인은 삭제할 수 없습니다. 비활성화 한 후 삭제하려면 --deactivate 옵션을 사용하십시오.
            throw new \Exception('It is not possible to uninstall the active plug-ins. If you want to deactivate plugin before uninstall, please use the --deactivate option.');
        }

        // 플러그인 uninstall 실행
        $handler->uninstallPlugin($id);

        // - plugins require info 갱신
        $writer->reset()->cleanOperation();

        // - require에서 삭제할 플러그인 제거
        $writer->uninstall($name, 0)->write();

        $vendorName = PluginHandler::PLUGIN_VENDOR_NAME;

        // composer update실행(composer update --prefer-lowest --with-dependencies xpressengine-plugin/*)
        // composer update를 실행합니다. 최대 수분이 소요될 수 있습니다.
        $this->warn('Composer update command is running.. It may take up to a few minutes.');
        $this->line(" composer update --prefer-lowest --with-dependencies $vendorName/$id");
        $result = $this->runComposer(
            [
                'command' => 'update',
                "--prefer-lowest" => true,
                "--with-dependencies" => true,
                //"--quiet" => true,
                '--working-dir' => base_path(),
                /*'--verbose' => '3',*/
                'packages' => ["$vendorName/$id"]
            ]
        );

        // composer 실행을 마쳤습니다.
        $this->warn('Composer update command is finished.'.PHP_EOL);

        // composer.plugins.json 파일을 다시 읽어들인다.
        $writer->load();

        // changed plugin list 정보 출력
        $changed = $this->getChangedPlugins($writer);
        $this->printChangedPlugins($changed);

        if(array_has($changed, 'uninstalled.'.$name)) {
            // 삭제 성공 문구 출력
            // $title - $name:$version 플러그인을 삭제하였습니다.
            $this->output->success("$title - $name:$version Plugin is uninstalled.");
        } else {
            // $name:$version 플러그인을 삭제하지 못했습니다. 플러그인 간의 의존관계로 인해 삭제가 불가능할 수도 있습니다. 플러그인 간의 의존성을 살펴보시기 바랍니다.
            $this->output->error("Uninstall failed. Because of the dependencies between plugins, Uninstall may not be able to success. Please check the plugin's dependencies.");
        }

    }

}

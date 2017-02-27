<?php

namespace App\Console\Commands;

use Xpressengine\Installer\XpressengineInstaller;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class PluginInstall extends PluginCommand
{
    /**
     * The console command name.
     * php artisan plugin:install [--no-activate] <plugin name> [<version>]
     *
     * @var string
     */
    protected $signature = 'plugin:install
                        {plugin_id : The plugin id for install}
                        {version? : The version of plugin for install}';

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

        // php artisan plugin:install <plugin name> [<version>]

        $id = $this->argument('plugin_id');
        $version = $this->argument('version');

        // 플러그인이 이미 설치돼 있는지 검사
        if ($handler->getPlugin($id) !== null) {
            // 이미 설치되어 있는 플러그인입니다.
            throw new \Exception('The plugin is already installed.');
        }

        // 설치가능 환경인지 검사
        // - check writable of composer.plugin.json
        if (!is_writable($composerFile = storage_path('app/composer.plugins.json'))) {
            // [$composerFile] 파일에 쓰기 권한이 없습니다. 플러그인을 설치하기 위해서는 이 파일의 쓰기 권한이 있어야 합니다.
            throw new \Exception("You have been denied permission to acccess [$composerFile] file. To install the plugin, you must have write permission to access this this file.");
        }

        // - check writable of plugins/ directory
        if (!is_writable($pluginDir = base_path('plugins'))) {
            // [$pluginDir] 디렉토리에 쓰기 권한이 없습니다. 플러그인을 설치하기 위해서는 이 디렉토리의 쓰기 권한이 있어야 합니다.
            throw new \Exception("You have been denied permission to acccess [$pluginDir] directory. To install the plugin, you must have write permissions to access this directory.");
        }

        // 자료실에서 플러그인 정보 조회
        $pluginData = $provider->find($id);

        if ($pluginData === null) {
            // 설치할 플러그인[$id]을 자료실에서 찾지 못했습니다.
            throw new \Exception("Can not find the plugin(".$id.") that should be installed from the Market-place.");
        }

        $title = $pluginData->title;
        $name = $pluginData->name;

        if ($version) {
            $releaseData = $provider->findRelease($id, $version);
            if ($releaseData === null) {
                // 플러그인[$id]의 버전[$version]을 자료실에서 찾지 못했습니다.
                throw new \Exception("Can not find version(".$version.") of the plugin(".$id.") that should be installed from the Market-place.");
            }
        }
        $version = $version ?: $pluginData->latest_release->version;

        // 플러그인 정보 출력
        // 설치 플러그인 정보
        $this->warn(PHP_EOL." Information of the plugin that should be installed:");
        $this->line("  $title - $name:$version".PHP_EOL);

        // 안내 멘트 출력
        if ($this->input->isInteractive() && $this->confirm(
                // 위 플러그인을 다운로드하고 설치합니다. \r\n 위 플러그인이 의존하는 다른 플러그인이 함께 다운로드 될 수 있으며, 수분이 소요될수 있습니다.\r\n 플러그인을 설치하시겠습니까?
                "Above plugin will be downloaded and installed. \r\n Dependent plugins can be installed together. \r\n It may take up to a few minutes. Do you want to install the plugin?"
            ) === false
        ) {
            return null;
        }

        // - plugins require info 갱신
        $writer->reset()->cleanOperation();

        // composer.plugins.json 업데이트
        // - require에 설치할 플러그인 추가
        $writer->install($name, $version, 0)->write();

        $vendorName = PluginHandler::PLUGIN_VENDOR_NAME;

        // composer update실행(composer update --prefer-lowest --with-dependencies xpressengine-plugin/*)
        // composer update를 실행합니다. 최대 수 분이 소요될 수 있습니다.
        $this->warn(' Composer update command is running.. It may take up to a few minutes.');
        $this->line(" composer update --prefer-lowest --with-dependencies $vendorName/*");

        $result = $this->runComposer(
            [
                'command' => 'update',
                "--prefer-lowest" => true,
                "--with-dependencies" => true,
                //"--quiet" => true,
                '--working-dir' => base_path(),
                /*'--verbose' => '3',*/
                'packages' => ["$vendorName/*"]
            ]
        );

        // composer 실행을 마쳤습니다.
        $this->warn('Composer update command is finished.'.PHP_EOL);

        // composer.plugins.json 파일을 다시 읽어들인다.
        $writer->load();
        if (!isset($result) || $result !== 0) {
            $result = false;
            $writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_FAILED);
            $writer->set('xpressengine-plugin.operation.failed', XpressengineInstaller::$failed);
        } else {
            $result = true;
            $writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_SUCCESSED);
        }
        $writer->write();

        // changed plugin list 정보 출력
        $changed = $this->getChangedPlugins($writer);
        $this->printChangedPlugins($changed);

        if($result) {
            if (array_get($changed, 'installed.'.$name) === $version) {
                // 설치 성공 문구 출력
                // $title - $name:$version 플러그인을 설치했습니다.
                $this->output->success("$title - $name:$version plugin is installed");
            } elseif (array_get($changed, 'installed.'.$name)) {
                $this->output->success(
                // $name 플러그인을 설치하였으나 다른 버전(".array_get($changed, 'installed.'.$name).")으로 설치되었습니다. 플러그인 간의 의존관계로 인해 다른 버전으로 설치되었을 가능성이 있습니다. 플러그인 간의 의존성을 살펴보시기 바랍니다.
                    "$name plugin is installed, but installed version(".array_get($changed, 'installed.'.$name).") is defferent to requested because the dependencies between plugins. Please check the plugin's dependencies."
                );
            } else {
                $this->output->error(
                // $name:$version 플러그인을 설치하지 못했습니다. 플러그인 간의 의존관계로 인해 설치가 불가능할 수도 있습니다. 플러그인 간의 의존성을 살펴보시기 바랍니다.
                    "Installation failed. Because of the dependencies between plugins, Installation may not be able to success. Please check the plugin's dependencies."
                );
            }
        } else {
            // 설치 실패한 플러그인을 가져온다.
            $failed = $this->getFailedPlugins($writer);
            $this->printFailedPlugins($failed);

            if(!empty($failed['install']) || !empty($failed['updated'])) {
                $this->output->error(
                    "Installation failed due to paid plugins that I did not purchase."
                );
            }

        }
    }
}

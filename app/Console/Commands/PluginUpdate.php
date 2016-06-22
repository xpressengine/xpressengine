<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class PluginUpdate extends PluginCommand
{
    /**
     * The console command name.
     * php artisan plugin:install [--without-activate] <plugin name> [<version>]
     * @var string
     */
    protected $signature = 'plugin:update
                        {plugin_id : The plugin id for install}
                        {version? : The version of plugin for install}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a plugin of XpressEngine';

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

        // php artisan plugin:update <plugin name> [<version>]

        $id = $this->argument('plugin_id');

        $version = $this->argument('version');

        // 플러그인이 이미 설치돼 있는지 검사
        $plugin = $handler->getPlugin($id);
        if($plugin === null) {
            throw new \Exception('설치되어 있지 않은 플러그인입니다.');
        }

        // 설치가능 환경인지 검사
        // - check writable of composer.plugin.json
        if(!is_writable($composerFile = storage_path('app/composer.plugins.json'))) {
            throw new \Exception("[$composerFile] 파일에 쓰기 권한이 없습니다. 플러그인을 설치하기 위해서는 이 파일의 쓰기 권한이 있어야 합니다.");
        }

        // - check writable of plugins/ directory
        if(!is_writable($pluginDir = base_path('plugins'))) {
            throw new \Exception("[$pluginDir] 디렉토리에 쓰기 권한이 없습니다. 플러그인을 설치하기 위해서는 이 디렉토리의 쓰기 권한이 있어야 합니다.");
        }

        // 자료실에서 플러그인 정보 조회
        $pluginData = $provider->find($id);

        if($pluginData === null) {
            throw new \Exception("설치할 플러그인[$id]을 자료실에서 찾지 못했습니다.");
        }

        $title = $pluginData->title;
        $name = $pluginData->name;

        if($version) {
            $releaseData = $provider->findRelease($id, $version);
            if($releaseData === null) {
                throw new \Exception("플러그인[$id]의 버전[$version]을 자료실에서 찾지 못했습니다.");
            }
        }
        $version = $version ?: $pluginData->latest_release->version;

        // 플러그인 정보 출력
        $this->warn(PHP_EOL." 업데이트 플러그인 정보:");
        $this->line("  $title - $name: {$plugin->getVersion()} -> $version".PHP_EOL);

        // 안내 멘트 출력
        if($this->input->isInteractive() && $this->confirm("위 플러그인을 다운로드하고 업데이트합니다. \r\n 위 플러그인이 의존하는 다른 플러그인이 함께 다운로드 될 수 있으며, 수분이 소요될수 있습니다.\r\n 플러그인을 업데이트하시겠습니까?") === false) {
            return;
        }

        // - plugins require info 갱신
        $writer->resolvePlugins();

        // composer.plugins.json 업데이트
        // - require에 설치할 플러그인 추가
        $writer->addRequire($name, $version);

        // - require list에 '>=' 추가
        // - empty changed
        $writer->setUpdateMode();

        $writer->write();

        $vendorName = PluginHandler::PLUGIN_VENDOR_NAME;

        // composer update실행(composer update --prefer-lowest --with-dependencies xpressengine-plugin/plugin_id)
        $this->warn('composer update를 실행합니다. 최대 수분이 소요될 수 있습니다.');
        $this->line(" composer update --prefer-lowest --with-dependencies $vendorName/*");
        try {
            $this->runComposer(base_path(), "update --prefer-lowest --with-dependencies $vendorName/*");
        } catch (\Exception $e) {
            ;
        }

        $this->warn('composer 실행을 마쳤습니다.'.PHP_EOL);

        // composer.plugins.json 파일을 다시 읽어들인다.
        $writer->reload();

        // changed plugin list 정보 출력
        $changed = $this->getChangedPlugins($writer);
        $this->printChangedPlugins($changed);

        // composer.plugins.json 정리
        // - require list에서 '>=' 제거
        // - empty changed
        $writer->setFixMode();

        // - dependent plugins 갱신
        $writer->resolvePlugins();

        $writer->write();

        // changed plugin들 업데이트
        /*foreach (array_merge($installed, $updated) as $package => $version) {
            list($vendor, $id) = explode('/', $package);
            if($this->option('no-activate') === false) {
                $this->updatePlugin($id);
                $this->activatePlugin($id);
            }
        }*/

        if (array_get($changed, 'updated.'.$name) === $version) {
            // 설치 성공 문구 출력
            $this->output->success("$title - $name:$version 플러그인을 업데이트했습니다.");
        } elseif (array_get($changed, 'updated.'.$name) !== $version) {
            $this->output->warning(
                "$name:$version 플러그인을 업데이트하였으나 다른 버전으로 업데이트되었습니다. 플러그인 간의 의존관계로 인해 다른 버전으로 업데이트되었을 가능성이 있습니다. 플러그인 간의 의존성을 살펴보시기 바랍니다."
            );
        } else {
            $this->output->warning(
                "$name:$version 플러그인을 업데이트하지 못했습니다. 플러그인 간의 의존관계로 인해 업데이트가 불가능할 수도 있습니다. 플러그인 간의 의존성을 살펴보시기 바랍니다."
            );
        }
    }
}

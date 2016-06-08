<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\ComposerFileWriter;
use Xpressengine\Plugin\Exceptions\CannotDeleteActivatedPluginException;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class PluginUninstall extends Command
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
     * Create a new controller creator command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param PluginHandler  $handler
     * @param PluginProvider $provider
     *
     * @return bool|null
     * @throws \Exception
     */
    public function fire(PluginHandler $handler, PluginProvider $provider, ComposerFileWriter $writer, Filesystem $files)
    {
        // php artisan plugin:uninstall <plugin name>

        $id = $this->argument('plugin_id');

        // 플러그인이 설치돼 있는지 검사
        $plugin = $handler->getPlugin($id);
        if($plugin === null) {
            throw new \Exception('설치되어 있지 않은 플러그인입니다.');
        }

        // 설치가능 환경인지 검사
        // - check writable of composer.plugin.json
        if(!is_writable($pluginDir = storage_path('app/composer.plugins.json'))) {
            throw new \Exception("[$pluginDir] 파일에 쓰기 권한이 없습니다. 플러그인을 삭제하기 위해서는 이 파일의 쓰기 권한이 있어야 합니다.");
        }

        // - check writable of plugins/ directory
        if(!is_writable($pluginDir = base_path('plugins'))) {
            throw new \Exception("[$pluginDir] 디렉토리에 쓰기 권한이 없습니다. 플러그인을 삭제하기 위해서는 이 디렉토리의 쓰기 권한이 있어야 합니다.");
        }

        $title = $plugin->getTitle();
        $name = $plugin->getName();
        $version = $plugin->getVersion();

        // 플러그인 정보 출력
        $this->warn(PHP_EOL." 삭제 플러그인 정보:");
        $this->line("  $title - $name:$version".PHP_EOL);

        // 안내 멘트 출력
        $this->output->warning("위 플러그인을 삭제합니다. 플러그인을 삭제하면 사이트가 정상적으로 작동하지 않을 수 있습니다.");
        if($this->confirm("플러그인을 삭제하시겠습니까?") === false) {
            //return;
        }

        if($this->option('deactivate')) {
            $plugin->deactivate();
        }

        // 플러그인 uninstall 실행
        try {
            $handler->deletePlugin($id);
        } catch (CannotDeleteActivatedPluginException $e) {
            $e->setMessage('활성화된 플러그인은 삭제할 수 없습니다. 비활성화 한 후 삭제하려면 --deactivate 옵션을 사용하십시오.');
        }

        // - dependent plugins 갱신
        $writer->resolvePlugins();

        // composer.plugins.json 업데이트
        // - require list에 '>=' 추가
        // - empty changed
        $writer->setUpdateMode();

        // - require, extra.merge-plugin.require에서 삭제할 플러그인 제거
        $writer->removeRequire($name);

        $writer->write();

        // composer update실행(composer update --prefer-lowest --with-dependencies xpressengine-plugin/*)
        $this->warn('composer update를 실행합니다. 최대 수분이 소요될 수 있습니다.');
        $this->line(' composer update --prefer-lowest --with-dependencies xpressengine-plugin/*');
        try {
            $this->runComposer(base_path(), 'update --prefer-lowest --with-dependencies xpressengine-plugin/*');
        } catch (\Exception $e) {
            ;
        }

        $this->warn('composer 실행을 마쳤습니다.'.PHP_EOL);

        // composer.plugins.json 파일을 다시 읽어들인다.
        $writer->reload();

        // changed plugin list 정보 출력
        $installed = $writer->get('extra.xpressengine-plugin.changed.installed', []);
        $updated = $writer->get('extra.xpressengine-plugin.changed.updated', []);
        $uninstalled = $writer->get('extra.xpressengine-plugin.changed.uninstalled', []);

        if(count($installed)) {
            $this->warn('신규 다운로드 플러그인:');
            foreach ($installed as $package => $version) {
                $this->line("  $package:$version");
            }
        }

        if (count($updated)) {
            $this->warn('업데이트 다운로드 플러그인:');
            foreach ($updated as $package => $version) {
                $this->line("  $package:$version");
            }
        }

        // 삭제된 플러그인 목록 출력
        if (count($uninstalled)) {
            $this->warn('삭제된 플러그인 목록:');
            foreach ($uninstalled as $package => $version) {
                $this->line("  $package:$version");
            }
        }

        // composer.plugins.json 정리
        // - require list에서 '>=' 제거
        // - empty changed
        $writer->setFixMode();

        // - dependent plugins 갱신
        $writer->resolvePlugins();

        $writer->write();

        if(!array_has($updated, $name)) {
            $this->output->warning("$name:$version 플러그인을 삭제하지 못했습니다. 플러그인 간의 의존관계로 인해 삭제가 불가능할 수도 있습니다. 플러그인 간의 의존성을 살펴보시기 바랍니다.");
        } else {
            // 삭제 성공 문구 출력
            $this->output->success("$title - $name:$version 플러그인을 삭제하였습니다.");
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
     * activatePlugin
     *
     * @param $pluginId
     *
     * @return void
     */
    protected function activatePlugin($pluginId)
    {
        /** @var PluginHandler $handler */
        $handler = app('xe.plugin');
        $handler->getAllPlugins(true);

        if ($handler->isActivated($pluginId) === false) {
            $handler->activatePlugin($pluginId);
        }
    }

    /**
     * activatePlugin
     *
     * @param $pluginId
     *
     * @return void
     */
    protected function updatePlugin($pluginId)
    {
        /** @var PluginHandler $handler */
        $handler = app('xe.plugin');
        $handler->getAllPlugins(true);
        $handler->updatePlugin($pluginId);
    }



}

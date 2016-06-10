<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\ComposerFileWriter;
use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Plugin\PluginProvider;

class XeUpdate extends Command
{
    /**
     * The console command name.
     * php artisan plugin:install [--without-activate] <plugin name> [<version>]
     *
     * @var string
     */
    protected $signature = 'xe:update
                        {version? : The version of xpressengine for install}
                        {--skip-download : skip downloading update file.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update XpressEngine';

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
     * @param PluginHandler $handler
     * @param PluginProvider $provider
     *
     * @return bool|null
     * @throws \Exception
     */
    public function fire(
        ComposerFileWriter $writer
    ) {
        // php artisan xe:update [version] [--skip-download]

        if (!$this->option('skip-download')) {
            $this->output->caution('업데이트 파일의 다운로드는 아직 지원하지 않습니다. 아래의 안내대로 코어를 업데이트 하십시오.');
            $this->printGuide();
            return;
        }

        // 안내문구 출력



        $writer->resolvePlugins()->setFixMode()->write();

        // composer update실행(composer update --no-dev)
        $this->output->section('composer update를 실행합니다. 최대 수분이 소요될 수 있습니다.');
        $this->line(" composer update --no-dev");
        try {
            $this->runComposer(base_path(), "update --no-dev");
        } catch (\Exception $e) {
            ;
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

    private function printGuide()
    {

        $this->output->section('방법1 - git을 사용하여 Xpressengine을 설치한 경우');
        $this->output->text(
            [
                '1. "git pull origin master"를 실행합니다.',
                '2. "php artisan xe:update --skip-download"를 실행합니다.',
            ]
        );

        $this->output->section('방법2 - installer를 사용하여 Xpressengine을 설치한 경우');
        $this->output->text(
            [
                '1. https://github.com/xpressengine/xpressengine/releases에서 최신 릴리즈 파일을 다운로드 받습니다.',
                '2. XE를 설치한 root 디렉토리에서 다운로드 받은 파일의 압축을 풀어서 덮어씌웁니다.',
                '3. "php artisan xe:update --skip-download"를 실행합니다.',
            ]
        );
        $this->output->newLine();
    }


}

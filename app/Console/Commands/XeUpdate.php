<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Support\Migration;


class XeUpdate extends Command
{
    use ComposerRunTrait;

    /**
     * @var
     */
    protected $migrations;

    /**
     * The console command name.
     * php artisan xe:update [version] [--skip-download]
     *
     * @var string
     */
    protected $signature = 'xe:update
                        {version? : The version of xpressengine for install}
                        {--skip-composer : skip running composer update.}
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
     * @param ComposerFileWriter $writer
     *
     * @return bool|null
     */
    public function fire(ComposerFileWriter $writer) {

        // php artisan xe:update [version] [--skip-download]

        // title
        $this->output->block('Xpressengine을 업데이트합니다.');

        // check option
        if (!$this->option('skip-download')) {
            $this->output->caution('업데이트 파일의 다운로드는 아직 지원하지 않습니다. 아래의 안내대로 코어를 업데이트 하십시오.');
            $this->printGuide();
            return;
        }

        // version 안내
        $installedVersion = trim(file_get_contents(storage_path('app/installed')));
        $this->warn(' 업데이트 버전 정보:');
        $this->output->text("  $installedVersion -> ".__XE_VERSION__);

        // confirm
        if($this->confirm(
                "Xpressengine ver.".__XE_VERSION__."을 업데이트합니다. 최대 수분이 소요될 수 있습니다.\r\n 업데이트 하시겠습니까?"
            ) === false
        ) {
            //return;
        }

        // 플러그인 업데이트 잠금
        $writer->resolvePlugins()->setFixMode()->write();

        // composer update실행(composer update --no-dev)
        if(!$this->option('skip-composer')) {
            $this->output->section('composer update를 실행합니다. 최대 수분이 소요될 수 있습니다.');
            $this->line(" composer update");
            try {
                $this->runComposer(base_path(), "update");
            } catch (\Exception $e) {
                ;
            }
        }

        // migration
        $this->output->section('Xpressengine 마이그레이션을 실행합니다.');
        $this->migrateCore($installedVersion, __XE_VERSION__);

        // mark installed
        $this->markInstalled();

        $this->output->success("Xpressengine을 ver.".__XE_VERSION__."로 업데이트하였습니다");

    }

    /**
     * migrateCore
     *
     * @return void
     */
    private function migrateCore($installedVersion, $newVersion)
    {
        /** @var Filesystem $filesystem */
        $filesystem = app('files');
        $files = $filesystem->files(base_path('migrations'));

        foreach ($files as $file) {
            $name = lcfirst(str_replace('Migration', '', basename($file, '.php')));

            $class = "\\Xpressengine\\Migrations\\".basename($file, '.php');
            $this->migrations[] = $migration = new $class();
            /** @var Migration $migration */
            $this->output->write(" updating $name.. ");
            if($migration->checkUpdated($installedVersion)) {
                $migration->update($installedVersion);
                $this->info("[success]");
            } else {
                $this->warn("[skipped]");
            }
        }
    }

    /**
     * markInstalled
     *
     * @return void
     */
    private function markInstalled()
    {
        file_put_contents(base_path('storage/app/installed'), __XE_VERSION__);
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

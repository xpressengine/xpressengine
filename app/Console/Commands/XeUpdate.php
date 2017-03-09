<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Xpressengine\Interception\InterceptionHandler;
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
    protected $description = 'Update the XpressEngine';

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
     * @param ComposerFileWriter  $writer
     * @param InterceptionHandler $interceptionHandler
     *
     * @return bool|null
     */
    public function fire(ComposerFileWriter $writer, InterceptionHandler $interceptionHandler) {

        // php artisan xe:update [version] [--skip-download]

        // title
        // Xpressengine을 업데이트합니다.
        $this->output->block('Updating Xpressengine.');

        // check option
        if (!$this->option('skip-download')) {
            // 업데이트 파일의 다운로드는 아직 지원하지 않습니다. 아래의 안내대로 코어를 업데이트 하십시오.
            $this->output->caution('Downloading update files does not yet supported. Follow the guide below for update.');
            $this->printGuide();
            return null;
        }

        // version 안내
        $installedVersion = trim(file_get_contents(storage_path('app/installed')));
        //  업데이트 버전 정보:
        $this->warn(' Version information:');
        $this->output->text("  $installedVersion -> ".__XE_VERSION__);

        // confirm
        if($this->input->isInteractive() && $this->confirm(
                // Xpressengine ver.".__XE_VERSION__."을 업데이트합니다. 최대 수분이 소요될 수 있습니다.\r\n 업데이트 하시겠습니까?
                "The Xpressengine ver.".__XE_VERSION__." will be updated. It may take up to a few minutes. \r\nDo you want to update?"
            ) === false
        ) {
            return;
        }

        // 플러그인 업데이트 잠금
        $writer->reset()->write();

        // composer update실행(composer update --no-dev)
        if(!$this->option('skip-composer')) {
            $this->output->section('Composer update command is running.. It may take up to a few minutes.');
            $this->line(" composer update");
            $result = $this->runComposer(['command' => 'update'], false);
        }

        // migration
        $this->output->section('Running migration..');
        $this->migrateCore($installedVersion);

        // clear proxy
        $interceptionHandler->clearProxies();

        // mark installed
        $this->markInstalled();

        $this->output->success("Update the Xpressengine to ver.".__XE_VERSION__.".");

    }

    /**
     * migrateCore
     *
     * @param $installedVersion
     */
    private function migrateCore($installedVersion)
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
            if($migration->checkUpdated($installedVersion) === false) {
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

        $this->output->section('Method 1 - If you have installed the Xpressengine using Git');
        $this->output->text(
            [
                '1. Run "git pull origin master".',
                '2. Run "php artisan xe:update --skip-download".',
            ]
        );

        $this->output->section('Method 2 - If you have installed the XpressEngine using the Installer');
        $this->output->text(
            [
                '1. Download the latest release files from https://github.com/xpressengine/xpressengine/releases.',
                '2. Unzip the downloaded file to the root directory.',
                '3. Run "php artisan xe:update --skip-download".',
            ]
        );
        $this->output->newLine();
    }
}

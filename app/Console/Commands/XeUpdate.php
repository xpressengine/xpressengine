<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Process\Process;
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
        $this->output->block('Update Xpressengine.');

        // check option
        if (!$this->option('skip-download')) {
            $this->output->caution('Download the update file does not yet support. Update the core following the instructions below.');
            $this->printGuide();
            return;
        }

        // version 안내
        $installedVersion = trim(file_get_contents(storage_path('app/installed')));
        $this->warn(' Update version information:');
        $this->output->text("  $installedVersion -> ".__XE_VERSION__);

        // confirm
        if($this->confirm(
                "Update the Xpressengine ver.".__XE_VERSION__.". There is a maximum moisture is applied. \r\nDo you want to update?"
            ) === false
        ) {
            //return;
        }

        // 플러그인 업데이트 잠금
        $writer->resolvePlugins()->setFixMode()->write();

        // composer update실행(composer update --no-dev)
        if(!$this->option('skip-composer')) {
            $this->output->section('Run the composer update. There is a maximum moisture is applied.');
            $this->line(" composer update");
            try {
                $this->runComposer(base_path(), "update");
            } catch (\Exception $e) {
                ;
            }
        }

        // migration
        $this->output->section('Run the migration of the Xpressengine.');
        $this->migrateCore($installedVersion, __XE_VERSION__);

        // clear proxy
        $interceptionHandler->clearProxies();

        // mark installed
        $this->markInstalled();

        $this->output->success("Update the Xpressengine to ver.".__XE_VERSION__.".");

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

        $this->output->section('Method 1 - If you installed the Xpressengine using Git');
        $this->output->text(
            [
                '1. Run the "git pull origin master".',
                '2. Run the "php artisan xe:update --skip-download".',
            ]
        );

        $this->output->section('Method 2 - If you installed the XpressEngine using the Installer');
        $this->output->text(
            [
                '1. Download the latest release files from https://github.com/xpressengine/xpressengine/releases.',
                '2. The file that you downloaded from the root directory where you installed the XE to overwrite unzip.',
                '3. Run the "php artisan xe:update --skip-download".',
            ]
        );
        $this->output->newLine();
    }
}

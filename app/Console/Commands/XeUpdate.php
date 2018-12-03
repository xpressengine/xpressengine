<?php
namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Xpressengine\Installer\XpressengineInstaller;
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
     * @var ComposerFileWriter
     */
    protected $writer;
    /**
     * Create a new controller creator command instance.
     */
    public function __construct(ComposerFileWriter $writer)
    {
        parent::__construct();

        $this->writer = $writer;
    }

    /**
     * Execute the console command.
     *
     * @param ComposerFileWriter  $writer
     * @param InterceptionHandler $interceptionHandler
     *
     * @return bool|null
     */
    public function handle()
    {
        $this->output->block('Updating Xpressengine.');

        // check option
        if (!$this->option('skip-download')) {
            // @todo 다운로드 지원이 되기전까지 옵션이 지정되지 않더라도 처리하지 않음
            // 업데이트 파일의 다운로드는 아직 지원하지 않습니다. 아래의 안내대로 코어를 업데이트 하십시오.
//            $this->output->caution('Downloading update files does not yet supported. Follow the guide below for update.');
//            return null;
        }

        // version 안내
        $installedVersion = trim(file_get_contents(storage_path('app/installed')));
        //  업데이트 버전 정보:
        $this->warn(' Version information:');
        $this->line("  $installedVersion -> ".__XE_VERSION__);

        // confirm
        if ($this->input->isInteractive() && $this->confirm(
                // Xpressengine ver.".__XE_VERSION__."을 업데이트합니다. 최대 수분이 소요될 수 있습니다.\r\n 업데이트 하시겠습니까?
                "The Xpressengine ver.".__XE_VERSION__." will be updated. It may take up to a few minutes. \r\nDo you want to update?"
            ) === false
        ) {
            return;
        }


        $logFile = $this->ready();

        try {
            if (0 !== $this->call('cache:clear')) {
                throw new \Exception('cache clear fail.. check your system.');
            }

            // composer update실행(composer update --no-dev)
            if (!$this->option('skip-composer')) {

                $this->output->section('Checking environment for Composer...');
                $this->prepareComposer();

                $this->output->section('Composer update command is running.. It may take up to a few minutes.');
                $this->line(" composer update");
                $result = $this->runComposer([
                    'command' => 'update',
                    '--working-dir' => base_path(),
                ], false, $logFile);

                $this->writeResult($result);
            }
        } catch (\Exception $e) {
            $fp = fopen(storage_path($logFile), 'a');
            fwrite($fp, sprintf('%s [file: %s, line: %s]', $e->getMessage(), $e->getFile(), $e->getLine()). PHP_EOL);
            fclose($fp);
            $this->writeResult(1);
            throw $e;
        }


        // migration
        $this->output->section('Running migration..');
        $this->migrateCore($installedVersion);

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
            $migration = new $class();
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

    protected function ready()
    {
        // 플러그인 업데이트 잠금
        unlink($this->writer->getPath());
        $this->writer->load();
        $this->writer->reset();

        $this->writer->set("xpressengine-plugin.operation.status", ComposerFileWriter::STATUS_RUNNING);
        $this->writer->set("xpressengine-plugin.operation.core_update", __XE_VERSION__);

        $startTime = Carbon::now()->format('YmdHis');
        $logFile = "logs/core-update-$startTime.log";
        $this->writer->set('xpressengine-plugin.operation.log', $logFile);

        $this->writer->write();

        return $logFile;
    }

    /**
     * writeResult
     *
     * @param $result
     * @return void
     */
    protected function writeResult($result)
    {
        // composer.plugins.json 파일을 다시 읽어들인다.
        $this->writer->load();
        if ($result !== 0) {
            $this->writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_FAILED);
            $this->writer->set('xpressengine-plugin.operation.failed', XpressengineInstaller::$failed);
        } else {
            $this->writer->set('xpressengine-plugin.operation.status', ComposerFileWriter::STATUS_SUCCESSED);
        }
        $this->writer->write();
    }
}

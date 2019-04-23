<?php
/**
 * XeUpdate.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Console\Commands;

use FilesystemIterator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Xpressengine\Foundation\ReleaseProvider;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Support\Migration;


/**
 * Class XeUpdate
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class XeUpdate extends ShouldOperation
{
    /**
     * The console command name.
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

//    /**
//     * ComposerFileWriter instance
//     *
//     * @var ComposerFileWriter
//     */
//    protected $writer;

    /**
     * Filesystem instance
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * ReleaseProvider instance
     *
     * @var ReleaseProvider
     */
    protected $releaseProvider;

    /**
     * Create a new controller creator command instance.
     *
     * @param ComposerFileWriter $writer          ComposerFileWriter instance
     * @param ReleaseProvider    $releaseProvider ReleaseProvider instance
     * @param Filesystem         $filesystem      Filesystem instance
     */
    public function __construct(ComposerFileWriter $writer, ReleaseProvider $releaseProvider, Filesystem $filesystem)
    {
        parent::__construct($writer);

//        $this->writer = $writer;
        $this->filesystem = $filesystem;
        $this->releaseProvider = $releaseProvider;
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     * @throws \Throwable
     */
    public function handle()
    {
        $this->line('///////////////////////////////////');
        $this->output->block('Updating Xpressengine.');
        $this->line('///////////////////////////////////');

        $updateVersion = $this->argument('version') ?: $this->releaseProvider->getLatestCoreVersion();
        $skipDownload = $this->option('skip-download');
        $skipComposer = $this->option('skip-composer');

        if (!in_array($updateVersion, $this->releaseProvider->coreVersions())) {
            throw new \Exception("Unknown version [$updateVersion]");
        }

        // 현재 파일이 업데이트할 버전보다 낮지 않다면 다운로드 하지 않음.
        if (version_compare(__XE_VERSION__, $updateVersion) !== -1) {
            $skipDownload = true;
        }

        if ($skipDownload) {
            $updateVersion = __XE_VERSION__;
        }

        // version 안내
        $installedVersion = trim(file_get_contents(storage_path('app/installed')));
        //  업데이트 버전 정보:
        $this->warn('Version information:');
        $this->line(" $installedVersion -> $updateVersion");

        if (version_compare($installedVersion, $updateVersion) !== -1) {
            throw new \Exception("Version [$updateVersion] is already installed.");
        }

        // confirm
        if ($this->input->isInteractive() && $this->confirm(
                // Xpressengine ver.".$updateVersion."을 업데이트합니다. 최대 수분이 소요될 수 있습니다.\r\n 업데이트 하시겠습니까?
                "The Xpressengine ver.".$updateVersion." will be updated. It may take up to a few minutes. \r\nDo you want to update?"
            ) === false
        ) {
            return;
        }

        if ($this->isLocked()) {
            throw new \Exception('The command is locked. Make sure that another process is running.');
        }

        $this->lock();

        $this->ready($updateVersion);

        try {
            if (0 !== $this->clearCache(true)) {
                throw new \Exception('cache clear fail.. check your system.');
            }

            $tempPath = storage_path('app/temp');
            // download
            if (!$skipDownload) {
                if (!$this->filesystem->isWritable(base_path())) {
                    throw new \Exception('Could not write to project root.');
                }

                $this->output->section('Clone project.');
                $this->output->write(' cloning ... ');

                $this->cloneProject($tempPath);

                $this->info('done');

                $this->output->section('Download.');
                $this->download($updateVersion, $tempPath);

                // download 를 수행하는 경우 반드시 composer 를 실행함.
                $skipComposer = false;
                $workDir = $tempPath;
            } else {
                $workDir = base_path();
            }

            // composer update실행(composer update --no-dev)
            if (!$skipComposer) {
                $this->output->section('Checking environment for Composer.');
                $this->prepareComposer();

                $this->output->section('Composer update command is running.. It may take up to a few minutes.');
                $this->line('> composer update');
                $result = $this->runComposer([
                    'command' => 'update',
                    '--working-dir' => $workDir,
                    '--no-autoloader' => true,
                    '--no-suggest' => true,
                ], true, $this->output);

                if (0 !== $result) {
                    throw new \Exception('Failed to composer update.');
                }
            }

            if (!$skipDownload) {
                $this->output->section('Copy file to project.');
                $this->output->write(' copying ... ');

                $this->filesystem->moveDirectory(base_path('vendor'), base_path('vendor-old'), true);

                $this->filesystem->copyDirectory($tempPath, base_path());
                $this->filesystem->deleteDirectory($tempPath);

                $this->info('done');
            }

            if (!$skipComposer) {
                $this->output->section('Dump autoload.');
                $this->line('> composer dump-autoload');
                $result = $this->runComposer([
                    'command' => 'dump-autoload',
                    '--working-dir' => base_path(),
                ], false, $this->output);

                if (0 !== $result) {
                    throw new \Exception('Failed to composer dump.');
                }
            }

            // migration
            $this->output->section('Running migration..');
            $this->migrateCore($installedVersion);

        } catch (\Exception $e) {
            $this->setFailed($e->getCode());
            throw $e;
        } catch (\Throwable $e) {
            $this->setFailed($e->getCode());
            throw $e;
        } finally {
            $this->unlock();
        }

        // mark installed
        $this->markInstalled($updateVersion);

        $this->setSuccessed();

        if ($this->filesystem->isDirectory(base_path('vendor-old'))) {
            $this->filesystem->deleteDirectory(base_path('vendor-old'));
        }

        $this->output->success("Update the Xpressengine to ver.{$updateVersion}.");
    }

    /**
     * Clone project for update
     *
     * @param string $destination destination dir
     * @return void
     * @throws \Exception
     */
    private function cloneProject($destination)
    {
        if ($this->filesystem->isDirectory($destination)) {
            if (!$this->filesystem->deleteDirectory($destination)) {
                throw new \Exception('Failed to empty directory.');
            }
        }

        $composerJson = 'composer.plugins.json';
        $info = json_decode(file_get_contents($from = storage_path('app/'.$composerJson)), true);
        $plugins = collect(array_get($info, 'require', []))->keys()->map(function ($require) {
            return str_replace('xpressengine-plugin/', '', $require);
        })->all();

        $excepts = collect($this->filesystem->directories(base_path('plugins')))->map(function ($item) {
            return basename($item);
        })->filter(function ($name) use ($plugins) {
            return !in_array($name, $plugins);
        })->map(function ($except) {
            return 'plugins/' . $except;
        })->all();

        $this->copyDirectory(base_path(), $destination, array_merge([
            'storage',
            'node_modules',
        ], $excepts));

        $storageAppPath = 'storage/app';
        if (!$this->filesystem->isDirectory($dir = $destination.'/'.$storageAppPath)) {
            $this->filesystem->makeDirectory($dir, 0777, true);
        }
        $this->filesystem->copy($from, $dir.'/'.$composerJson);
        $this->filesystem->copy($from, $dir.'/installed');
    }

    /**
     * Copy a directory from one location to another.
     *
     * @param string   $directory
     * @param string   $destination
     * @param array    $excepts
     * @param int|null $options
     * @return bool
     *
     * @see \Illuminate\Filesystem\Filesystem::copyDirectory
     */
    protected function copyDirectory($directory, $destination, $excepts = [], $options = null)
    {
        if (! $this->filesystem->isDirectory($directory)) {
            return false;
        }

        $options = $options ?: FilesystemIterator::SKIP_DOTS;

        if (! $this->filesystem->isDirectory($destination)) {
            $this->filesystem->makeDirectory($destination, 0777, true);
        }

        $items = new FilesystemIterator($directory, $options);

        foreach ($items as $item) {
            $target = $destination.'/'.$item->getBasename();

            if ($item->isDir()) {
                $path = $item->getPathname();

                if (in_array($item->getBasename(), $excepts) || Str::startsWith($item->getBasename(), '.')) {
                    continue;
                }

                $ignores = collect($excepts)->filter(function ($except) use ($item) {
                    return Str::startsWith($except, $item->getBasename().'/');
                })->map(function ($except) use ($item) {
                    return substr($except, strlen($item->getBasename().'/'));
                })->all();

                if (!$this->copyDirectory($path, $target, $ignores, $options)) {
                    return false;
                }
            } else {
                if (in_array($item->getBasename(), $excepts) || Str::startsWith($item->getBasename(), '.')) {
                    continue;
                }

                if (!$this->filesystem->copy($item->getPathname(), $target)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Download release file
     *
     * @param string $ver         version
     * @param string $destination destination dir
     * @return void
     * @throws \Exception
     */
    private function download($ver, $destination)
    {
        $updatesPath = storage_path('app/updates');
        $versions = $this->releaseProvider->getUpdatableVersions();
        foreach ($versions as $version) {
            if (version_compare($ver, $version) === -1) {
                break;
            }

            $this->output->write(" Download v{$version} - ");
            $filepath = $this->releaseProvider->download($version, $updatesPath);
            $zip = new \ZipArchive;
            if ($zip->open($filepath) !== true) {
                throw new \Exception("fail to open zip file [$filepath]");
            }

            $zip->extractTo($destination);
            $zip->close();

            $this->filesystem->delete($filepath);

            $this->info('done');
        }

        $this->filesystem->deleteDirectory($updatesPath);
    }

    /**
     * Execute migrations for XE core.
     *
     * @param $installedVersion
     */
    private function migrateCore($installedVersion)
    {
        $files = $this->filesystem->files(base_path('migrations'));

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
     * Mark installed.
     *
     * @param string $ver version
     * @return void
     */
    private function markInstalled($ver)
    {
        file_put_contents(base_path('storage/app/installed'), $ver);
    }

    /**
     * Set ready for update.
     *
     * @param string $ver version
     * @return void
     */
    private function ready($ver)
    {
        $this->writer->reset()->cleanOperation();

        $this->writer->setRunning();
        $this->writer->set('xpressengine-plugin.operation.core_update', $ver);

        $this->writer->write();
    }
}

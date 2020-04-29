<?php
/**
 * XeUpdate.php
 *
 * PHP version 7
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Console\Commands;

use FilesystemIterator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Xpressengine\Foundation\Operator;
use Xpressengine\Foundation\ReleaseProvider;
use Xpressengine\Plugin\Composer\ComposerFileWriter;
use Xpressengine\Support\Migration;

/**
 * Class XeUpdate
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
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
     * ComposerFileWriter instance
     *
     * @var ComposerFileWriter
     */
    protected $writer;

    /**
     * Create a new controller creator command instance.
     *
     * @param Operator           $operator        Operator instance
     * @param ReleaseProvider    $releaseProvider ReleaseProvider instance
     * @param Filesystem         $filesystem      Filesystem instance
     * @param ComposerFileWriter $writer          ComposerFileWriter instance
     */
    public function __construct(
        Operator $operator,
        ReleaseProvider $releaseProvider,
        Filesystem $filesystem,
        ComposerFileWriter $writer
    ) {
        parent::__construct($operator);

        $this->filesystem = $filesystem;
        $this->releaseProvider = $releaseProvider;
        $this->writer = $writer;
    }

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Throwable|\GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $this->output->title('Updating Xpressengine.');

        $updateVersion = $this->argument('version') ?: $this->releaseProvider->getLatestCoreVersion();
        $skipDownload = $this->option('skip-download');
        $skipComposer = $this->option('skip-composer');

        if (!in_array($updateVersion, $this->releaseProvider->coreVersions())) {
            throw new \RuntimeException("Unknown version [$updateVersion]");
        }

        // 현재 파일이 업데이트할 버전보다 낮지 않다면 다운로드 하지 않음.
        if (version_compare(__XE_VERSION__, $updateVersion) !== -1) {
            $skipDownload = true;
        }

        if ($skipDownload) {
            $updateVersion = __XE_VERSION__;
        }

        // version 안내
        $installedVersion = app()->getInstalledVersion();
        //  업데이트 버전 정보:
        $this->warn('Version information:');
        $this->line(" $installedVersion -> $updateVersion");

        if (version_compare($installedVersion, $updateVersion) !== -1) {
            throw new \RuntimeException("Version [$updateVersion] is already installed.");
        }

        // confirm
        if ($this->input->isInteractive() && $this->confirm(
                // Xpressengine ver.".$updateVersion."을 업데이트합니다. 최대 수분이 소요될 수 있습니다.\r\n 업데이트 하시겠습니까?
                "The Xpressengine ver.".$updateVersion." will be updated. It may take up to a few minutes. \r\nDo you want to update?"
            ) === false
        ) {
            return;
        }

        $this->startCore(function ($operator) use ($updateVersion, $skipDownload, $skipComposer, $installedVersion) {
            $operator->version($updateVersion);
            $operator->save();

            $this->writer->reset()->write(true);

            $tempPath = storage_path('app/temp');
            // download
            if (!$skipDownload) {
                if (!$this->filesystem->isWritable(base_path())) {
                    throw new \RuntimeException('Could not write to project root.');
                }

                $this->output->section('Clone project.');
                $this->cloneProject($tempPath);

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
                    throw new \RuntimeException('Composer update failed..', $result);
                }
            }

            if (!$skipDownload) {
                $this->output->section('Merging to project.');
                $this->mergeToProject($tempPath);
            }

            if (!$skipComposer) {
                $this->output->section('Dump autoload.');
                $this->line('> composer dump-autoload');
                $result = $this->runComposer([
                    'command' => 'dump-autoload',
                    '--working-dir' => base_path(),
                ], false, $this->output);

                if (0 !== $result) {
                    throw new \RuntimeException('Failed to composer dump.');
                }
            }

            // migration
            \Artisan::call('cache:clear');
            $this->output->section('Running migration..');
            $this->migrateCore($installedVersion);
        });

        // mark installed
        $this->markInstalled($updateVersion);

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
                throw new \RuntimeException('Failed to empty directory.');
            }
        }

        $sources = ['composer.json', 'composer.lock', 'storage/app/composer.plugins.json', 'vendor', 'plugins'];
        foreach (['composer.user.json', 'privates'] as $item) {
            if (file_exists(base_path($item))) {
                $sources[] = $item;
            }
        }

        foreach ($sources as $item) {
            $this->output->write("  Cloning <info>{$item}</info>: ");
            $source = base_path($item);
            $target = $destination.'/'.$item;
            if (is_dir($source)) {
                $this->filesystem->copyDirectory($source, $target);
            } else {
                if (!$this->filesystem->isDirectory($dir = dirname($target))) {
                    $this->filesystem->makeDirectory($dir, 0777, true);
                }
                $this->filesystem->copy($source, $target);
            }
            $this->output->writeln('done');
        }
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
     * @throws \Exception|\GuzzleHttp\Exception\GuzzleException
     */
    private function download($ver, $destination)
    {
        $updatesPath = storage_path('app/updates');
        $versions = $this->releaseProvider->getUpdatableVersions();
        foreach ($versions as $version) {
            if (version_compare($ver, $version) === -1) {
                break;
            }

            $this->output->write(" Downloading <info>v{$version}</info>: ");
            $filepath = $this->releaseProvider->download($version, $updatesPath);
            $zip = new \ZipArchive;
            if ($zip->open($filepath) !== true) {
                throw new \RuntimeException("fail to open zip file [$filepath]");
            }

            $zip->extractTo($destination);
            $zip->close();

            $this->filesystem->delete($filepath);

            $this->output->writeln('done');
        }

        $this->filesystem->deleteDirectory($updatesPath);
    }

    /**
     * Copy updated files to the project.
     *
     * @param string $source the path for updated
     * @return void
     */
    private function mergeToProject($source)
    {
        $this->output->write(' - Copying <info>vendor</info>: ');
        if ($this->filesystem->isDirectory($newVendorPath = base_path('vendor-new'))) {
            if (!$this->filesystem->deleteDirectory($newVendorPath)) {
                throw new \RuntimeException("Failed to empty directory [$newVendorPath].");
            }
        }
        $this->filesystem->moveDirectory($source.'/vendor', $newVendorPath);
        $this->output->writeln('done');

        $this->output->write(' - Copying <info>core</info>: ');
        $this->copyDirectory($source, base_path(), ['vendor', 'plugins', 'privates', 'storage']);
        $this->output->writeln('done');

        $this->output->write(' - Changing <info>vendor</info>: ');
        $this->filesystem->moveDirectory(base_path('vendor'), base_path('vendor-old'), true);
        $this->filesystem->moveDirectory(base_path('vendor-new'), base_path('vendor'), true);
        $this->output->writeln('done');

        $this->output->write(' - Deleting Unnecessary files: ');
        $this->filesystem->deleteDirectory($source);
        $this->filesystem->deleteDirectory(base_path('vendor-old'));
        $this->output->writeln('done');

        $items = new FilesystemIterator(base_path('vendor/bin'), FilesystemIterator::SKIP_DOTS);
        foreach ($items as $item) {
            if ($item->isFile()) {
                @chmod($item->getPathname(), 0755);
            }
        }
    }

    /**
     * Execute migrations for XE core.
     *
     * @param string $installedVersion installed version
     * @return void
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
        file_put_contents(app()->getInstalledPath(), $ver);
    }
}

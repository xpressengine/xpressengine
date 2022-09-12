<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Filesystem\Filesystem;
use RuntimeException;
use SplFileInfo;
use Symfony\Component\Console\Input\InputArgument;
use Xpressengine\Plugin\Migrations\PluginMigrator;
use Xpressengine\Plugin\PluginEntity;
use Xpressengine\Plugin\PluginHandler;

/**
 * Trait PluginMigrateTrait
 *
 * @package App\Console\Commands
 */
trait PluginMigrateTrait
{
    /**
     * The migrator instance.
     *
     * @var PluginMigrator
     */
    protected $migrator;

    /**
     * @var $handler
     */
    protected $handler;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Create a new migration rollback command instance.
     *
     * @param  PluginMigrator  $migrator
     */
    public function __construct(PluginMigrator $migrator)
    {
        parent::__construct($migrator);

        $this->handler = app(PluginHandler::class);
        $this->filesystem = app(Filesystem::class);
    }

    /**
     * Get the path to the migration directory.
     *
     * @return string
     * @throws Exception
     */
    protected function getMigrationPath()
    {
        $pluginId = $this->argument('plugin');
        $plugin = $this->handler->getPlugin($pluginId);

        if (($plugin instanceof PluginEntity) === false) {
            throw new RuntimeException('Plugin not found');
        }

        $pluginPath = str_replace(base_path().DIRECTORY_SEPARATOR, '', $plugin->getPath());
        $pluginMigrationPath = $pluginPath.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';

        if ($this->filesystem->exists($pluginMigrationPath) === false) {
            throw new RuntimeException('Directory ['.$pluginMigrationPath.'] does not exist');
        }

        return $pluginMigrationPath;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of the plugin'],
        ];
    }

    /**
     * 플러그인의 마이그레이션 파일목록을 확장자 없이 가져옴
     *
     * @return array
     * @throws Exception
     */
    protected function getFileList()
    {
        $fileList = $this->filesystem->allFiles($this->getMigrationPath());

        $fileList = collect($fileList)->map(
            function (SplFileInfo $file) {
                return $file->getBasename('.'.$file->getExtension());
            }
        );

        return $fileList->all();
    }
}
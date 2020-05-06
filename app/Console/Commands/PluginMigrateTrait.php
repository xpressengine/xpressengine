<?php

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Xpressengine\Plugin\Migrations\PluginMigrator;

trait PluginMigrateTrait
{
    /**
     * The migrator instance.
     *
     * @var PluginMigrator
     */
    protected $migrator;

    /**
     * Create a new migration rollback command instance.
     *
     * @param  PluginMigrator  $migrator
     * @return void
     */
    public function __construct(PluginMigrator $migrator)
    {
        parent::__construct($migrator);

        $this->migrator = $migrator;
    }

    /**
     * Get the path to the migration directory.
     *
     * @return string
     */
    protected function getMigrationPath()
    {
        $pluginId = $this->argument('plugin');
        // 플러그인이 이미 설치돼 있는지 검사
        if (!$plugin = app('xe.plugin')->getPlugin($pluginId)) {
            // 설치되어 있지 않은 플러그인입니다.
            throw new \Exception('Plugin not found');
        }

        $migrationPath = str_replace(base_path().DIRECTORY_SEPARATOR, '', $plugin->getPath()).DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';

        if (!app('files')->exists($migrationPath)) {
            throw new \Exception('Directory ['.$migrationPath.'] does not exist');
        }

        return $migrationPath;
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
     * @return array
     * @throws \Exception
     */
    protected function getFileList()
    {
        $fileList = app('files')->allFiles($this->getMigrationPath());

        return collect($fileList)->map(function(\SplFileInfo $file) {
            return $file->getBasename('.' . $file->getExtension());
        })->all();
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Xpressengine\Plugin\PluginHandler;

class PluginMigrateMake extends Command
{

    /**
     * @var PluginHandler
     */
    protected $handler;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:migration {plugin : The name of the plugin.} {name : The name of the migration.}
        {--create= : The table to be created.}
        {--table= : The table to migrate.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create plugin\'s new migration file';

    /**
     * Create a new command instance.
     *
     * @param PluginHandler $handler
     */
    public function __construct(PluginHandler $handler)
    {
        parent::__construct();

        $this->handler = $handler;
    }

    /**
     * Execute the console command.
     *
     * @param Filesystem $filesystem
     * @return mixed
     * @throws \Exception
     */
    public function handle(Filesystem $filesystem)
    {
        $pluginName = $this->argument('plugin');
        // 플러그인이 이미 설치돼 있는지 검사
        if (!$plugin = $this->handler->getPlugin($pluginName)) {
            // 설치되어 있지 않은 플러그인입니다.
            throw new \Exception('Plugin not found');
        }

        $migrationPath = str_replace(base_path().DIRECTORY_SEPARATOR, '', $plugin->getPath()).DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';

        $filesystem = app('files');
        if (!$filesystem->isDirectory($migrationPath)) {
            $filesystem->makeDirectory($migrationPath, 0777, true);
        }

        if (!$filesystem->exists($migrationPath)) {
            throw new \Exception('Cannot make directory ['.$migrationPath.']');
        }

        $this->call('make:migration', [
            'name' => $pluginName.'_'.$this->argument('name'),
            '--path' => $migrationPath,
            '--create' => $this->option('create'),
            '--table' => $this->option('table')
        ]);
    }
}

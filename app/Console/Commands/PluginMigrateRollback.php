<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Xpressengine\Plugin\PluginHandler;

class PluginMigrateRollback extends Command
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
    protected $signature = 'plugin:migrate:rollback {name : The name of the plugin}
                        {--force : Force the operation to run when in production.}
                        {--pretend : Dump the SQL queries that would be run.}
                        {--step= : Force the migrations to be run so they can be rolled back individually.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rollback the plugin\'s last database migration';

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
        $name = $this->argument('name');
        // 플러그인이 이미 설치돼 있는지 검사
        if (!$plugin = $this->handler->getPlugin($name)) {
            // 설치되어 있지 않은 플러그인입니다.
            throw new \Exception('Plugin not found');
        }

        $migrationPath = str_replace(base_path().DIRECTORY_SEPARATOR, '', $plugin->getPath()).DIRECTORY_SEPARATOR.'migrations';

        if (!$filesystem->exists($migrationPath)) {
            throw new \Exception('Directory ['.$migrationPath.'] does not exist');
        }

        $this->call('migrate:rollback', [
            '--path' => $migrationPath,
            '--force' => $this->option('force'),
            '--pretend' => $this->option('pretend'),
            '--step' => $this->option('step'),
        ]);
    }
}

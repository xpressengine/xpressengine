<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Console\Seeds\SeedCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Xpressengine\Plugin\PluginHandler;

class PluginSeed extends Command
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
    protected $signature = 'plugin:seed {plugin : The name of the plugin}
                        {--class= : The class name of the root seeder}
                        {--database= : The database connection to use.}
                        {--force : Force the operation to run when in production.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the plugin\'s database with records';

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
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $pluginId = $this->argument('plugin');
        // 플러그인이 이미 설치돼 있는지 검사
        if (!$plugin = $this->handler->getPlugin($pluginId)) {
            // 설치되어 있지 않은 플러그인입니다.
            throw new \Exception('Plugin not found');
        }
        $pluginClass = new \ReflectionClass($plugin->getClass());
        $className = $this->option('class') ? $this->option('class') : 'DatabaseSeeder';
        $seedClass = $pluginClass->getNamespaceName().'\\Database\\Seeds\\'. $className;

        $this->call('db:seed', [
            '--class' => $seedClass,
            '--database' => $this->option('database'),
            '--force' => $this->option('force'),
        ]);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Database\Console\Seeds\SeederMakeCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Xpressengine\Plugin\PluginHandler;

/**
 * Class PluginSeederMake
 * 이것만 --path 옵션이 없어서 상속받아 직접구현
 * @package App\Console\Commands
 */
class PluginSeederMake extends SeederMakeCommand
{

    /**
     * @var PluginHandler
     */
    protected $handler;

    /**
     * @var Plugin
     */
    protected $plugin;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plugin:make:seeder {plugin : The name of the plugin.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create plugin\'s new seeder class';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files
     * @param Composer $composer
     * @param PluginHandler $handler
     */
    public function __construct(Filesystem $files, Composer $composer, PluginHandler $handler)
    {
        parent::__construct($files, $composer);

        $this->handler = $handler;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $pluginName = $this->argument('plugin');
        // 플러그인이 이미 설치돼 있는지 검사
        if (!$this->plugin = $this->handler->getPlugin($pluginName)) {
            // 설치되어 있지 않은 플러그인입니다.
            throw new \Exception('Plugin not found');
        }

        parent::handle();
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        return 'DatabaseSeeder';
    }

    /**
     * Get the full namespace for a given class, without the class name.
     *
     * @param  string  $name
     * @return string
     */
    protected function getNamespace($name)
    {
        $pluginClass = new \ReflectionClass($this->plugin->getClass());
        return $pluginClass->getNamespaceName().'\\Database\\Seeds';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/database/seeder.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $seedPath = str_replace(base_path().DIRECTORY_SEPARATOR, '', $this->plugin->getPath()).DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'seeds';

        $filesystem = app('files');
        if (!$filesystem->isDirectory($seedPath)) {
            $filesystem->makeDirectory($seedPath, 0777, true);
        }

        if (!$filesystem->exists($seedPath)) {
            throw new \Exception('Cannot make directory ['.$seedPath.']');
        }

        return $seedPath.'/'.$name.'.php';
    }
}

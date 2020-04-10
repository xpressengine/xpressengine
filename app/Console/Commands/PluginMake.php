<?php
/**
 * PluginMake.php
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

/**
 * Class PluginMake
 *
 * @category    Commands
 * @package     App\Console\Commands
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class PluginMake extends MakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:plugin 
        {name : The name of the plugin}
        {vendor : The vendor name. like your name}
        {--namespace= : The namespace of the plugin. use double backslash(\\\\) as delimiter. default "<Vendor>\\\\XePlugin\\\\\<Name>"}
        {--title= : The title of plugin}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new plugin of XpressEngine';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle()
    {
        $name = $this->argument('name');
        $namespace = $this->getNamespace($name, $this->argument('vendor'));

        $title = $this->getTitleInput($name);

        $path = app('path.privates').DIRECTORY_SEPARATOR.$name;

        if ($this->files->isDirectory($path)) {
            $this->setFailed();
            throw new \RuntimeException("Plugin [{$name}] already exists!");
        }

        $this->startPrivate(function () use ($path, $name, $namespace, $title) {
            $this->info('Generating the plugin');
            $this->copyStubDirectory($path);
            $this->makeUsable($path, $name, $namespace, $title);

            $this->writeRequire('install', [
                ['name' => $packageName = 'xpressengine-plugin/'.$name, 'version' => '*']
            ]);

            $this->warn('Composer update command is running.. It may take up to a few minutes.');
            $this->line(" composer update --with-dependencies " . $packageName);

            $this->composerUpdate([$packageName]);

            // composer 실행을 마쳤습니다.
            $this->warn('Composer update command is finished.'.PHP_EOL);


        }, function () use ($path) {
            $this->files->deleteDirectory($path);
        });

        // plugin activate
        $this->activatePlugin($name);


        $this->info("See ./plugins/$name directory.");
        $this->info("Input and modify your plugin information in ./plugins/$name/composer.json file.");
        $this->output->success('Plugin is created and activated successfully.');
    }

    /**
     * Get namespace.
     *
     * @param string $name   plugin name
     * @param string $vendor vendor name
     * @return string
     * @throws \Exception
     */
    protected function getNamespace($name, $vendor)
    {
        if (!$namespace = $this->option('namespace')) {
            $namespace = studly_case($vendor) . '\\XePlugin\\' . studly_case($name);
        }

        // check namespace
        if(!str_contains($namespace, '\\')) {
            throw new \Exception('The namespace must have at least 1 delimiter(\\), use double backslash(\\\\) as delimiter');
        }

        return $namespace;
    }

    /**
     * Get title.
     *
     * @param string $name given name.
     * @return string
     */
    protected function getTitleInput($name)
    {
        return $this->option('title') ?: studly_case($name) . ' plugin';
    }

    /**
     * Get stub path.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__ . '/stubs/plugin';
    }

    /**
     * Make file for plugin by stub.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @param string $title     plugin title
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeUsable($path, $name, $namespace, $title)
    {
        // plugin.php 파일 생성
        $this->makePluginClass($path, $name, $namespace);

        // composer.json 파일 생성
        $this->makeComposerJson($path, $name, $namespace, $title);

        // Controller.php
        $this->makeControllerClass($path, $name, $namespace, $title);

        $this->files->move($path . '/views/index.blade.stub', $path . '/views/index.blade.php');
    }

    /**
     * Make plugin class.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makePluginClass($path, $name, $namespace)
    {
        $search = ['DummyNamespace', 'DummyPluginName'];
        $replace = [$namespace, $name];

        $this->buildFile($path.'/plugin.stub', $search, $replace, $path.'/plugin.php');
    }

    /**
     * Make composer file.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @param string $title     plugin title
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeComposerJson($path, $name, $namespace, $title)
    {
        $namespace = str_replace('\\', '\\\\', $namespace);

        $search = ['DummyNamespace', 'DummyPluginName', 'DummyPluginTitle', 'DummyCoreVer'];
        $replace = [$namespace, $name, $title, '~'.__XE_VERSION__];

        $this->buildFile($path.'/composer.json.stub', $search, $replace, $path.'/composer.json');
    }

    /**
     * Make controller class.
     *
     * @param string $path      path for plugin
     * @param string $name      name
     * @param string $namespace namespace
     * @param string $title     plugin title
     * @return void
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function makeControllerClass($path, $name, $namespace, $title)
    {
        $search = ['DummyNamespace', 'DummyPluginName', 'DummyPluginTitle'];
        $replace = [$namespace, $name, $title];

        $this->buildFile($path.'/src/Controller.stub', $search, $replace, $path.'/src/Controller.php');
    }
}

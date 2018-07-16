<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Xpressengine\Plugin\PluginHandler;

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
     * @return bool|null
     * @throws \Exception
     */
    public function handle()
    {
        $name = $this->argument('name');
        $namespace = $this->getNamespace($name, $this->argument('vendor'));

        $title = $this->getTitleInput($name);

        $this->copyStubDirectory($path = plugins_path($name));

        try {

            $this->makeUsable($path, $name, $namespace, $title);

            // composer update
            $this->runComposerDump($path);

            // plugin activate
            $this->activatePlugin($name);

        } catch (\Exception $e) {
            $this->files->deleteDirectory($path);
            throw $e;
        }

        // print info
        $url = trim(config('app.url'), '/').'/'.config('xe.routing.fixedPrefix').'/'.$name;

        $this->info("Plugin is created and activated successfully.");

        $this->info("See ./plugins/$name directory. And open $url in your browser.");

        $this->info("Input and modify your plugin information in ./plugins/$name/composer.json file.");
    }

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
     * get title
     *
     * @return string
     */
    protected function getTitleInput($name)
    {
        return $this->option('title') ?: studly_case($name) . ' plugin';
    }

    /**
     * get stub path
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__ . '/stubs/plugin';
    }

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

    protected function makePluginClass($path, $name, $namespace)
    {
        $search = ['DummyNamespace', 'DummyPluginName'];
        $replace = [$namespace, $name];

        $this->buildFile($path.'/plugin.stub', $search, $replace, $path.'/plugin.php');
    }
    
    protected function makeComposerJson($path, $name, $namespace, $title)
    {
        $namespace = str_replace('\\', '\\\\', $namespace);
        
        $search = ['DummyNamespace', 'DummyPluginName', 'DummyPluginTitle'];
        $replace = [$namespace, $name, $title];

        $this->buildFile($path.'/composer.json.stub', $search, $replace, $path.'/composer.json');
    }

    protected function makeControllerClass($path, $name, $namespace, $title)
    {
        $search = ['DummyNamespace', 'DummyPluginName', 'DummyPluginTitle'];
        $replace = [$namespace, $name, $title];

        $this->buildFile($path.'/src/Controller.stub', $search, $replace, $path.'/src/Controller.php');
    }

    protected function activatePlugin($name)
    {
        /** @var PluginHandler $handler */
        $handler = app('xe.plugin');
        $handler->getAllPlugins(true);

        if ($handler->isActivated($name) === false) {
            $handler->activatePlugin($name);
        }
    }

}

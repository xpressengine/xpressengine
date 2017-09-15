<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\PluginHandler;

class PluginMake extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:plugin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new plugin of XpressEngine';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        // get plugin name, namespace, path
        $name = $this->getPluginName();
        $namespace = $this->getNamespace();
        $title = $this->getTitleInput();
        $path = app('xe.plugin')->getPluginsDir().'/'.$name;

        if($this->checkEnv($path, $name, $namespace, $title) === false) {
            return false;
        }

        try {
            // plugin.php 파일 생성
            $this->makePluginClass($path, $name, $namespace, $title);

            // composer.json 파일 생성
            $this->makeComposerJson($path, $name, $namespace, $title);

            // directory structure 생성
            $this->makeDirectoryStructure($path);

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

    protected function checkEnv($path, $name, $namespace, $title)
    {
        // check directory exists
        if ($this->files->exists($path)) {
            $this->error('Plugin already exists!');
            return false;
        }

        // check namespace
        if(!str_contains($namespace, '\\')) {
            $this->error('The namespace must have at least 1 delimiter(\\), use double backslash(\\\\) as delimiter');
            return false;
        }

        // check permission
        $pluginsDir = app('xe.plugin')->getPluginsDir();
        if (!$this->files->isWritable($pluginsDir)) {
            $this->error("Permission denied. Can not create plugin directory($path).");
            return false;
        }
    }

    /**
     * makePluginClass
     *
     * @param $path
     * @param $name
     * @param $namespace
     *
     * @return void
     */
    protected function makePluginClass($path, $name, $namespace, $title)
    {
        $filename = 'plugin.php';

        $code = $this->buildPluginCode($name, $namespace, $title);

        $this->makeDirectory($path);

        $this->files->put($path.'/'.$filename, $code);
    }

    /**
     * makeDirectory
     *
     * @param $path
     *
     * @return void
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }
    }

    /**
     * findComposer
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" composer.phar';
        }

        return 'composer';
    }

    /**
     * Build the class with the given name.
     *
     * @return string
     */
    protected function buildPluginCode($pluginName, $namespace, $title)
    {
        $stub = $this->files->get($this->getStub('plugin.stub'));

        $this->replaceNamespace($stub, $namespace)->replaceClass($stub, 'Plugin')->replacePluginName(
            $stub,
            $pluginName
        )->replacePluginTitle(
            $stub,
            $title
        );

        return $stub;
    }

    /**
     * makeComposerJson
     *
     * @param $path
     * @param $pluginName
     * @param $namespace
     *
     * @return void
     */
    protected function makeComposerJson($path, $pluginName, $namespace, $title)
    {
        $filename = 'composer.json';

        $code = $this->buildComposerCode($pluginName, $namespace, $title);

        $this->makeDirectory($path);

        $this->files->put($path.'/'.$filename, $code);
    }

    /**
     * buildComposerCode
     *
     * @param $pluginName
     * @param $namespace
     *
     * @return string
     */
    protected function buildComposerCode($pluginName, $namespace, $title)
    {
        $stub = $this->files->get($this->getStub('composer.json.stub'));

        $namespace = str_replace('\\', '\\\\', $namespace);

        $this->replaceNamespace($stub, $namespace)->replacePluginName($stub, $pluginName)->replacePackageName(
            $stub,
            PluginHandler::PLUGIN_VENDOR_NAME
        )->replacePluginTitle(
            $stub,
            $title
        );

        return $stub;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string $stub
     * @param  string $name
     *
     * @return static
     */
    protected function replaceClass(&$stub, $name)
    {
        $stub = str_replace('DummyClass', $name, $stub);

        return $this;
    }

    /**
     * replaceNamespace
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replaceNamespace(&$stub, $namespace)
    {
        $stub = str_replace(
            'DummyNamespace',
            $namespace,
            $stub
        );

        return $this;
    }


    /**
     * replacePackageName
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replacePackageName(&$stub, $packageName)
    {
        $stub = str_replace(
            'DummyPluginPackage',
            $packageName,
            $stub
        );

        return $this;
    }


    /**
     * replacePluginTitle
     *
     * @param string $stub
     *
     * @return $this
     */
    protected function replacePluginTitle(&$stub, $title)
    {
        $stub = str_replace(
            'DummyPluginTitle',
            $title,
            $stub
        );

        return $this;
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string $stub
     * @param  string $pluginName
     *
     * @return static
     */
    protected function replacePluginName(&$stub, $pluginName)
    {
        $stub = str_replace('DummyPluginName', $pluginName, $stub);

        return $this;
    }

    /**
     * Get the full namespace name for a given class.
     *
     * @param  string $name
     *
     * @return string
     */
    protected function getNamespace()
    {
        $namespace = $this->getNamespaceInput();
        $namespace = str_replace('\\\\', '\\', $namespace);
        return trim($namespace, '\\');
    }

    /**
     * getPluginName
     *
     * @return string
     */
    protected function getPluginName()
    {
        return $this->argument('name');
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub($filename)
    {
        return __DIR__.'/stubs/'.$filename;
    }

    /**
     * Get the console command arguments.
     *
     * name, namespace, title
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the plugin'],
            [
                'namespace',
                InputArgument::REQUIRED,
                'The namespace of the plugin. use double backslash(\\\\) as delimiter'
            ],
            ['title', InputArgument::REQUIRED, 'The title of the plugin'],
        ];
    }

    /**
     * Get the desired class namespace from the input.
     *
     * @return string
     */
    protected function getNamespaceInput()
    {
        return $this->argument('namespace');
    }

    /**
     * Get the desired class title from the input.
     *
     * @return string
     */
    protected function getTitleInput()
    {
        return $this->argument('title');
    }

    protected function makeDirectoryStructure($path)
    {
        $defaultDirectories = [
            'src',
            'views',
            'assets'
        ];
        foreach ($defaultDirectories as $dir) {
            $this->makeDirectory($path.'/'.$dir);
        }

        // index.blade.php
        $stub = $this->files->get($this->getStub('index.blade.stub'));
        $this->files->put($path.'/views/index.blade.php', $stub);

        // style.css
        $stub = $this->files->get($this->getStub('style.css.stub'));
        $this->files->put($path.'/assets/style.css', $stub);
    }

    protected function runComposerDump($path)
    {
        $composer = $this->findComposer();
        $commands = [
            $composer.' dump-autoload -d '.$path
        ];

        $process = new Process(implode(' && ', $commands), null, null, null, null);

        $output = $this->output;

        $process->run(
            function ($type, $line) use ($output) {
                $output->write($line);
            }
        );
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

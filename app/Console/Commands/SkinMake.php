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
use ReflectionClass;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\PluginEntity;

class SkinMake extends Command
{
    protected $signature = 'make:skin
                        {path : The path of skin directory started with plugin_id}
                        {target : The target id of this skin}
                        {title : The title of the skin}
                        {--id= : The path of skin class file}
                        {--description= : The description of the skin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new skin';

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    protected $originComposerStr = null;

    protected $attr;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
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
     * @throws \Exception
     */
    public function fire()
    {
        // get plugin info
        $plugin = $this->getPlugin();
        $pluginClass = new ReflectionClass($plugin->getClass());
        $namespace = $pluginClass->getNamespaceName();

        // get skin info
        $path = $this->getPath();
        $skinClass = studly_case(basename($path)).'Skin';
        $skinFile = $this->getSkinFile($plugin, $path, $skinClass); // path_to_skin_dir/Skin.php
        $skinTarget = $this->getSkinTarget();
        $skinId = $this->getSkinId($plugin, $skinClass, $skinTarget); // myplugin@skin
        $skinTitle = $this->getSkinTitle();
        $description = $this->getSkinDescription($skinId, $plugin);
        $skinNamespace = $this->getSkinNamespaceName($namespace);

        $this->attr = compact(
            'plugin',
            'path',
            'pluginClass',
            'namespace',
            'skinClass',
            'skinTarget',
            'skinFile',
            'skinId',
            'skinTitle',
            'description',
            'skinNamespace'
        );

        // print and confirm the information of skin
        if ($this->confirmInfo() === false) {
            return false;
        }

        try {
            $this->copySkinDirectory();
            $this->makeSkinClass();

            // composer.json 파일 수정
            if ($this->registerSkin() === false) {
                throw new \Exception('Writing to composer.json file was failed.');
            }

            $this->runComposerDump($plugin->getPath());
        } catch (\Exception $e) {
            $this->clean();
            throw $e;
        }

        $this->info("Skin is created successfully.");

        //$this->info("See ./plugins/$name directory. And open $url in your browser.");
        //$this->info("Input and modify your plugin information in ./plugins/$name/composer.json file.");
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
     * buildCode
     *
     * @param $stub
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildCode($stub)
    {
        $code = $this->files->get($this->getStub($stub));

        /*
         * DummyNamespace
         * DummyClass
         * DummyPluginId
         * DummySkinDirname
        */

        $this->replaceCode($code, 'DummyNamespace', $this->attr('skinNamespace'))->replaceCode(
                $code,
                'DummyClass',
                $this->attr(
                    'skinClass'
                )
            )->replaceCode($code, 'DummyPluginId', $this->attr('plugin')->getId())->replaceCode(
                $code,
                'DummySkinDirname',
                $this->attr('path')
            );

        return $code;
    }

    /**
     * replaceCode
     *
     * @param $stub
     * @param $search
     * @param $replace
     *
     * @return $this
     */
    protected function replaceCode(&$stub, $search, $replace)
    {
        $stub = str_replace($search, $replace, $stub);
        return $this;
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
     * getSkinId
     *
     * @param PluginEntity $plugin
     * @param string       $class
     * @param string       $skinTarget
     *
     * @return array|string
     * @throws \Exception
     * @internal param $file
     */
    protected function getSkinId(PluginEntity $plugin, $class, $skinTarget)
    {
        $id = $this->option('id');

        if (!$id) {
            $id = $plugin->getId().'@'.strtolower($class);
        } else {
            if (strpos('skin/', $id) === 0) {
                $id = substr($id, 6);
            }

            if (strpos($id, '@') === false) {
                $id = $plugin->getId().'@'.$id;
            }
        }

        $skin = \App::make('xe.skin')->get($skinTarget.'/skin/'.$id);

        if ($skin !== null) {
            throw new \Exception("Skin[$skin] already exists.");
        }

        return $id;
    }

    /**
     * getTargetPlugin
     *
     * @param $file
     *
     * @return PluginEntity
     */
    protected function getPlugin()
    {
        $path = $this->argument('path');
        list($plugin, $path) = explode('/', $path, 2);

        $plugin = app('xe.plugin')->getPlugin($plugin);
        if ($plugin === null) {
            throw new \Exception("Unable to find a plugin to locate the skin file. plugin[$plugin] is not found.");
        }

        return $plugin;
    }

    /**
     * get skin directory
     *
     * @param $file
     *
     * @return PluginEntity
     */
    protected function getPath()
    {
        $path = $this->argument('path');
        list($plugin, $path) = explode('/', $path, 2);

        return $path;
    }

    /**
     * getSkinTitle
     *
     * @return array|string
     */
    protected function getSkinTitle()
    {
        return $this->argument('title');
    }

    /**
     * getSkinTarget
     *
     * @return array|string
     */
    protected function getSkinTarget()
    {
        return $this->argument('target');
    }

    /**
     * getSkinDescription
     *
     * @param $id
     * @param $plugin
     *
     * @return array|string
     */
    protected function getSkinDescription($id, PluginEntity $plugin)
    {
        $description = $this->option('description');
        if (!$description) {
            $description = 'The Skin supported by '.ucfirst($plugin->getId()).' plugin.';
        }
        return $description;
    }

    /**
     * getSkinFile
     *
     * @param PluginEntity $plugin
     * @param              $path
     * @param              $skinClass
     *
     * @return array|string
     * @throws \Exception
     */
    protected function getSkinFile(PluginEntity $plugin, $path, $skinClass)
    {
        $path = $path."/$skinClass.php";
        if (file_exists($plugin->getPath($path))) {
            throw new \Exception("file[$path] already exists.");
        }
        return $path;
    }

    /**
     * @param $namespace
     * @return string
     */
    protected function getSkinNamespaceName($namespace)
    {
        return $namespace.'\\Skins';
    }

    /**
     * confirmInfo
     *
     * @return bool
     */
    protected function confirmInfo()
    {
        $this->info(
            sprintf(
                "[New skin info]
  plugin:\t %s
  path:\t\t %s/%s
  class file:\t %s/%s
  class name:\t %s
  id:\t\t %s/skin/%s
  title:\t %s
  description:\t %s",
                $this->attr['plugin']->getId(),
                $this->attr['plugin']->getId(),
                $this->attr['path'],
                $this->attr['plugin']->getId(),
                $this->attr['skinFile'],
                $this->attr['skinNamespace'].'\\'.$this->attr['skinClass'],
                $this->attr['skinTarget'],
                $this->attr['skinId'],
                $this->attr['skinTitle'],
                $this->attr['description']
            )
        );

        while ($confirm = $this->ask('Do you want to add skin? [yes|no]')) {
            if ($confirm === 'yes') {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * makeSkinClass
     *
     * @throws \Exception
     */
    protected function makeSkinClass()
    {
        $plugin = $this->attr('plugin');
        $skinFile = $this->attr('skinFile');
        $path = $plugin->getPath($skinFile);

        $code = $this->buildCode('skin/skin.stub');

        $this->files->put($path, $code);
    }

    protected function runComposerDump($path)
    {
        $composer = $this->findComposer();
        $commands = [
            $composer.' dump-autoload'
        ];

        $process = new Process(implode(' && ', $commands), $path, null, null, null);

        $output = $this->output;

        $process->run(
            function ($type, $line) use ($output) {
                $output->write($line);
            }
        );
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
     * registerSkin
     *
     * @param $plugin
     * @param $id
     * @param $class
     * @param $title
     * @param $description
     *
     * @return int
     * @throws \Exception
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function registerSkin()
    {
        $plugin = $this->attr('plugin');
        $id = $this->attr('skinTarget').'/skin/'.$this->attr('skinId');
        $class = $this->attr('skinNamespace').'\\'.$this->attr('skinClass');
        $title = $this->attr('skinTitle');
        $description = $this->attr('description');
        $skinFile = $this->attr('skinFile');

        // add component
        $composerStr = $this->files->get($plugin->getPath('composer.json'));
        $this->originComposerStr = $composerStr;
        $json = json_decode($composerStr);
        $component = data_get($json, 'extra.xpressengine.component');
        if (isset($component->$id)) {
            throw new \Exception(sprintf('component[%s] already exists.', $id));
        }
        $component->$id = new \stdClass();
        $component->$id->class = $class;
        $component->$id->name = $title;
        $component->$id->description = $description;
        $json->extra->xpressengine->component = $component;

        // add autoload
        $classmap = data_get($json, 'autoload.classmap', []);
        if (!in_array($skinFile, $classmap)) {
            $classmap[] = $skinFile;
        };
        if (!isset($json->autoload)) {
            $json->autoload = new \stdClass();
        }
        $json->autoload->classmap = $classmap;

        $json = json_format(json_encode($json));

        return $this->files->put($plugin->getPath('composer.json'), $json);
    }

    /**
     * clean
     *
     * @param $file
     * @param $plugin
     * @param $template
     * @param $css
     *
     * @return void
     */
    protected function clean()
    {
        $plugin = $this->attr('plugin');
        $path = $this->attr('path');

        // delete skin path
        if (is_writable($plugin->getPath($path))) {
            $this->files->deleteDirectory($plugin->getPath($path));
        }

        // unregister component from composer.json
        $composerFile = $plugin->getPath('composer.json');
        if ($this->originComposerStr !== null && is_writable($composerFile)) {
            $this->files->put($composerFile, $this->originComposerStr);
        }
    }

    /**
     * attr
     *
     * @param $key
     *
     * @return mixed
     */
    private function attr($key)
    {
        return array_get($this->attr, $key);
    }

    protected function copySkinDirectory()
    {
        $plugin = $this->attr('plugin');
        $path = $plugin->getPath($this->attr('path'));

        if (!$this->files->copyDirectory(__DIR__.'/stubs/skin', $path)) {
            throw new \Exception("Unable to create skin directory[$path]. please check permission.");
        }
        rename($path.'/info.stub', $path.'/info.php');
        rename($path.'/views/index.blade.stub', $path.'/views/index.blade.php');
        unlink($path.'/skin.stub');
    }
}

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

class ThemeMake extends Command
{
    protected $signature = 'make:theme
                        {path : The path of theme directory started with "plugins/"}
                        {title : The title of the theme}
                        {--id= : The path of theme class file}
                        {--description= : The description of the theme}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new theme of XpressEngine';

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
    public function handle()
    {
        // get plugin info
        $plugin = $this->getPlugin();
        $pluginClass = new ReflectionClass($plugin->getClass());
        $namespace = $pluginClass->getNamespaceName();

        // get theme info
        $path = $this->getPath();
        $themeClass = studly_case(str_replace('/',' ',$path));
        $themeFile = $this->getThemeFile($plugin, $path, $themeClass); // path_to_theme_dir/Theme.php
        $themeId = $this->getThemeId($plugin, $themeClass); // myplugin@theme
        $themeTitle = $this->getThemeTitle();
        $description = $this->getThemeDescription($themeId, $plugin);

        $this->attr = compact(
            'plugin',
            'path',
            'pluginClass',
            'namespace',
            'themeClass',
            'themeFile',
            'themeId',
            'themeTitle',
            'description'
        );

        // print and confirm the information of theme
        if($this->confirmInfo() === false){
            return false;
        }

        try {
            $this->copyThemeDirectory();
            $this->makeThemeClass();

            // composer.json 파일 수정
            if($this->registerTheme() === false) {
                throw new \Exception('Writing to composer.json file was failed.');
            }

            $this->runComposerDump($plugin->getPath());

        } catch (\Exception $e) {
            $this->clean();
            throw $e;
        }

        $this->info("Theme is created successfully.");

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
         * DummyThemeDirname
        */

        $this->replaceCode($code, 'DummyNamespace', $this->attr('namespace').'\\Theme')
            ->replaceCode($code, 'DummyClass', $this->attr('themeClass'))
            ->replaceCode($code, 'DummyPluginId', $this->attr('plugin')->getId())
            ->replaceCode($code, 'DummyThemeDirname', $this->attr('path'));

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
     * getThemeId
     *
     * @param PluginEntity $plugin
     * @param              $class
     *
     * @return array|string
     * @throws \Exception
     * @internal param $file
     *
     */
    protected function getThemeId(PluginEntity $plugin, $class)
    {
        $id = $this->option('id');

        if(!$id) {
            $id = $plugin->getId().'@'.strtolower($class);
        } else {
            if(strpos('theme/', $id) === 0) {
                $id = substr($id, 6);
            }

            if(strpos($id, '@') === false) {
                $id = $plugin->getId().'@'.$id;
            }
        }

        $theme = \App::make('xe.theme')->getTheme('theme/'.$id);

        if($theme !== null) {
            throw new \Exception("Theme[$theme] already exists.");
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
        list($pluginsDir, $plugin, $path) = explode('/', $path, 3);

        $plugin = app('xe.plugin')->getPlugin($plugin);
        if($plugin === null) {
            throw new \Exception("Unable to find a plugin to locate the theme file. plugin[$plugin] is not found.");
        }

        return $plugin;
    }

    /**
     * get theme directory
     *
     * @param $file
     *
     * @return PluginEntity
     */
    protected function getPath()
    {
        $path = $this->argument('path');
        list($pluginsDir, $plugin, $path) = explode('/', $path, 3);

        return $path;
    }

    /**
     * getThemeTitle
     *
     * @return array|string
     */
    protected function getThemeTitle()
    {
        return $this->argument('title');
    }

    /**
     * getThemeDescription
     *
     * @param $id
     * @param $plugin
     *
     * @return array|string
     */
    protected function getThemeDescription($id, PluginEntity $plugin)
    {
        $description = $this->option('description');
        if(!$description) {
            $description = 'The Theme supported by '.ucfirst($plugin->getId()).' plugin.';
        }
        return $description;
    }

    /**
     * getThemeFile
     *
     * @param PluginEntity $plugin
     * @param              $path
     * @param              $themeClass
     *
     * @return array|string
     * @throws \Exception
     */
    protected function getThemeFile(PluginEntity $plugin, $path, $themeClass)
    {
        $path = $path."/$themeClass.php";
        if(file_exists($plugin->getPath($path))) {
            throw new \Exception("file[$path] already exists.");
        }
        return $path;
    }

    /**
     * confirmInfo
     *
     * @return bool
     */
    protected function confirmInfo() {
        $this->info(
            sprintf(
                "[New theme info]
  plugin:\t %s
  path:\t\t %s/%s
  class file:\t %s/%s
  class name:\t %s
  id:\t\t theme/%s
  title:\t %s
  description:\t %s",
                $this->attr['plugin']->getId(),
                $this->attr['plugin']->getId(),
                $this->attr['path'],
                $this->attr['plugin']->getId(),
                $this->attr['themeFile'],
                $this->attr['namespace'].'\\'.$this->attr['themeClass'],
                $this->attr['themeId'],
                $this->attr['themeTitle'],
                $this->attr['description']
              )
        );

        while ($confirm = $this->ask('Do you want to add theme? [yes|no]')) {
            if ($confirm === 'yes') {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * makeThemeClass
     *
     * @throws \Exception
     */
    protected function makeThemeClass()
    {
        $plugin = $this->attr('plugin');
        $themeFile = $this->attr('themeFile');
        $path = $plugin->getPath($themeFile);

        $code = $this->buildCode('theme/theme.stub');

        $this->files->put($path, $code);
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
     * registerTheme
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
    protected function registerTheme()
    {
        $plugin = $this->attr('plugin');
        $id = 'theme/'.$this->attr('themeId');
        $class = $this->attr('namespace').'\\Theme\\'.$this->attr('themeClass');
        $title = $this->attr('themeTitle');
        $description = $this->attr('description');
        $themeFile = $this->attr('themeFile');

        // add component
        $composerStr = $this->files->get($plugin->getPath('composer.json'));
        $this->originComposerStr = $composerStr;
        $json = json_decode($composerStr);
        $component = data_get($json, 'extra.xpressengine.component');
        if(isset($component->$id)) {
            throw new \Exception(sprintf('component[%s] already exists.', $id));
        }
        $component->$id = new \stdClass();
        $component->$id->class = $class;
        $component->$id->name = $title;
        $component->$id->description = $description;
        $json->extra->xpressengine->component = $component;

        // add autoload
        $classmap = data_get($json, 'autoload.classmap', []);
        if(!in_array($themeFile, $classmap)) {
            $classmap[] = $themeFile;
        };
        if(!isset($json->autoload)) {
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

        // delete theme path
        if(is_writable($plugin->getPath($path))) {
            $this->files->deleteDirectory($plugin->getPath($path));
        }

        // unregister component from composer.json
        $composerFile = $plugin->getPath('composer.json');
        if($this->originComposerStr !== null && is_writable($composerFile)) {
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

    protected function copyThemeDirectory()
    {
        $plugin = $this->attr('plugin');
        $path = $plugin->getPath($this->attr('path'));

        if(!$this->files->copyDirectory(__DIR__.'/stubs/theme', $path)) {
            throw new \Exception("Unable to create theme directory[$path]. please check permission.");
        }
        rename($path.'/info.stub', $path.'/info.php');
        rename($path.'/views/gnb.blade.stub', $path.'/views/gnb.blade.php');
        rename($path.'/views/theme.blade.stub', $path.'/views/theme.blade.php');
        unlink($path.'/theme.stub');
    }


}

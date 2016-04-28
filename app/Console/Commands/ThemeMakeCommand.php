<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use ReflectionClass;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Process\Process;
use Xpressengine\Plugin\PluginEntity;

class ThemeMakeCommand extends Command
{

    protected $signature = 'make:theme
                        {plugin : The name of target plugin}
                        {class : The class name of theme. except namespace}
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

    protected $srcDir;
    protected $attr;

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
    public function fire()
    {
        // get plugin info
        $plugin = $this->getPlugin();
        $pluginClass = new ReflectionClass($plugin->getClass());
        $namespace = $pluginClass->getNamespaceName();
        $this->resolvePluginSrcDir($plugin, $namespace);

        // get theme info
        $themeClass = ucfirst($this->argument('class')); // Basic
        $themeFile = $this->getThemeFile($plugin, $themeClass); // src/Theme/Basic.php
        $themeId = $this->getThemeId($plugin, $themeClass); // myplugin@basic
        $themeTitle = $this->getThemeTitle();
        $description = $this->getThemeDescription($themeId, $plugin);

        // other files info
        $view = strtolower($themeClass); // basic
        $templateFile = $this->getTemplateFile($view, $plugin); // views/theme/basic.blade.php
        $cssFile = $this->getCssFile($view, $plugin); // assets/theme/basic.css
        $controllerFile = $this->getControllerFile($plugin); // src/Controllers/Theme/ConfigController.php
        $configTemplateFile = $this->getConfigTemplateFile($plugin);

        $configId = $this->getConfigId($plugin, $themeId);

        $this->attr = compact(
            'plugin',
            'pluginClass',
            'namespace',
            'themeClass',
            'themeFile',
            'themeId',
            'themeTitle',
            'description',
            'view',
            'templateFile',
            'cssFile',
            'controllerFile',
            'configTemplateFile',
            'configId'
        );


        // print and confirm the information of theme
        if($this->confirmInfo() === false){
            return false;
        }

        try {
            $this->makeThemeClass();
            $this->makeTemplate();
            $this->makeCss();

            // for config
            $this->makeControllerClass();
            $this->makeConfigTemplate();

            // composer.json 파일 수정
            if($this->registerTheme() === false) {
                throw new \Exception('Writing to composer.json file was failed.');
            }

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
         * DummyPluginNamespace
         * DummyPlugin
         * DummyClass
         * DummyTemplateFile
         * DummyTemplateView
         * DummyCssFile
         * DummyConfigId
         * DummyTitle
        */

        $this->replaceCode($code, 'DummyNamespace', $this->attr('namespace').'\\Theme')
            ->replaceCode($code, 'DummyClass', $this->attr('themeClass'))
            ->replaceCode($code, 'DummyPluginNamespace', $this->attr('pluginClass')->getNamespaceName())
            ->replaceCode($code, 'DummyPluginId', $this->attr('plugin')->getId())
            ->replaceCode($code, 'DummyPluginClass', $this->attr('pluginClass')->getShortName())
            ->replaceCode($code, 'DummyTemplateFile', $this->attr('templateFile'))
            ->replaceCode($code, 'DummyTemplateView', 'views.theme.'.$this->attr('view'))
            ->replaceCode($code, 'DummyCssFile', $this->attr('cssFile'))
            ->replaceCode($code, 'DummyConfigId', $this->attr('configId'))
            ->replaceCode($code, 'DummyTitle', $this->attr('themeTitle'));

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
        $plugin = $this->argument('plugin');

        $plugin = app('xe.plugin')->getPlugin($plugin);
        if($plugin === null) {
            throw new \Exception("Unable to find a plugin to locate the theme file. plugin[$plugin] is not found.");
        }

        return $plugin;
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
            $description = sprintf(
                '%s Theme supported by %s plugin.',
                ucfirst(last(explode('@', $id))), ucfirst($plugin->getId())
            );
        }
        return $description;
    }

    /**
     * getThemeFile
     *
     * @return array|string
     * @throws \Exception
     */
    protected function getThemeFile(PluginEntity $plugin, $themeClass)
    {
        $path = $this->srcDir."/Theme/$themeClass.php";
        if(file_exists($plugin->getPath($path))) {
            throw new \Exception("file[$path] already exists.");
        }
        return $path;
    }

    /**
     * getControllerFile
     *
     * @param PluginEntity $plugin
     *
     * @return string
     * @throws \Exception
     */
    protected function getControllerFile(PluginEntity $plugin)
    {
        $path = $this->srcDir."/Controllers/Theme/ConfigController.php";
        if(file_exists($plugin->getPath($path))) {
            throw new \Exception("file[$path] already exists.");
        }
        return $path;
    }

    /**
     * getTemplatePath
     *
     * @param $id
     * @param $plugin
     *
     * @return string
     * @throws \Exception
     */
    protected function getTemplateFile($view, PluginEntity $plugin)
    {
        $viewFile = 'views/theme/'.$view.'.blade.php';
        if(file_exists($plugin->getPath($viewFile))) {
            throw new \Exception("template file[$viewFile] already exists.");
        }
        return $viewFile;
    }

    /**
     * getConfigTemplateFile
     *
     * @param PluginEntity $plugin
     *
     * @return string
     * @throws \Exception
     */
    protected function getConfigTemplateFile(PluginEntity $plugin)
    {
        $viewFile = 'views/theme/config.blade.php';
        if(file_exists($plugin->getPath($viewFile))) {
            throw new \Exception("template file[$viewFile] already exists.");
        }
        return $viewFile;
    }

    /**
     * getCssPath
     *
     * @param $id
     * @param $plugin
     *
     * @return string
     * @throws \Exception
     */
    protected function getCssFile($view, PluginEntity $plugin)
    {
        $cssFile = 'assets/theme/'.$view.'.css';
        if(file_exists($plugin->getPath($cssFile))) {
            throw new \Exception("css file[$cssFile] already exists.");
        }
        return $cssFile;
    }

    /**
     * confirmInfo
     *
     * @param $plugin
     * @param $namespace
     * @param $themeClass
     * @param $themeFile
     * @param $themeId
     * @param $themeTitle
     * @param $description
     * @param $templateFile
     * @param $cssFile
     * @param $controllerFile
     * @param $configId
     *
     * @return bool
     */
    protected function confirmInfo() {
        $this->info(
            sprintf(
                "[New theme info]
  plugin: %s
  class name: %s
  class file: %s
  id: %s
  title: %s
  description: %s
  template file: %s
  css file: %s,
  config id: %s
  config controller file: %s",
                $this->attr['plugin']->getId(),
                $this->attr['namespace'].'\\'.$this->attr['themeClass'],
                $this->attr['themeFile'],
                $this->attr['themeId'],
                $this->attr['themeTitle'],
                $this->attr['description'],
                $this->attr['templateFile'],
                $this->attr['cssFile'],
                $this->attr['configId'],
                $this->attr['controllerFile']
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
        $namespace = $this->attr('namespace');
        $class = $this->attr('themeClass');
        $path = $plugin->getPath($themeFile);

        $code = $this->buildCode('theme.stub');

        $this->makeDirectory(dirname($path));

        $this->files->put($path, $code);

        if(!class_exists($namespace.'\\Theme\\'.$class)) {
            $this->files->delete($path);
            throw new \Exception("Unable to load the theme class file[$path]. please check autoload setting of composer.json");
        }
    }

    protected function makeControllerClass()
    {
        $plugin = $this->attr('plugin');
        $controllerFile = $this->attr('controllerFile');
        $namespace = $this->attr('namespace');
        $class = 'ConfigController';
        $path = $plugin->getPath($controllerFile);

        $code = $this->buildCode('theme.config.controller.stub');

        $this->makeDirectory(dirname($path));

        $this->files->put($path, $code);

        if(!class_exists($namespace.'\\Controllers\\Theme\\'.$class)) {
            $this->files->delete($path);
            throw new \Exception("Unable to load the theme class file[$path]. please check autoload setting of composer.json");
        }
    }

    protected function makeConfigTemplate()
    {
        $plugin = $this->attr('plugin');
        $configTemplateFile = $this->attr('configTemplateFile');
        $path = $plugin->getPath($configTemplateFile);

        $code = $this->buildCode('theme.config.blade.stub');

        $this->makeDirectory(dirname($path));

        $this->files->put($path, $code);
    }

    /**
     * formatJson
     *
     * @param      $json
     * @param bool $unescapeUnicode
     * @param bool $unescapeSlashes
     *
     * @return string
     */
    public function formatJson($json, $unescapeUnicode = true, $unescapeSlashes = true)
    {
        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '    ';
        $newLine = "\n";
        $outOfQuotes = true;
        $buffer = '';
        $noescape = true;

        for ($i = 0; $i < $strLen; $i++) {
            // Grab the next character in the string
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ('"' === $char && $noescape) {
                $outOfQuotes = !$outOfQuotes;
            }

            if (!$outOfQuotes) {
                $buffer .= $char;
                $noescape = '\\' === $char ? !$noescape : true;
                continue;
            } elseif ('' !== $buffer) {
                if ($unescapeSlashes) {
                    $buffer = str_replace('\\/', '/', $buffer);
                }

                if ($unescapeUnicode && function_exists('mb_convert_encoding')) {
                    // https://stackoverflow.com/questions/2934563/how-to-decode-unicode-escape-sequences-like-u00ed-to-proper-utf-8-encoded-cha
                    $buffer = preg_replace_callback('/(\\\\+)u([0-9a-f]{4})/i', function ($match) {
                        $l = strlen($match[1]);

                        if ($l % 2) {
                            return str_repeat('\\', $l - 1) . mb_convert_encoding(
                                pack('H*', $match[2]),
                                'UTF-8',
                                'UCS-2BE'
                            );
                        }

                        return $match[0];
                    }, $buffer);
                }

                $result .= $buffer.$char;
                $buffer = '';
                continue;
            }

            if (':' === $char) {
                // Add a space after the : character
                $char .= ' ';
            } elseif (('}' === $char || ']' === $char)) {
                $pos--;
                $prevChar = substr($json, $i - 1, 1);

                if ('{' !== $prevChar && '[' !== $prevChar) {
                    // If this character is the end of an element,
                    // output a new line and indent the next line
                    $result .= $newLine;
                    for ($j = 0; $j < $pos; $j++) {
                        $result .= $indentStr;
                    }
                } else {
                    // Collapse empty {} and []
                    $result = rtrim($result);
                }
            }

            $result .= $char;

            // If the last character was the beginning of an element,
            // output a new line and indent the next line
            if (',' === $char || '{' === $char || '[' === $char) {
                $result .= $newLine;

                if ('{' === $char || '[' === $char) {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }
        }

        return $result;
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

        $composerStr = $this->files->get($plugin->getPath('composer.json'));
        $this->originComposerStr = $composerStr;
        $json = json_decode($composerStr, true);
        $component = data_get($json, 'extra.xpressengine.component');
        if(isset($component[$id])) {
            throw new \Exception(sprintf('component[%s] already exists.', $id));
        }
        $component[$id] = [];
        $component[$id]['class'] = $class;
        $component[$id]['name'] = $title;
        $component[$id]['description'] = $description;
        array_set($json, 'extra.xpressengine.component', $component);

        $json = $this->formatJson(json_encode($json));

        return $this->files->put($plugin->getPath('composer.json'), $json);
    }

    /**
     * makeTemplate
     *
     * @param $plugin
     * @param $template
     *
     * @return bool
     */
    protected function makeTemplate()
    {
        $plugin = $this->attr('plugin');
        $file = $plugin->getPath($this->attr('templateFile'));
        $this->makeDirectory(dirname($file));

        return $this->files->copy($this->getStub('theme.blade.stub'), $file);
    }

    /**
     * makeCss
     *
     * @param $plugin
     * @param $css
     *
     * @return bool
     */
    protected function makeCss()
    {
        $plugin = $this->attr('plugin');
        $css = $this->attr('cssFile');
        $file = $plugin->getPath($css);
        $this->makeDirectory(dirname($file));
        return $this->files->copy($this->getStub('theme.css.stub'), $file);
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
        $themeFile  = $this->attr('themeFile');
        $template = $this->attr('templateFile');
        $css = $this->attr('css');
        $controller = $this->attr('controllerFile');
        $configTemplate = $this->attr('configTemplateFile');

        // delete theme class file
        if(is_writable($plugin->getPath($themeFile))) {
            $this->files->delete($plugin->getPath($themeFile));
        }

        // unregister component from composer.json
        $composerFile = $plugin->getPath('composer.json');
        if($this->originComposerStr !== null && is_writable($composerFile)) {
            $this->files->put($composerFile, $this->originComposerStr);
        }

        // delete template file
        $templateFile = $plugin->getPath($template);
        if(is_writable($templateFile)) {
            $this->files->delete($templateFile);
        }

        // delete css file
        $cssFile = $plugin->getPath($css);
        if(is_writable($cssFile)) {
            $this->files->delete($cssFile);
        }

        // delete controller file
        $controllerFile = $plugin->getPath($controller);
        if(is_writable($controllerFile)) {
            $this->files->delete($controllerFile);
        }

        // delete config template file
        $configTemplateFile = $plugin->getPath($configTemplate);
        if(is_writable($configTemplateFile)) {
            $this->files->delete($configTemplateFile);
        }

    }

    /**
     * getConfigId
     *
     * @param $plugin
     * @param $id
     *
     * @return string
     */
    protected function getConfigId(PluginEntity $plugin, $id)
    {
        return $plugin->getId().'@'.$id;
    }

    /**
     * resolvePluginSrcDir
     *
     * @param $plugin
     * @param $namespace
     *
     * @return string
     * @throws \Exception
     */
    private function resolvePluginSrcDir($plugin, $namespace)
    {
        $autoloads = $plugin->getMetaData('autoload.psr-4');
        $srcDir = false;
        foreach ($autoloads as $key => $dir) {
            if (trim($key, '\\') === trim($namespace, '\\')) {
                $srcDir = trim($dir, '/');
            }
        }
        if ($srcDir === false) {
            throw new \Exception(sprintf("Plugin format is wrong. Can not add theme to %s plugin", $plugin->getId()));
        }

        return $this->srcDir = $srcDir;
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


}
